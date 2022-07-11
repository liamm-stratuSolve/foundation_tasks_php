<?php
try {
    require_once ("./Person.class.php");

    $ConnObj = connectToDB();
    $RequestType = $_SERVER['REQUEST_METHOD'];
    $BodyObj = file_get_contents('php://input');
    $Person = new Person($ConnObj);

    switch ($RequestType) {
        case "GET":
            $ResponseArr = $Person->loadAllPeople($BodyObj);
            if($ResponseArr){
                http_response_code(200);
                die(json_encode($ResponseArr));
            }
            http_response_code(404);
            die();
            break;

        case "POST":
            $RequestDataArr = json_decode($BodyObj);
            $ActionType = "";
            if($RequestDataArr){

                foreach ($RequestDataArr as $Key => $Value){
                    if ($Key === "ActionType") {
                        $ActionType = $Value;
                    }
                }

                switch ($ActionType){
                    case "create":
                        $CreateResultBool = $Person->createPerson($RequestDataArr);
                        if ($CreateResultBool){
                            http_response_code(200);
                            die($CreateResultBool);
                        }
                        http_response_code(500);
                        die();
                        break;

                    case "search":
                        $ResponseArr = $Person->loadAllPeople($RequestDataArr);
                        if($ResponseArr){
                            http_response_code(200);
                            die(json_encode($ResponseArr));
                        }
                        http_response_code(404);
                        die();
                        break;
                }
            }
            http_response_code(500);
            die();
            break;

        case "PUT":
            $RequestDataArr = json_decode($BodyObj);
            $CreateResultBool = $Person->savePerson($RequestDataArr);
            if ($CreateResultBool) {
                http_response_code(200);
                die(json_encode($CreateResultBool));
            }
            http_response_code(500);
            die();
            break;

        case "DELETE":
            $RequestDataArr = json_decode($BodyObj);
            $DeleteResultBool = $Person->deletePerson($RequestDataArr);
            if ($DeleteResultBool) {
                http_response_code(200);
                die(json_encode($DeleteResultBool));
            }
            http_response_code(500);
            die();
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