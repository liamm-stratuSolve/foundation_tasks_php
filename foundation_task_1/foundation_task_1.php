<?php
function addAll($Array) {
    $totalSumInt = 0;
    $entityCountInt = count($Array);

    for ($x = 0; $x < $entityCountInt; $x++) {
        $totalSumInt = $totalSumInt + array_sum($Array);
        unset($Array[$x]);
    }

    return $totalSumInt;
}

$Array = [1,1,1,1,1]; //5+4+3+2+1=15
// $Array = [1,2,3,4,5]; //15+14+12+9+5=55
echo addAll($Array);
?>