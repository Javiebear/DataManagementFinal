<?php

//shows errors on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

    include "updateViews.php";
    updateView();

    //connecting to the database
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "STUDENTRENT";


    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("error: could not connect to database");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phonenum = $_POST['phonenum'];
        $email = $_POST['email'];

        //fix later so that every element isnt empty
        if(!empty($username) && !empty($password) && !empty($fname) &&
         !empty($lname) && !empty($phonenum) && !empty($email)){
            $q = "INSERT INTO LANDLORD (username, password, fname, lname,
            phone_num, email) 
            VALUES ('$username', '$password','$fname', '$lname', 
            '$phonenum', '$email')";

            mysqli_query($con, $q);

            header("Location: loginL.php");
            die;

        }else{
            echo "Something is missing";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>STUDENTRENTREGISTER</title>
    <link rel="stylesheet" href="css/stylereg.css">
</head>

<body>

    <div class="regBox">
        <div>
            <div>
                <br><br><br><br>
                <h1><center>Register Here!</center></h1>
            </div>

            <div class="center">
                <form  method="post" action="">
                    <div class="formEntries">
                        <label for="username">Username:   </label>
                        <input type="text" id="username" name="username" ><br>                        
                    </div>
        
                    <div class="formEntries">
                        <label for="password">Password:   </label>
                        <input type="text" id="password" name="password" > <br>                        
                    </div>
        
                    <div class="formEntries">
                        <label for="fname">First Name:   </label>
                        <input type="text" id="fname" name="fname" ><br>                        
                    </div>
        
                    <div class="formEntries">
                        <label for="lname">Last Name:   </label>
                        <input type="text" id="lname" name="lname"> <br>                        
                    </div>

                    <div class="formEntries">
                        <label for="phonenum">Phone Number:   </label>
                        <input type="text" id="phonenum" name="phonenum"> <br>                        
                    </div>

                    <div class="formEntries">
                        <label for="email">Email:   </label>
                        <input type="text" id="email" name="email"><br>                        
                    </div>
                    <br>
                    <div class="submit">
                        <input class="hugleft" id="button" type="submit" value="Submit">  
                        
                        <a class="hugright" href="loginL.php" >Back</a>

                    </div>
        
                </form>
            </div>

        </div>
    </div>
</body>
</html>
