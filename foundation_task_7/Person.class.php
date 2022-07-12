<?php

    class Person {
        public $ConnectionObj;

        function __construct($ConnectionObj){
            $this->ConnectionObj = $ConnectionObj;
        }

        function createPerson($PersonRecordArr): bool{

//            error_log(json_encode($PersonRecordArr));

            $NumItemsInt = 0;
            $ItemCountInt = 0;
            $PersonDetailsArray = array();
            $SqlStr = "INSERT INTO `Person`(`FirstName`, `Surname`, `DateOfBirth`, `EmailAddress`, `Age`)".
                " VALUES (";

            foreach ($PersonRecordArr as $Key => $Value) {
                if($Key !== "ActionType") {
                    $PersonDetailsArray = $Value;
                }

            }

            //Check each object in the New Date array and count for those that are not blank
            foreach ($PersonDetailsArray as $Item => $Value){
                if($Value){
                    $NumItemsInt++;
                }
            }

            //build the column value set of the query:
            foreach ($PersonDetailsArray as $Key => $Value) {
                $ItemCountInt++;

                if ($ItemCountInt !== $NumItemsInt) {
                    $SqlStr .= "'".$Value."',";
                } else {
                    $SqlStr .= $Value.")";
                }
            }

            return $this->ConnectionObj->query($SqlStr);
        }

        function loadPerson($ResultObj): array {
            $PersonArr = array();

            if ($ResultObj->num_rows > 0){
                while($RowArr = $ResultObj->fetch_assoc()) {
                    $PersonArr[] = array(
                        "FirstName" => $RowArr["FirstName"],
                        "Surname" => $RowArr["Surname"],
                        "DateOfBirth" => $RowArr["DateOfBirth"],
                        "EmailAddress" => $RowArr["EmailAddress"],
                        "Age" => $RowArr["Age"]);
                }
            }

            return $PersonArr;
        }

        function savePerson($PersonDetailsArr): bool {

            $OriginalDataArr = array();
            $NewDataArr = array();
            $NumItemsInt = 0;
            $ItemCountInt = 0;
            $OriginalFirstNameStr = "";
            $OriginalSurnameStr = "";
            $SqlStr = "UPDATE `Person` SET ";

            //Separate the Json objects into their respective variables
            foreach($PersonDetailsArr as $DataKey => $DataObjects) {
                if ($DataKey === "OriginalData") {
                    $OriginalDataArr = $DataObjects;
                } else {
                    $NewDataArr = $DataObjects;
                }
            }

            //Check each object in the New Date array and unset any that are blank
            foreach ($NewDataArr as $Item => $Value){
                if($Value){
                    $NumItemsInt++;
                } else {
                    unset($Item);
                }
            }

            //Build the string and only add a comma if it is not the last item
            foreach ($NewDataArr as $Key => $Value) {
                $ItemCountInt++;
                if($Value === null || $Value === ""){
                    continue;
                }

                $SqlStr .= "`".$Key."`='".$Value."'";

                if ($ItemCountInt !== $NumItemsInt) {
                    $SqlStr .= ",";
                }
            }

            //Assign the original First Name and Surname to their respective variables
            //to add to the sql query
            foreach ($OriginalDataArr as $Key => $Value){
                if($Key === "OriginalFirstName") {
                    $OriginalFirstNameStr = $Value;
                } else {
                    $OriginalSurnameStr = $Value;
                }
            }

            $SqlStr .= " WHERE `FirstName`='".$OriginalFirstNameStr."' AND `Surname`='".
                $OriginalSurnameStr."'";

            return $this->ConnectionObj->query($SqlStr);
        }

        function loadAllPeople($PersonDetails): array {
            $SqlStr = "";
            $FirstNameStr = "";
            $SurnameStr = "";

            if ($PersonDetails) {
                foreach ($PersonDetails as $Key => $Value){
                    if ($Key === "FirstName") {
                        $FirstNameStr = $Value;
                    } else if ($Key === "Surname") {
                        $SurnameStr = $Value;
                    }
                }
                $SqlStr .= "SELECT * FROM `Person` WHERE FirstName LIKE '".$FirstNameStr.
                    "%' AND Surname LIKE '".$SurnameStr."%'";
            } else {
                $SqlStr = "SELECT * FROM `Person`";
            }

            $ResultObj = $this->ConnectionObj->query($SqlStr);

            return $this->loadPerson($ResultObj);
        }

        function deletePerson($RequestObj): bool {

            $ActionTypeStr = "";
            $FirstNameStr = "";
            $SurnameStr = "";
            $ResultObj = '';

            foreach ($RequestObj as $Key => $Value) {
                switch ($Key) {
                    case "ActionType":
                        $ActionTypeStr = $Value;
                        break;

                    case "FirstName":
                        $FirstNameStr = $Value;
                        break;

                    case "Surname":
                        $SurnameStr = $Value;
                        break;
                }

            }

            switch($ActionTypeStr){
                case "single":
                    $SqlStr = "DELETE FROM `Person` WHERE `FirstName`='".$FirstNameStr."' AND `Surname`='".$SurnameStr."'";
                    $ResultObj = $this->ConnectionObj->query($SqlStr);
                    break;

                case "all":
                    $ResultObj = $this->deleteAllPeople();
            }


            return $ResultObj;
        }

        function deleteAllPeople(): bool {
            $SqlStr = "DELETE FROM `Person`";
            return $this->ConnectionObj->query($SqlStr);
        }
}