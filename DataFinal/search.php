

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/search.css">
    <title>STUDENTRENTSEARCH</title>
</head>
<body>
    <header>
        <img class="brand" src="imgs/HousingLogo.png" alt="logo" width = "100" height = "50">
        <nav>
            <ul>
            <li><a></a></li>
            <li><a class="navspace" href="homePage.php"><b>Home Page</b></a></li>
            <li><a></a></li>
            </ul>
        </nav>
    </header>

    <div class="page">
        <h1 style="color: #FFFFFF;"><center>Quick Search:</center><h2>
        <form class="quickSearch" method="post" action="">
            <input class="option" type="submit" name="noRev" value="No Reviews" >
            <input class="option" type="submit" name="below" value="Rent Below Average" >
        </form >
    </div>


    <div class="label">
        <h1 style="color: #FFFFFF;"> Your Listings: </h1>
    </div>
    <div class="searched">
    <?php
            //shows errors on webpage
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            session_start();

            if(isset($_SESSION['b_id'])){
                unset($_SESSION['b_id']);
            }

            if (isset($_GET['singleBuilding']) && $_GET['singleBuilding'] == 'true') {
                $_SESSION['b_id'] = $b_id;
                
                header("Location: homeDetails.php");
                die;
            }

            //convert search into an array of words
            function convertToWordArray($str){
                $chars = str_split($str);
                $addWord = "";
                $word = [];
                $space = " ";
                $counter = 0;
                $wordLen = 0;

                //count the amount of words there are
                foreach ($chars as $char) {
                    $wordLen++;
                    if ($char == $space) {
                        $counter++;
                    }
                }
                
                //adding individual words to an array
                foreach ($chars as $char) {
                    $wordLen--;
                    if ($char == $space){
                        $word[] = $addWord;
                        $addWord = "";
                        $counter--;
                    }else if(($wordLen == 0) && ($counter == 0)){
                        $addWord = $addWord . $char;
                        $word[] = $addWord;
                    }else if($char == "," || $char == "."){
                        //do nothing
                    }else{
                        $addWord = $addWord . $char;
                    }
                }

                return $word;
            }

            function duplicateCheck( $newArray, $value){
                $bool = false;

                foreach ($newArray as $newArrayValue){
                    if($newArrayValue == $value){
                        $bool = true;
                    }
                }

                return $bool;
            }

            //filters out whatever matches in the search input and building attributes
            function search($search, $array, $con){
                $newArray = [];

                //compare the words with any of the values in the tuple
                for ($i = 0; $i < count($array); $i++){
                    //gets the values that will only be searched
                    $rent = $array[$i]['rent'];
                    $buildingType = $array[$i]['building_type'];
                    $address = $array[$i]['address'];
                    
                    //converts strings into an array of words
                    $searchArray = convertToWordArray($search);
                    $buildingTypeArray = convertToWordArray($buildingType);
                    $addressArray = convertToWordArray($address);

                    //only search with the description, address, and rent
                    for ($j = 0; $j < count($searchArray); $j++){ //a word from the search 
                        for($t = 0; $t < count($buildingTypeArray); $t++){
                            if(strcasecmp($searchArray[$j], $buildingTypeArray[$t]) == 0){
                                if(duplicateCheck($newArray, $array[$i]) == false){
                                    $newArray[] = $array[$i];
                                }
                            }
                        }
                        for($s = 0; $s < count($addressArray); $s++){
                            if(strcasecmp($searchArray[$j],$addressArray[$s]) == 0){
                                if(duplicateCheck($newArray, $array[$i]) == false){
                                    $newArray[] = $array[$i];
                                }
                            }
                        }
                        if($searchArray[$j] == $rent){
                            $newArray[] = $array[$i];
                        }
                    }  
                }

                return $newArray;
            }

            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "STUDENTRENT";

            if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
                die("error: could not connect to database");
            }
            
            $uni = 0;
            $search = "";

            if(isset($_SESSION['uni'])){
                if($_SESSION['uni'] == "Select a University"){
                    $uni = 0;
                }else{
                    $uni = $_SESSION['uni'];
                }
            }

            if(isset($_SESSION['search'])){
                $search = $_SESSION['search'];
            }

            //declaring the arrays being used
            $buildingArray = [];
            $imgArray = [];

            //nothing is submitted
            if ($search=="" && $uni == 0){ 
                $q = "SELECT * FROM BUILDING_DESCRIPTION";
                $result = mysqli_query($con, $q);

                if($result){
                    while ($tuple = mysqli_fetch_assoc($result)) {
                        $buildingArray[] = $tuple;
                    }
            
                }                

            //only the uni is entered
            }else if($search=="" && $uni != 0){ 
                $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE uni = '$uni'";
                $result = mysqli_query($con, $q);

                if($result){
                    while ($tuple = mysqli_fetch_assoc($result)) {
                        $buildingArray[] = $tuple;
                    }
                }
                
            // only search is entered
            }else if($search !="" && $uni == 0){
                $q = "SELECT * FROM BUILDING_DESCRIPTION";
                $result = mysqli_query($con, $q);

                if($result){
                    while ($tuple = mysqli_fetch_assoc($result)) {
                        $filterArray[] = $tuple;
                    }

                    $buildingArray = search($search, $filterArray, $con);

                }

            //everything is entered
            }else{
    
                $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE uni = '$uni'";
                $result = mysqli_query($con, $q);

                if($result){
                    while ($tuple = mysqli_fetch_assoc($result)) {
                        $filterArray[] = $tuple; 
                    }

                    $buildingArray = search($search, $filterArray, $con);

                }
            }

            //quick search view function
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $buildingArray = [];//reset building

                //Below Avg  
                if(isset($_POST['below'])){
                    unset($_POST['noRev']);

                    $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE address IN (SELECT address FROM BUILDINGS_BELOW_AVG)";
                    $result = mysqli_query($con, $q);

                    if($result){
                        while ($tuple = mysqli_fetch_assoc($result)) {
                            $buildingArray[] = $tuple; 
                        }
                    }

                //No Review
                }else if(isset($_POST['noRev'])){
                    unset($_POST['below']);

                    $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE address IN (SELECT address FROM NO_REVIEW)";                    
                    $result = mysqli_query($con, $q);
    
                    if($result){
                        while ($tuple = mysqli_fetch_assoc($result)) {
                            $buildingArray[] = $tuple; 
                        }
                    }
                }
            }

            $buildingAmt = count($buildingArray);

            $imgCounter = 0;
            for ($i = 0; $i < $buildingAmt; $i++){

                $b_id=$buildingArray[$i]['b_id'];

                $address = $buildingArray[$i]['address'];

                //finding the amount of views the building has had
                $q = "SELECT number_of_visits FROM BUILDING_VIEWS WHERE address = '$address'";
                $result = mysqli_query($con, $q);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $viewData = mysqli_fetch_assoc($result);
                    $viewAmount = $viewData['number_of_visits'];
                } else {

                    $viewAmount = 0;
                }
                

                
                //get the first image of the building
                $q = "SELECT img_bin FROM BUILDING_IMGS WHERE b_id = '$b_id'";
                $result = mysqli_query($con, $q);

                $buildingImgs = 0;

                while ($imgs = mysqli_fetch_assoc($result)){
                    $imgArray[] = $imgs['img_bin'];
                    $imgCounter++;
                    $buildingImgs++;
                }

                $imageIndex = $imgCounter - $buildingImgs;

                echo("<a href='homeDetails.php?b_id={$b_id}'>
                <div class='building'> 
                    
                    <div class='buildingImg'>
                        <img src = 'imgs/{$imgArray[$imageIndex]}' alt='Houseimg'>
                    </div>

                    <div class='buildingContent'>
                        <div class='title'>
                            {$buildingArray[$i]['description']}
                        </div>

                        <div class='buildingInfo'>
                            {$buildingArray[$i]['address']}
                        </div>

                        <div class='buildingInfo'> 
                            bedrooms: {$buildingArray[$i]['num_of_bedrooms']}
                        </div>

                        <div class='buildingInfo'>
                            contract: {$buildingArray[$i]['date']}
                        </div>

                        <div class='buildingInfo'>
                            rent: \${$buildingArray[$i]['rent']}
                        </div>

                        <div class='buildingInfo'>
                            Visits: {$viewAmount}
                        </div>
                    </div>

                </div></a>");
            }  
        ?>
    </div>
</body>
</html>