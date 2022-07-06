<?php
try {
    $Body = file_get_contents("php://input");
    $Data = json_decode($Body);
    if($Data) {
        http_response_code(200);
        $ResultStr = "This works, then it is the function";
//        $ResultStr = printFibonacciSequence($Data->input);
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

function printFibonacciSequence($InputGoalInt) {
    
    return buildString(0, 1, $InputGoalInt);
}

function buildString($FirstNumInt, $SecondNumInt, $GoalNumberInt){
    $StringNumberStr = strval($FirstNumInt);

    if ($FirstNumInt > 0) {
        echo ", " . $StringNumberStr;
    } else {
        echo $StringNumberStr;
    }

    if ($FirstNumInt <= $GoalNumberInt) {
        return;
    }

    $NewNumInt = $FirstNumInt + $SecondNumInt;
    $FirstNewNumInt = $SecondNumInt;
    $SecondNewNumInt = $NewNumInt;
    buildString($FirstNewNumInt, $SecondNewNumInt, $GoalNumberInt);
}