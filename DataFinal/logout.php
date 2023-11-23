<?php

    session_start();
    
    if(isset($_SESSION['s_id'])){
        unset($_SESSION['s_id']);
    }

    if(isset($_SESSION['l_id'])){
        unset($_SESSION['l_id']);
    }

    header("Location: userSelection.php");
    die;
?>