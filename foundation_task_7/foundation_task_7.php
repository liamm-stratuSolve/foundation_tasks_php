<?php
try {
    require_once ("./Person.class.php");

    $ConnObj = connectToDB();
    $RequestType = $_SERVER['REQUEST_METHOD'];
    $Person = new Person($ConnObj);

    switch ($RequestType) {
        case "GET":
            $DataResponse = $Person->loadAllPeople();
            if ($DataResponse) {
                http_response_code(200);
                die(json_encode($DataResponse));
            }
            http_response_code(404);
            die();
            break;

        case "POST":
            break;

        case "PUT":
            break;

        case "DELETE":
            break;

        default:
            http_response_code(500);
            die();
            break;
    }

} catch(Throwable $error) {
    error_log($error->getMessage());
    http_response_code(501);
    die();
}

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