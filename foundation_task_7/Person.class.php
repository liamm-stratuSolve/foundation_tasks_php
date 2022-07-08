<?php

    class Person {
        public $ConnectionObj;

        function __construct($ConnectionObj){
            $this->ConnectionObj = $ConnectionObj;
        }

        function createPerson($PersonRecordArr) {
            $SqlStr = "INSERT INTO `Person`(`FirstName`, `Surname`, `DateOfBirth`, `EmailAddress`, `Age`) VALUES ('".
                $PersonRecordArr["FirstName"]."','".$PersonRecordArr["Surname"]."','".$PersonRecordArr["DateOfBirth"].
                "','".$PersonRecordArr["EmailAddress"]."','".$PersonRecordArr["Age"]."')";

            $ResultObj = $this->ConnectionObj->query($SqlStr);

            if($ResultObj === true) {
                echo "Record created successfully. <br>";
            } else {
                echo "Failed to create record for ". $PersonRecordArr["FirstName"] ." ". $PersonRecordArr["Surname"];
            }
        }

        function loadPerson($ResultObj) {
            if ($ResultObj->num_rows > 0){
                while($RowArr = $ResultObj->fetch_assoc()) {
                    echo "First Name: " . $RowArr["FirstName"]. " - Surname: " . $RowArr["Surname"].
                        " - Date of Birth: " . $RowArr["DateOfBirth"]. " - Email: " . $RowArr["EmailAddress"].
                        " - Age: " . $RowArr["Age"]. "<br>";
                }
            } else {
                echo "No Results<br>";
            }
        }

        function savePerson($PersonDetailsArr) {
            $SqlStr = "UPDATE `Person` SET `FirstName`='".$PersonDetailsArr["FirstName"]."',`Surname`='".
                $PersonDetailsArr["Surname"]."',`DateOfBirth`='".$PersonDetailsArr["DateOfBirth"].
                "',`EmailAddress`='". $PersonDetailsArr["EmailAddress"]."',`Age`='".$PersonDetailsArr["Age"].
                "' WHERE `FirstName`='".$PersonDetailsArr["FirstName"]."'";
            $ResultObj = $this->ConnectionObj->query($SqlStr);

            if ($ResultObj === true) {
                echo "Record updated successfully.</br>";
            } else {
                echo "Failed to update the record for ". $PersonDetailsArr["FirstName"];
            }
        }

        function deletePerson($FirstNameStr, $SurnameStr) {
            $SqlStr = "DELETE FROM `Person` WHERE `FirstName`='".$FirstNameStr."' AND `Surname`='".$SurnameStr."'";
            $ResultObj = $this->ConnectionObj->query($SqlStr);

            if ($ResultObj === true) {
                echo "Record deleted successfully.";
            } else {
                echo "Failed to delete record: ". $FirstNameStr . " " . $SurnameStr;
            }

        }

        function loadAllPeople() {
            $SqlStr = "SELECT * FROM `Person`";
            $ResultObj = $this->ConnectionObj->query($SqlStr);

            $this->loadPerson($ResultObj);
        }

        function deleteAllPeople() {
            $SqlStr = "DELETE FROM `Person`";
            $ResultObj = $this->ConnectionObj->query($SqlStr);
            if ($ResultObj === true) {
                echo "All records deleted successfully.<br>";
            } else {
                echo "Failed to delete all records.";
            }
        }
}