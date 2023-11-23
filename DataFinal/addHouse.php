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

        //getting all the values
        $uni = $_POST['uni'];
        $address = $_POST['address'];
        $date = $_POST['date'];
        $rent = $_POST['rent'];
        $floors = $_POST['floors'];
        $description = $_POST['description'];
        $building_type = $_POST['building_type'];
        $basement = $_POST['basement'];
        $kitchen = $_POST['kitchen'];
        $num_of_bedrooms = $_POST['num_of_bedrooms'];
        $num_of_washrooms = $_POST['num_of_washrooms'];
        $hydro = $_POST['hydro'];
        $floors = $_POST['floors'];
        $electricity = $_POST['electricity'];
        $wifi = $_POST['wifi'];
        $public_transportation = $_POST['public_transportation'];
        $thermostat = $_POST['thermostat'];
        $parking = $_POST['parking'];
        //get the landlord id
        $l_id = $_SESSION['l_id'];
        $imgsFilled = $_FILES['imgs'];

        //images should be submitted too
        if(!empty($uni) && !empty($address) && !empty($date) &&
        !empty($rent) && !empty($floors) && !empty($description) && !empty($building_type) 
        && !empty($basement) && !empty($kitchen) && !empty($num_of_bedrooms) &&
        !empty($num_of_washrooms) && !empty($hydro) && !empty($electricity) && !empty($wifi) 
        && !empty($public_transportation) && !empty($thermostat) && !empty($parking) && !empty($imgsFilled)){
            $q = "INSERT INTO BUILDING(uni, address, date, rent, floors, description, building_type,
            basement, kitchen, num_of_bedrooms, num_of_washrooms, hydro, electricity, wifi,
            public_transportation, thermostat, parking, l_id) 
            VALUES ('$uni', '$address', '$date', '$rent', '$floors', '$description', '$building_type',
            '$basement', '$kitchen', '$num_of_bedrooms', '$num_of_washrooms', '$hydro', '$electricity',
            '$wifi','$public_transportation', '$thermostat', '$parking', '$l_id')";

            mysqli_query($con, $q);

            //get the b_id to link the image to the building
            $q2 = "SELECT b_id FROM BUILDING WHERE address = '$address'";
            $result = mysqli_query($con, $q2);
            $building_data = mysqli_fetch_assoc($result);

            //upload the images into the image folder path
            $fileCount = count($_FILES['imgs']['name']);

            for ($i = 0; $i < $fileCount; $i++){
                $imgName[] = basename($_FILES['imgs']['name'][$i]);
                $tmpImage = $_FILES['imgs']['tmp_name'][$i];
                $path = 'imgs/'.$imgName[$i];
                move_uploaded_file($tmpImage, $path);
                
                //enter in images to the images database
                $b_id = $building_data['b_id'];
                $img_bin = $imgName[$i];
            
                $q3 = "INSERT INTO IMGS (img_bin, b_id) 
                VALUES ('$img_bin', '$b_id')";
            
                mysqli_query($con, $q3);
            }

            header("Location: landlord.php");
            die;

        }else{
            echo "Something is missing";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>STUDENTRENT</title>
    <link rel="stylesheet" href="css/landlord.css">
</head>

<body>

    <div class="addHouseBox">
        <div class="label">
            <h1> ADD HOUSE </h1>
        </div>

        <div class="buildingForm">
            <form  method="post" action="addHouse.php" enctype="multipart/form-data">

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

                <div class="formEntries">
                    <label for="address">Address:   </label>
                    <input type="text" id="address" name="address" > <br>                        
                </div>
    
                <div class="formEntries">
                    <label for="date">Date:   </label>
                    <input type="text" name="date" > <br>                        
                </div>
    
                <div class="formEntries">
                    <label for="rent">rent:   </label>
                    <input type="text" id="rent" name="rent" ><br>                        
                </div>
    
                <div class="formEntries">
                    <label for="floors">floors:   </label>
                    <input type="text" id="floors" name="floors"> <br>                        
                </div>

                <div class="formEntries">
                    <label for="description">description: </label>
                </div>

                <div class="formEntries">
                    <textarea name=description rows="4" cols="50" placeholder="Short Description..."></textarea>                   
                </div>

                <div class="formEntries">
                    <label for="building_type">building type:   </label>
                    <input type="text" id="building_type" name="building_type"> <br>                        
                </div>
    
                <div class="formEntries">
                    <label for="basement">basement:   </label>
                    <input type="text" id="basement" name="basement"><br>                        
                </div>

                <div class="formEntries">
                    <label for="kitchen">kitchen:   </label>
                    <input type="text" id="kitchen" name="kitchen"><br>                        
                </div>

                <div class="formEntries">
                    <label for="num_of_bedrooms">number of bedrooms:   </label>
                    <input type="text" id="num_of_bedrooms" name="num_of_bedrooms"><br>                        
                </div>

                <div class="formEntries">
                    <label for="num_of_washrooms">number of washrooms:   </label>
                    <input type="text" id="num_of_washrooms" name="num_of_washrooms"><br>                        
                </div>

                <div class="formEntries">
                    <label for="hydro">hydro:   </label>
                    <input type="text" id="hydro" name="hydro"><br>                        
                </div>

                <div class="formEntries">
                    <label for="electricity">electricity:   </label>
                    <input type="text" id="electricity" name="electricity"><br>                        
                </div>

                <div class="formEntries">
                    <label for="wifi">wifi:   </label>
                    <input type="text" id="wifi" name="wifi"><br>                        
                </div>

                <div>
                    <label for="public_transportation">public_transportation:   </label>
                    <input type="text" id="public_transportation" name="public_transportation"><br>                        
                </div>

                <div class="formEntries">
                    <label for="thermostat">thermostat:   </label>
                    <input type="text" id="thermostat" name="thermostat"><br>                        
                </div>

                <div>
                    <label for="parking">parking:   </label>
                    <input type="text" id="parking" name="parking"><br>                        
                </div>

                <div class="formEntries">
                    <label for="img">Images:   </label>
                    <input type="file" name="imgs[]" accept="imgs/*" multiple>

                </div>

                <div class="submit">
                    <input class="hugleft" id="button" type="submit" value="Add House">  
                    <a class="hugright" href="homePage.php">Home</a>

                </div>
            </form>
        </div>
    </div>
</body>
