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

    $b_id = 0;

    if (isset($_GET['b_id'])) {
        $b_id = $_GET['b_id'];
    }

    $s_id = $tuple['s_id'];

    //checking if the user was already added to the viewed table
    $q = "SELECT * FROM VIEWED WHERE s_id = '$s_id'";

    $result = mysqli_query($con, $q);
    $viewedArr = [];
    $alreadyViewed = false;

    if($result){
        while ($tuple = mysqli_fetch_assoc($result)) {
            $viewedArr[] = $tuple; 
        }
    }

    foreach($viewedArr as $viewed){
        if ($viewed['b_id'] == $b_id){
            $alreadyViewed = true;
        }
    }

    //if there are no duplicate houses
    if ($alreadyViewed == false){
        //adding the view history for the student
        $q = "INSERT INTO VIEWED (s_id, b_id)
        VALUES ('$s_id', '$b_id')";

        mysqli_query($con, $q);
    }

    //getting data for building
    $q = "SELECT * FROM BUILDING_DESCRIPTION WHERE b_id = '$b_id' limit 1";

    $result = mysqli_query($con, $q);
    if($result && mysqli_num_rows($result) > 0){
        $building = mysqli_fetch_assoc($result);
    }
    
    $address = $building['address'];
    $rent = $building['rent'];
    $description = $building['description'];
    $date = $building['date'];
    $floors = $building['floors'];
    $building_type = $building['building_type'];
    $basement = $building['basement'];
    $kitchen = $building['kitchen'];
    $num_of_bedrooms = $building['num_of_bedrooms'];
    $num_of_washrooms = $building['num_of_washrooms'];
    $hydro = $building['hydro'];
    $electricity = $building['electricity'];
    $wifi = $building['wifi'];
    $public_transportation = $building['public_transportation'];
    $thermostat = $building['thermostat'];
    $parking = $building['parking'];

    //getting review average
    $q = "SELECT * FROM AVG_RATING WHERE address = '$address' limit 1";
    $result = mysqli_query($con, $q);
    $review = [];
    $rounded_avg = "N/A";

    if($result && mysqli_num_rows($result) > 0){
        $review = mysqli_fetch_assoc($result);
    }

    //checking if there are any reviews on this building
    if(count($review) != 0){
        $review_avg = $review['avg_Rate'];
        $rounded_avg = round($review_avg, 2);
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/homeDetails.css" />
  <title>HOUSEDETAILS</title>
</head>
<body>
    <div class="background-container"></div>
        <div class="content-container">
        <div class="container">
            <div>
            <?php echo("<center><img src='imgs/{$img}' alt='HOUSEIMAGE'></center>"); ?>
                <h1><center>&emsp; <?php echo($address) ?></center></h1>
                <hr>
                <p>&emsp;Rent: <?php echo("$".$rent) ?></p>
                <hr>
                <p>&emsp;Description: <?php echo($description) ?></p>
                <hr>
                <p>&emsp;Lease Date: <?php echo($date) ?></p>
                <hr>
                <p>&emsp;Floors: <?php echo($floors) ?></p>
                <hr>
                <p>&emsp;Building Type: <?php echo($building_type) ?></p>
                <hr>
                <p>&emsp;Number of Bedrooms: <?php echo($num_of_bedrooms) ?></p>
                <hr>
                <p>&emsp;Number of Washrooms: <?php echo($num_of_washrooms) ?></p>
                <hr>
                <p>&emsp;Hydro: <?php echo($hydro) ?></p>
                <hr>
                <p>&emsp;Electricity: <?php echo($electricity) ?></p>
                <hr>
                <p>&emsp;Wifi: <?php echo($wifi) ?></p>
                <hr>
                <p>&emsp;Public transportation: <?php echo($public_transportation) ?></p>
                <hr>
                <p>&emsp;Thermostat: <?php echo($thermostat) ?></p>
                <hr>
                <p>&emsp;Parking: <?php echo($parking) ?></p>
                <hr>
                <p>&emsp;Review average: <?php echo($rounded_avg);?></p>
                <a class="btn" href="search.php" style="padding:2px 10px;margin-left: 460px; ">Back</a>
            </div>
        </div>
        <br>
        <div class="container">
            <div>
                <h4>Reviews
                <?php echo("<a href='addReview.php?b_id={$b_id}' style='text-decoration: none;'>");?>
                <button style="float: right; margin-left: 5px;">+</button></a></h4>
                <hr>
                <?php
                    $q = "SELECT * FROM BUILDING_REVIEWS 
                    WHERE b_id = '$b_id' ";
                    $result = mysqli_query($con, $q);

                    if ($result && mysqli_num_rows($result) > 0) {
                    while ($review = mysqli_fetch_assoc($result)) {
                    echo "<p>Anonymous User</p>";
                    echo "<p>&emsp; Rating: {$review['rating_score']}</p>";
                    echo "<p>&emsp; Description: {$review['descriptions']}</p>";
                    echo "<hr>";
                    }
                } else {
                    echo "<p>No reviews available for this building.</p>";
                }
            ?>
            </div>
        </div>
    </div>
</body>
</html>
