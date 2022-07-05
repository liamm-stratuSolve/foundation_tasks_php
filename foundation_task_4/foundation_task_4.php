<?php
class ItemOwners {
    public static function groupByOwners($ItemsArr) {

        $ListOfOwnersArr = array();
        $ListedItemsOfOwnersArr = array();     

        foreach($ItemsArr as $ItemStr => $OwnerStr) {
            if (!in_array($OwnerStr, $ListOfOwnersArr)) {
                $ListOfOwnersArr[] = $OwnerStr;
            }
        }

        foreach ($ListOfOwnersArr as $OwnerNameStr) {
            $ListOfItemsArr = array();

            foreach ($ItemsArr as $ItemStr => $OwnerStr) {
                if($OwnerNameStr === $OwnerStr){
                    $ListOfItemsArr[] = $ItemStr;
                }
            }

            $ListedItemsOfOwnersArr[] = array($OwnerNameStr => $ListOfItemsArr);
        }

        return $ListedItemsOfOwnersArr;
    }
}

$ItemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);

echo json_encode(ItemOwners::groupByOwners($ItemsArr));

?>

<!-- $itemsOfJohnArr = array();
        $itemsOfSamArr = array ();

        foreach($ItemsArr as $item => $item_value) {
            if ($item_value === "John") 
                $itemsOfJohnArr[] = $item;
            else
                $itemsOfSamArr[] = $item;
        }

        $returnedItems = ["John" => $itemsOfJohnArr, "Sam" => $itemsOfSamArr];

        return $returnedItems; -->