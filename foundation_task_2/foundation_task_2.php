<?php
function printFibonacciSequence($FirstNumInt, $SecondNumInt, $GoalNumberInt) {

    $EchoNumberStr = strval($FirstNumInt);

    if ($FirstNumInt > 0) {
        echo ", ".$EchoNumberStr;
    } else {
        echo $EchoNumberStr;
    }

    if ($FirstNumInt < $GoalNumberInt) {
        $NewNumInt = $FirstNumInt + $SecondNumInt;
        $FirstNewNumInt = $SecondNumInt;
        $SecondNewNumInt = $NewNumInt;
        printFibonacciSequence($FirstNewNumInt, $SecondNewNumInt, $GoalNumberInt);
    }
     
    // else if ($firstNumInt === 34) {
    //     //Added this additional else if to remove the "," at the end of the print
    //     echo $firstNumInt;
    // }
}

printFibonacciSequence(0, 1, 10000);
?>

<!-- <?php
// function printFibonacciSequence() {
//     $x = 0;
//     $y = 1;
//     while ($x <= 34) {
//         echo $x." ";
//         $z = $x + $y;
//         $x = $y;
//         $y = $z;
//     }
// }

// printFibonacciSequence();
?> -->