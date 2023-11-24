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

    //checking if the username and password match to an existing on in the database
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){
            $q = "SELECT * FROM STUDENT WHERE username = '$username'";

            $result = mysqli_query($con, $q);
                if($result && mysqli_num_rows($result) > 0){
                    $tuple = mysqli_fetch_assoc($result);

                    if($tuple['password'] === $password ){
                        $_SESSION['s_id'] = $tuple['s_id'];

                        header("Location: homePage.php");
                        die;
                    }
                }

        }else{
            echo("Something is missing");
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>STUDENTRENTLOGIN</title>
    <link rel="stylesheet" href="css/stylelog.css">
</head>

<body>
    <div class="loginBox">
        <div>
            <div>
                <img src="imgs/HousingLogo.png" alt="logo">
            </div>
    
            <div class="center">
                <form method="post" action="">
                    <div class="login">
                        <label for="username">Username:   </label>
                        <input type="text" id="username" name="username" ><br>                        
                    </div>
    
                    <div class="login">
                        <label for="password">Password:   </label>
                        <input type="text" id="password" name="password"> <br>                        
                    </div>
    
                    <div class="login">
                        <input id="button" type="submit" value="Submit">            
                    </div>

                    <div class="login">
                        <a href="registerStudent.php" >Not Registered?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
