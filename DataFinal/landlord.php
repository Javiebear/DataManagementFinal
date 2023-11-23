<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

    //check if there is an exisint student id being used within this session
    function check_login($con){
        if(isset($_SESSION['l_id'])){
            $id = $_SESSION['l_id'];
            $q = "SELECT * FROM LANDLORD WHERE l_id = '$id' limit 1";

            $result = mysqli_query($con, $q);
            if($result && mysqli_num_rows($result) > 0){
                $tuple = mysqli_fetch_assoc($result);
                return $tuple;
            }
        }

        header("location: userSelection.php");
        die;
    }


    //connecting to the database
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "STUDENTRENT";

    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("error: could not connect to database");
    }
    
    $tuple = check_login($con);

    $l_id = $tuple['l_id'];

?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/landlord.css">
    <title>STUDENTRENT</title>
</head>
<body>
    <header>
        <img class="brand" src="imgs/HousingLogo.png" alt="logo" width = "100" height = "50">
        <nav>
            <ul>
            <li><a></a></li>
            <li><a class="navspace" href="addHouse.php"><b>Add Listing +</b></a></li>
            <li><a class="navspace" href="profileL.php"><b>Profile</b></a></li>
            <li><a class="navspace" href="logout.php"><b>Log Out</b></a></li>
            <li><a></a></li>
            </ul>
        </nav>
    </header>

    
        <div class="label">
            <h1 style="color: #FFFFFF;"> Your Listings: </h1>
        </div>

        <div class="owned">
            <?php
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $dbname = "STUDENTRENT";

                if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
                    die("error: could not connect to database");
                }
            
                $tuple = check_login($con);

                $l_id = $tuple['l_id'];

                $buildingArray = [];
                $imgArray = [];

                $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE l_id = '$l_id'";
                $result = mysqli_query($con, $q);

                if($result){
                    while ($tuple = mysqli_fetch_assoc($result)) {
                        $buildingArray[] = $tuple;
                    }
                }

                $buildingAmt = count($buildingArray);

                $imgCounter = 0;

                for ($i = 0; $i < $buildingAmt; $i++){

                    $b_id=$buildingArray[$i]['b_id'];
                    
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

                    echo("
                    <a href='homeDetailsL.php?b_id={$b_id}'><div class='building'> 
                        
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
                        </div>

                    </div></a>");
                }
            ?>
        </div>
</body>
</html>