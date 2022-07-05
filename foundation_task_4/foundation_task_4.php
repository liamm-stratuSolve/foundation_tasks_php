<?php
class ItemOwners {
    public static function groupByOwners($ItemsArr) {
        
        $itemsOfJohnArr = array();
        $itemsOfSamArr = array ();

        foreach($ItemsArr as $item => $item_value) {
            if ($item_value === "John") 
                $itemsOfJohnArr[] = $item;
            else
                $itemsOfSamArr[] = $item;
        }

        $returnedItems = ["John" => $itemsOfJohnArr, "Sam" => $itemsOfSamArr];

        return $returnedItems;
    }
}

$ItemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);

echo json_encode(ItemOwners::groupByOwners($ItemsArr));

?>