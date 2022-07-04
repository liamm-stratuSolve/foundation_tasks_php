<?php
function printFibonacciSequence() {
    $x = 0;
    $y = 1;
    while ($x <= 34) {
        echo $x." ";
        $z = $x + $y;
        $x = $y;
        $y = $z;
    }
}

printFibonacciSequence();
?>