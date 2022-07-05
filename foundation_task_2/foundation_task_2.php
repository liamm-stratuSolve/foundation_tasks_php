<?php
function printFibonacciSequence($firstNumInt, $secondNumInt) {
    if ($firstNumInt < 34) {
        echo $firstNumInt.", ";
        $newNumInt = $firstNumInt + $secondNumInt;
        $firstNewNumInt = $secondNumInt;
        $secondNewNumInt = $newNumInt;
        printFibonacciSequence($firstNewNumInt, $secondNewNumInt);
    } else if ($firstNumInt === 34) {
        //Added this additional else if to remove the "," at the ens of the print
        echo $firstNumInt;
    }
}

printFibonacciSequence(0, 1);
?>