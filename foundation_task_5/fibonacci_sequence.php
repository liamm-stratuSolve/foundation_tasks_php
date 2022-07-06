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

function buildResponseString($OutputNumberInt, $OutputResultStr) {

    if ($OutputNumberInt > 0) {
        return  $OutputResultStr . ", " . $OutputNumberInt;
    } else {
        return $OutputNumberInt;
    }
}

function printFibonacciSequence($FirstNumInt, $SecondNumInt, $GoalNumberInt, $StringValueStr) {

    $NewStringStr = buildResponseString($FirstNumInt, $StringValueStr);

    if ($FirstNumInt <= $GoalNumberInt) {
        $NewNumInt = $FirstNumInt + $SecondNumInt;
        $FirstNewNumInt = $NewNumInt;
//        $SecondNewNumInt = $NewNumInt;
        printFibonacciSequence($FirstNewNumInt, $SecondNumInt, $GoalNumberInt, $NewStringStr);
    } else {
        return $NewStringStr;
    }
}