<?php
function printFibonacciSequence($FirstNumInt, $SecondNumInt, $GoalNumberInt) {

    $OutputStr = strval($FirstNumInt);

    if ($FirstNumInt <= $GoalNumberInt) {

        if ($FirstNumInt > 0) {
            echo ", ".$OutputStr;
        } else {
            echo $OutputStr;
        }

        $NewNumInt = $FirstNumInt + $SecondNumInt;
        $FirstNewNumInt = $SecondNumInt;
        $SecondNewNumInt = $NewNumInt;
        printFibonacciSequence($FirstNewNumInt, $SecondNewNumInt, $GoalNumberInt);
    }
}

printFibonacciSequence(0, 1, 34);
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