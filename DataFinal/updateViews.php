<?php
//resetting all the views
function updateView(){
    //connecting to the database
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "STUDENTRENT";

    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("error: could not connect to database");
    }

    //allowing the webpage to have permission to update views
    $q = "GRANT CREATE VIEW ON STUDENTRENT.* TO 'root'@'localhost'";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW BUILDING_VIEW AS 
    SELECT B.address, COUNT(*) AS number_of_visits
    FROM BUILDING B JOIN VIEWED V ON B.b_id = V.b_id
    GROUP BY B.address";
    mysqli_query($con, $q);


    $q = "CREATE OR REPLACE VIEW BUILDING_DESCRIPTION AS 
    SELECT B.b_id, B.uni, B.address, B.date, B.rent, B.floors, B.description, B.building_type,
    B.basement, B.kitchen, B.num_of_bedrooms, B.num_of_washrooms, B.hydro, B.electricity, B.wifi,
    B.public_transportation, B.thermostat, B.parking, L.l_id, L.fname, L.lname, P.u_name
    FROM (POST_SECONDARY P JOIN BUILDING B ON P.u_id = B.uni) JOIN LANDLORD L ON B.l_id = L.l_id";
    mysqli_query($con, $q);

    
    $q = "CREATE OR REPLACE VIEW BELOW_AVG_RENT_NUM AS 
    SELECT P.u_id, count(*) AS rent_under_AVG
    FROM BUILDING B, POST_SECONDARY P
    WHERE P.u_id = B.uni AND B.rent < ALL (SELECT AVG(B.rent)
                                          FROM BUILDING B
                                          WHERE P.u_id = B.uni)
    GROUP BY P.u_id";
    mysqli_query($con, $q);


    $q = "CREATE OR REPLACE VIEW BUILDING_IMGS
    AS SELECT DISTINCT I.img_bin, I.b_id
       FROM IMGS I
       WHERE I.b_id IN (SELECT B.b_id
                        FROM BUILDING B
                        WHERE B.b_id = I.b_id)
       ORDER BY I.b_id ASC";
    mysqli_query($con, $q);


    $q = "CREATE OR REPLACE VIEW BUILDING_REVIEWS
    AS (SELECT B.b_id, R.rating_score, R.descriptions
       FROM BUILDING B LEFT JOIN REVIEW R ON B.b_id = R.b_id)
       UNION 
       (SELECT B.b_id, R.rating_score, R.descriptions
       FROM BUILDING B RIGHT JOIN REVIEW R ON B.b_id = R.b_id)
    ";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW NO_REVIEW
    AS SELECT B.b_id, B.address
       FROM BUILDING B
       WHERE B.b_id NOT IN (SELECT DISTINCT R.b_id FROM REVIEW R)
       UNION 
       SELECT NULL AS b_id, NULL AS address
       WHERE NOT EXISTS (SELECT NULL FROM REVIEW)";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW AVG_RATING
    AS SELECT B.address, L.fname, L.lname, AVG(R.rating_score) AS avg_Rate
       FROM BUILDING B, REVIEW R, LANDLORD L
       WHERE B.b_id = R.b_id AND L.l_id = B.l_id
       GROUP BY B.address, L.fname, L.lname
       ORDER BY L.fname";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW BUILDINGS_BELOW_AVG
    AS SELECT B.address, B.rent, P.u_name
       FROM BUILDING B, POST_SECONDARY P
       WHERE P.u_id = B.uni AND B.rent <ALL (SELECT AVG(B.rent)
                                             FROM BUILDING B
                                             WHERE P.u_id = B.uni)
    ";
    mysqli_query($con, $q);


    $q = "CREATE OR REPLACE VIEW BUILDING_VIEWS
    AS SELECT B.address, COUNT(*) AS number_of_visits
       FROM BUILDING B JOIN VIEWED V ON B.b_id = V.b_id
       GROUP BY B.address
    ";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW STUDENT_REVIEW
    AS SELECT S.s_id ,S.fname, S.lname, B.address, R.descriptions
       FROM (STUDENT S JOIN REVIEW R ON S.s_id = R.s_id) JOIN BUILDING B ON B.b_id = R.b_id
       ORDER BY S.fname ASC
    ";
    mysqli_query($con, $q);

    $q = "CREATE OR REPLACE VIEW BUILDINGS_FOR_RENT
    AS SELECT P.u_id, COUNT(*) AS num_of_buildings
       FROM BUILDING B JOIN POST_SECONDARY P ON B.uni = P.u_id
       GROUP BY P.u_id
    ";
    mysqli_query($con, $q);

}

?>
