<?php

    require_once ("./Person.class.php");



    function connectToDB() {
    $ServerStr = "localhost";
    $PasswordStr = "";
    $UsernameStr = "root";
    $DataBaseStr = "Person_Database";

    $ConnectionObj = new mysqli($ServerStr,$UsernameStr, $PasswordStr, $DataBaseStr);

    if ($ConnectionObj->connect_error){
        die("Unsuccessful: " . $ConnectionObj->connect_error);
    }

    return $ConnectionObj;
    }