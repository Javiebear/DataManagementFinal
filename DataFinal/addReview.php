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
        }
        
        //go to login if not logged in
        header("location: search.php");
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


    $b_id = 0;

    if (isset($_GET['b_id'])) {
        $b_id = $_GET['b_id'];
    }

    $s_id = $tuple['s_id'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //getting all the values
        $rating_score = $_POST['rating_score'];
        $descriptions = $_POST['descriptions'];

        if(!empty($rating_score) && !empty($descriptions)){
            $q = "INSERT INTO REVIEW( rating_score, descriptions, s_id, b_id) 
            VALUES ('$rating_score', '$descriptions', '$s_id', '$b_id')";


            mysqli_query($con, $q);
            header("Location: homeDetails.php");
            }
             else{
            echo "Something is missing";
        }
    }
    
    //get the first image of the building
    $q = "SELECT img_bin FROM BUILDING_IMGS WHERE b_id = '$b_id'";
    $result = mysqli_query($con, $q);
    $imgArray = [];

    while ($imgs = mysqli_fetch_assoc($result)){
        $imgArray[] = $imgs['img_bin'];
    }

    $img = $imgArray[0];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homeDetails.css" />
    <title>HOUSEDETAILS</title>
</head>
<body>
    <div class="background-container"></div>
    <div class="content-container-two">
        <div class="container">
            <h3><?php echo("<img src='imgs/{$img}' alt='HOUSEIMAGE'> "); ?><h3>
                        <label><center>Student Rent Review:</center></label><br>                   

            <div>
                <form  method="post" action="addReview.php" enctype="multipart/form-data">
                    
                    <div class="formEntries">
                        <label for="rating_score">Rating 0-10:   </label>
                        <input type="text" id="rating_score" name="rating_score"><br>                        
                    </div>
                    <div class="formEntries">
                        <label for="rating_score">Review:   </label>
                        <textarea name="descriptions" rows="4" cols="50" placeholder="Short Description..."></textarea>                   
                    </div>
                    <br>
                    <div class="submit">
                        <input class="hugleft" href="homeDetails.php" id="button" type="submit" value="Submit">  
                        <a class="btn" href="search.php" >Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
