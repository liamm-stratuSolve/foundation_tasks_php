<?php

    class Person {
        public $ConnectionObj;

        function __construct($ConnectionObj){
            $this->ConnectionObj = $ConnectionObj;
        }

        function createPerson($PersonRecordArr): bool{
            $SqlStr = "INSERT INTO `Person`(`FirstName`, `Surname`, `DateOfBirth`, `EmailAddress`, `Age`) VALUES ('".
                $PersonRecordArr["FirstName"]."','".$PersonRecordArr["Surname"]."','".$PersonRecordArr["DateOfBirth"].
                "','".$PersonRecordArr["EmailAddress"]."','".$PersonRecordArr["Age"]."')";

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
            $SqlStr = "UPDATE `Person` SET `FirstName`='".$PersonDetailsArr["FirstName"]."',`Surname`='".
                $PersonDetailsArr["Surname"]."',`DateOfBirth`='".$PersonDetailsArr["DateOfBirth"].
                "',`EmailAddress`='". $PersonDetailsArr["EmailAddress"]."',`Age`='".$PersonDetailsArr["Age"].
                "' WHERE `FirstName`='".$PersonDetailsArr["FirstName"]."'";
            return $this->ConnectionObj->query($SqlStr);
        }

        function deletePerson($FirstNameStr, $SurnameStr): bool {
            $SqlStr = "DELETE FROM `Person` WHERE `FirstName`='".$FirstNameStr."' AND `Surname`='".$SurnameStr."'";
            return $this->ConnectionObj->query($SqlStr);
        }

        function loadAllPeople(): array {
            $PeopleArr = array();
            $SqlStr = "SELECT * FROM `Person`";
            $ResultObj = $this->ConnectionObj->query($SqlStr);
            $PeopleArr[] = $this->loadPerson($ResultObj);

            return $PeopleArr;
        }

        function deleteAllPeople(): bool {
            $SqlStr = "DELETE FROM `Person`";
            return $this->ConnectionObj->query($SqlStr);
        }
}