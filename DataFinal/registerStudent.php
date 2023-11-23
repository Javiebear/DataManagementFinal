<?php

//shows errors on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

    //connecting to the database
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "STUDENTRENT";


    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("error: could not connect to database");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $date_of_birth = $_POST['date_of_birth'];
        $phonenum = $_POST['phonenum'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $program = $_POST['program'];
        $uni = $_POST['uni'];

        //fix later so that every element isnt empty
        if(!empty($username) && !empty($password) && !empty($fname) &&
         !empty($lname) && !empty($date_of_birth) && !empty($phonenum) && !empty($address) 
         && !empty($email) && !empty($program) && !empty($uni)){
            $q = "INSERT INTO STUDENT (username, password, fname, lname, date_of_birth,
            phone_num, address, email, program, uni) 
            VALUES ('$username', '$password','$fname', '$lname', '$date_of_birth',
            '$phone_num', '$address', '$email', '$program', '$uni')";

            mysqli_query($con, $q);

            header("Location: loginS.php");
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
                <br><br>
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
                        <label for="date_of_birth">Date Of Birth: </label>
                        <input type="date" id="date_of_birth" name="date_of_birth"><br>                        
                    </div>

                    <div class="formEntries">
                        <label for="phonenum">Phone Number:   </label>
                        <input type="text" id="phonenum" name="phonenum"> <br>                        
                    </div>
        
                    <div class="formEntries">
                        <label for="address">Address:   </label>
                        <input type="text" id="address" name="address" > <br>                        
                    </div>

                    <div class="formEntries">
                        <label for="email">Email:   </label>
                        <input type="text" id="email" name="email"><br>                        
                    </div>

                    <div class="formEntries">
                        <label for="program">Program:   </label>
                        <input type="text" id="program" name="program"><br>                        
                    </div>

                    <div class="formEntries">
                        <label for="uni">Post Secondary Institution:</label> 
                        <select name="uni" id="uni"> 
                            <option value="1">Ontario Tech University</option> 
                            <option value="2">McMaster University</option> 
                            <option value="3">Queen's University</option> 
                            <option value="4">Western University</option> 
                            <option value="5">University of Waterloo</option> 
                            <option value="6">University of Toronto</option> 

                        </select>                     
                    </div>
                    <br>
                    <div class="submit">
                        <input class="hugleft" id="button" type="submit" value="Submit">  
                        <a class="hugright" href="loginS.php" >Back</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

