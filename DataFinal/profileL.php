<?php
//shows errors on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include "updateViews.php";
    updateView();

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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
	<link rel="stylesheet" href="css/profile.css">
    <title>STUDENTRENT</title>
</head>
<body>
<header>
        <img class="brand" src="imgs/HousingLogo.png" alt="logo" width = "100" height = "50">
        <nav>
            <ul>
            <li><a></a></li>
            <li><a class="navspace" href="landlord.php"><b>Home</b></a></li>
            <li><a class="navspace" href="addHouse.php"><b>Add Listing +</b></a></li>
            <li><a class="navspace" href="logout.php"><b>Log Out</b></a></li>
            <li><a></a></li>
            </ul>
        </nav>
</header>

<section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
<div class="student-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="imgs/profile.png" alt="student dp">
            <h3>Hello <?php echo $tuple['username'];?>!</h3>
          </div>
          <div class="card-body">
            <p class="mb-0"><strong class="pr-1">First name:</strong><?php echo $tuple['fname'];?></p>
            <p class="mb-0"><strong class="pr-1">Last name:</strong><?php echo $tuple['lname'];?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Email</th>
                <td width="2%">:</td>
                <td><?php echo $tuple['email'];?></td>
              </tr>
              <tr>
                <th width="30%">Phone Number</th>
                <td width="2%">:</td>
                <td>+<?php echo $tuple['phone_num'];?></td>
              </tr>
            </table>
          </div>
        </div>
          <div style="height: 26px"></div>
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Renter History</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
                <?php

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

                    $buildingArray = [];
                    $imageArray = [];

                    $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE l_id = '$l_id'";
                    $result = mysqli_query($con, $q);

                    if($result){
                        while ($tuple = mysqli_fetch_assoc($result)){
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

                        //get the students who lived in the building
                        $studentArray = [];
                        $studentIdArray = [];
                        $q = "SELECT s_id FROM LIVED_IN WHERE b_id = '$b_id'";
                        $result = mysqli_query($con, $q);

                        while ($s_id = mysqli_fetch_assoc($result)){
                            $studentIdArray[] = $s_id['s_id'];
                        }

                        //get all student names with the matching ids
                        foreach ($studentIdArray as $studentId){
                            $q = "SELECT fname FROM STUDENT WHERE s_id = '$studentId'";
                            $result = mysqli_query($con, $q);
                    
                            while ($student = mysqli_fetch_assoc($result)){
                                $studentArray[] = $student;
                            }
                        }

                        $studentAmt = count($studentArray);

                        //print out image and review
                        echo("
                        <tr>
                            <td><center>
                            <img src='imgs/{$imgArray[$imageIndex]}' alt='Houseimg' height='100' width='300'>
                            </center></td>
                            <td width='2%'>:</td>
                            <td><center>");
                            
                            for ($y = 0; $y < $studentAmt; $y++ ){
                                echo ($studentArray[$y]['fname'] . " ");
                            }
                    
                        echo("</center></td>
                        </tr>
                        ");
                    }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>     
    		</div>
		</div>
    </div>
</section>
	</body>
</html>
