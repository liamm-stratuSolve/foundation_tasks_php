<?php
try {
    $Body = file_get_contents("php://input");
    $Data = json_decode($Body);
    if($Data) {
        http_response_code(200);
        $ResultStr = printFibonacciSequence(0, 1, $Data->input, "");
        die(json_encode($ResultStr));
    } else {
        http_response_code(500);
        die();
    }
} catch(Throwable $error) {
    error_log($error->getMessage());
    http_response_code(501);
    die();
}

function printFibonacciSequence($FirstNumInt, $SecondNumInt, $GoalNumberInt, $StringInStr) : string {

    $StringOutStr = buildResponseString($FirstNumInt, $StringInStr);

    if ($GoalNumberInt >= $SecondNumInt) {
        $NewNumInt = $FirstNumInt + $SecondNumInt;
        $FirstNewNumInt = $SecondNumInt;
        $SecondNewNumInt = $NewNumInt;
        return printFibonacciSequence($FirstNewNumInt, $SecondNewNumInt, $GoalNumberInt, $StringOutStr);
    } else {
        return $StringOutStr;
    }
}

function buildResponseString($CurrentNumberInt, $CurrentStringStr) {

    if ($CurrentNumberInt > 0) {
        return  $CurrentStringStr . ", " . $CurrentNumberInt;
    } else {
        return $CurrentNumberInt;
    }
}