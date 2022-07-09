<?php
//    Start time count and script:
    $StartTimeInt = microtime(true);
    echo "Script started...<br><br>";

//    Connect to the DB with the login details already set in the function:
    $ConnectionObj = connectToDB();

//    Call the class and construct the class variable for the connection:
    $PersonObj = new Person_Class($ConnectionObj);

//    Generate the array with 10 person records, the details have been preset in the function:
    $ListOfPeopleArr = generatePeopleArray();

//    Loop through the 10 records and create each one:
    foreach ($ListOfPeopleArr as $PersonRecordArr){
        $PersonObj->createPerson($PersonRecordArr);
    }

//    !! -- CAREFUL -- !! Delete all existing records in the DB:
//    $PersonObj->deleteAllPeople();

//    Load all records in the DB:
    $PersonObj->loadAllPeople();

//    End script and get end time count
    echo "<br>Script completed...<br>";

    $EndTimeInt = microtime(true);
    $TotalRuntimeInt = round(($EndTimeInt - $StartTimeInt), 4);
    echo "Total runtime is ". $TotalRuntimeInt . " seconds";

    class Person_Class {
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

    function connectToDB() {
        $ServerStr = "localhost";
        $PasswordStr = "";
        $UsernameStr = "root";
        $DataBaseStr = "Person_Database";

        $ConnectionObj = new mysqli($ServerStr,$UsernameStr, $PasswordStr, $DataBaseStr);

        if ($ConnectionObj->connect_error){
            die("Unsuccessful: " . $ConnectionObj->connect_error);
        }

        return $ConnectionObj;
    }

    function generatePeopleArray(): array{
        return array(
            array(
                "FirstName"=>"Spongebob",
                "Surname"=>"SquarePants",
                "DateOfBirth"=>"1986/07/14",
                "EmailAddress"=>"s.squarepants@bikinibottom.com",
                "Age"=> 35
            ),
            array(
                "FirstName"=>"Patrick",
                "Surname"=>"Starfish",
                "DateOfBirth"=>"1984/02/26",
                "EmailAddress"=>"p.starfish@bikinibottom.com",
                "Age"=> 38
            ),
            array(
                "FirstName"=>"Michael",
                "Surname"=>"Jameson",
                "DateOfBirth"=>"1997/01/20",
                "EmailAddress"=>"jamesonm@gmail.com",
                "Age"=> 35
            ),
            array(
                "FirstName"=>"Abe",
                "Surname"=>"Wilson",
                "DateOfBirth"=>"2002/05/09",
                "EmailAddress"=>"abewil112@htmail.com",
                "Age"=> 20
            ),
            array(
                "FirstName"=>"Patricia",
                "Surname"=>"Meyer",
                "DateOfBirth"=>"1956/12/25",
                "EmailAddress"=>"patricia.meyer@houss.co.zak",
                "Age"=> 65
            ),
            array(
                "FirstName"=>"Lisa",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1981/05/09",
                "EmailAddress"=>"lisa.jsimpson@startv.com",
                "Age"=> 41
            ),
            array(
                "FirstName"=>"Marge",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1958/03/19",
                "EmailAddress"=>"marge.simpson@startv.com",
                "Age"=> 64
            ),
            array(
                "FirstName"=>"Bart",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1978/02/23",
                "EmailAddress"=>"bart.simpson@startv.com",
                "Age"=> 44
            ),
            array(
                "FirstName"=>"Maggie",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1989/01/14",
                "EmailAddress"=>"maggie.simpson@startv.com",
                "Age"=> 33
            ),
            array(
                "FirstName"=>"Homer",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1956/05/12",
                "EmailAddress"=>"homer.simpson@startv.com",
                "Age"=> 66
            )
        );
    }