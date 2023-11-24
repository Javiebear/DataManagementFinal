<?php
//shows errors on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "updateViews.php";
updateView();

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
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
	<link rel="stylesheet" href="css/profile.css">
    <title>STUDENTPROFILE</title>
</head>
<body>
<header>
        <img class="brand" src="imgs/HousingLogo.png" alt="logo" width = "100" height = "50">
        <nav>
            <ul>
            <li><a></a></li>
              <li><a class="navspace" href="homePage.php"><b>Search</b></a></li>
              <li><a class="navspace" href="logout.php"><b>Log Out</b></a></li>
              <li><a></a></li>
            </ul>
        </nav>
</header>

<section>
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
                          <p class="mb-0"><strong class="pr-1">Program:</strong><?php echo $tuple['program'];?></p>
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
                              <th width="40%">Birthday</th>
                              <td width="3%">:</td>
                                <td><?php echo $tuple['date_of_birth'];?></td>
                            </tr>
                            <tr>
                              <th width="40%">Email</th>
                              <td width="3%">:</td>
                                <td><?php echo $tuple['email'];?></td>
                            </tr>
                            <tr>
                              <th width="40%">Address</th>
                              <td width="3%">:</td>
                                <td><?php echo $tuple['address'];?></td>
                            </tr>
                            <tr>
                              <th width="40%">Phone Number</th>
                              <td width="3%">:</td>
                                <td>+<?php echo $tuple['phone_num'];?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div style="height: 26px"></div>
                        <div class="card shadow-sm">
                          <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Reviews History</h3>
                          </div>
                          <div class="card-body pt-0">   
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

                            $s_id = $_SESSION['s_id'];

                            $studentReview = [];

                            //getting the all reviews from one student
                            $q = "SELECT * FROM STUDENT_REVIEW WHERE s_id = '$s_id'";
                            $result = mysqli_query($con, $q);

                            if($result){
                                while ($tuple = mysqli_fetch_assoc($result)){
                                    $studentReview[] = $tuple;
                                }
                            }

                            $studentAmt = count($studentReview);

                            for ($i = 0; $i < $studentAmt; $i++){ 
                              
                                $studentName = $studentReview[$i]['fname'];
                                $studentRev = $studentReview[$i]['descriptions'];
                                $address = $studentReview[$i]['address'];

                                //print out image and review
                                echo("<div class='card-body pt-0'>
                                <table class='table table-bordered'>
                                  <tr>
                                      <td>{$studentName}</td>
                                      <td width='2%'>:</td>
                                      <td>{$studentRev}</td>
                                      <td width='2%'>:</td>
                                      <td>{$address}</td>
                                  </tr>
                                </table>
                              </div>");
                            }
                            ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>     
</section>
</body>
</html>
