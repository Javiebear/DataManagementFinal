<?php
//shows errors on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    //check if there is an exisint student id being used within this session
    function check_login($con){
        if(isset($_SESSION['s_id'])){

            $id = $_SESSION['s_id'];
            $q = "SELECT * FROM STUDENT WHERE s_id = '$id' limit 1";

            $result = mysqli_query($con, $q);
            if($result && mysqli_num_rows($result) > 0){
                $tuple = mysqli_fetch_assoc($result);
                return $tuple;
            }
        }else if(isset($_SESSION['l_id'])){
            header("Location: landlord.php");
            die;
        }
        
        //go to login if not logged in
        header("Location: userSelection.php");
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

    //search algorithm
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //unseting the search bar
        if(isset($_SESSION['uni'])){
            unset($_SESSION['uni']);
        }
        if(isset($_SESSION['search'])){
            unset($_SESSION['search']);
        }

        //sends the user to the search page with inserted associated values in $_SESSION
        $search = $_POST['search'];
        $uni = $_POST['uni'];
        if(!empty(!(empty($search)) && !(empty($uni)))){
            $_SESSION['search'] = $search;
            $_SESSION['uni'] = $uni;
            header("Location: search.php");
            die;

        }else if(!(empty($search))){
            $_SESSION['search'] = $search;
            header("Location: search.php");
            die;

        }else if(!(empty($uni))){
            $_SESSION['uni'] = $uni;
            header("Location: search.php");
            die;

        }else{
            header("Location: search.php");
            die;

        }
    }

    //universities with houses code
    //finds the amount of houses per university
    function getHouseAmt($uni, $con){
        $q = "SELECT * FROM BUILDINGS_FOR_RENT WHERE u_id = '$uni'";
        $result = mysqli_query($con, $q);
        $tuple = mysqli_fetch_assoc($result);

        return $tuple['num_of_buildings'];
    }

    $otu = getHouseAmt(1, $con);
    $mac = getHouseAmt(2, $con);
    $queens = getHouseAmt(3, $con);
    $western = getHouseAmt(4, $con);
    $waterloo = getHouseAmt(5, $con);
    $toronto = getHouseAmt(6, $con);

    //get the amount of houses under the average in the university
    function amtHouseUnderAvg($uni, $con){
        $q = "SELECT * FROM BELOW_AVG_RENT_NUM WHERE u_id = '$uni'";
        $result = mysqli_query($con, $q);
        $bool = false;
        $tuple = 0;
        if($result && mysqli_num_rows($result) > 0){
            $tuple = mysqli_fetch_assoc($result);
            $bool = true;
        }

        if($bool){
            return $tuple['rent_under_AVG'];
        }


        return $tuple;
    }
    $otu2 = amtHouseUnderAvg(1, $con);
    $mac2 = amtHouseUnderAvg(2, $con);
    $queens2 = amtHouseUnderAvg(3, $con);
    $western2 = amtHouseUnderAvg(4, $con);
    $waterloo2 = amtHouseUnderAvg(5, $con);
    $toronto2 = amtHouseUnderAvg(6, $con);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/home.css">
    <title>STUDENTRENT</title>
</head>
<body>
    <header>
    <img class="brand" src="imgs/HousingLogo.png" alt="logo" width = "100" height = "50">
        <nav>
          <ul>
          <li><a class="navspace" href="#search"><b>Search</b></a></li>
            <li><a class="navspace" href="profileS.php"><b>Profile</b></a></li>
            <li><a class="navspace" href="logout.php"><b>Log Out</b></a></li>
            <li><a></a></li>
            </ul>
        </nav>
    </header>
    <div class="searchBox" id="search">
        <div class="searchPrompt">
        <h1 style="color: #FFFFFF;">Search Homes Near Your University</h1>
    </div>
    <form class="searchLine" method="post" action="">
            <input class="searchBar" type="text" name="search" placeholder="Search...">

            <select class="searchDrop" name="uni" id="uni"> 
                <option selected hidden>Select a University</option>
                <option value="1">Ontario Tech University</option> 
                <option value="2">McMaster University</option> 
                <option value="3">Queen's University</option> 
                <option value="4">Western University</option> 
                <option value="5">University of Waterloo</option> 
                <option value="6">University of Toronto</option> 
            </select>    
            
            <button class="searchIcon" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    
    <div class="page">
        <h1>Universities With Houses!<h2>

        <div class="threeUni">
            <div class="school">
                <h2>Ontario Tech University</h2>
                <h4><?php echo($otu); ?></h4>
                <h5>below average rent: <br><?php echo($otu2); ?></h5>



            </div>
            <div class="school" >
                <h2>McMaster University</h2>
                <h4><?php echo($mac); ?></h4>
                <h5>below average rent: <br><?php echo($mac2); ?></h5>

            </div>
            <div class="school">
                <h2>Queen's University</h2>
                <h4><?php echo($queens); ?></h4>
                <h5>below average rent: <br><?php echo($queens2); ?></h5>


            </div>

        </div>

        <div class="threeUni">
            <div class="school">
                <h2>Western University</h2>
                <h4><?php echo($western); ?></h4>
                <h5>below average rent: <br><?php echo($western2); ?></h5>


            </div>
            <div class="school">
                <h2>University of Waterloo</h2>
                <h4><?php echo($waterloo); ?></h4>
                <h5>below average rent: <br><?php echo($waterloo2); ?></h5>


            </div>
            <div class="school">
                <h2>University of Toronto</h2>
                <h4><?php echo($toronto); ?></h4>
                <h5>below average rent: <br><?php echo($toronto2); ?></h5>


            </div>

        </div>

    </div>
</body>
</html>