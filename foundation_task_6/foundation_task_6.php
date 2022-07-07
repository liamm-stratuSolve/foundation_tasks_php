<?php
//    Start time count and script:
    $StartTime = microtime(true);
    echo "Script started...<br><br>";

//    Connect to the DB with the login details already set in the function:
    $Conn = connectToDB();

//    Call the class and construct the class variable for the connection:
    $Person = new Person($Conn);

//    Generate the array with 10 person records, the details have been preset in the function:
    $ListOfPeopleArr = generatePeopleArray();

//    Loop through the 10 records and create each one:
    foreach ($ListOfPeopleArr as $PersonRecord){
        $Person->createPerson($PersonRecord);
    }

//    !! -- CAREFUL -- !! Delete all existing records in the DB:
//    $Person->deleteAllPeople();

//    Load all records in the DB:
    $Person->loadAllPeople();

//    End script and get end time count
    echo "<br>Script completed...<br>";

    $EndTime = microtime(true);
    $TotalRuntime = round(($EndTime - $StartTime), 4);
    echo "Total runtime is ". $TotalRuntime . " seconds";

    class Person {
        public $Connection;

        function __construct($Connection){
            $this->Connection = $Connection;
        }

        function createPerson($PersonRecord) {
            $Sql = "INSERT INTO `person`(`FirstName`, `Surname`, `DateOfBirth`, `EmailAddress`, `Age`) VALUES ('".
                $PersonRecord["FirstName"]."','".$PersonRecord["Surname"]."','".$PersonRecord["DateOfBirth"]."','".
                $PersonRecord["Email"]."','".$PersonRecord["Age"]."')";

            $CreatedResult = $this->Connection->query($Sql);

            if($CreatedResult === true) {
                echo "Record created successfully. <br>";
            } else {
                echo "Failed to create record for ". $PersonRecord["FirstName"] ." ". $PersonRecord["Surname"];
            }
        }

        function loadPerson($Result) {
            if ($Result->num_rows > 0){
                while($Row = $Result->fetch_assoc()) {
                    echo "First Name: " . $Row["FirstName"]. " - Surname: " . $Row["Surname"]. " - Date of Birth: " .
                        $Row["DateOfBirth"]. " - Email: " . $Row["EmailAddress"]. " - Age: " . $Row["Age"]. "<br>";
                }
            } else {
                echo "No Results<br>";
            }
        }

        function savePerson($PersonDetails) {
            $Sql = "UPDATE `person` SET `FirstName`='".$PersonDetails["FirstName"]."',`Surname`='".
                $PersonDetails["Surname"]."',`DateOfBirth`='".$PersonDetails["DateOfBirth"]."',`EmailAddress`='".
                $PersonDetails["Email"]."',`Age`='".$PersonDetails["Age"]."' WHERE `FirstName`='".
                $PersonDetails["FirstName"]."'";
            $Result = $this->Connection->query($Sql);

            if ($Result === true) {
                echo "Record updated successfully.</br>";
            } else {
                echo "Failed to update the record for ". $PersonDetails["FirstName"];
            }
        }

        function deletePerson($FirstName) {
            $Sql = "DELETE FROM `person` WHERE FirstName=".$FirstName;
            $Result = $this->Connection->query($Sql);

            if ($Result === true) {
                echo "Record deleted successfully.";
            } else {
                echo "Failed to delete record: ". $FirstName;
            }

        }

        function loadAllPeople() {
            $Sql = "SELECT * FROM `person`";
            $Result = $this->Connection->query($Sql);

            $this->loadPerson($Result);
        }

        function deleteAllPeople() {
            $Sql = "DELETE FROM `person`";
            $Result = $this->Connection->query($Sql);
            if ($Result === true) {
                echo "All records deleted successfully.<br>";
            } else {
                echo "Failed to delete all records.";
            }
        }
    }

    function connectToDB() {
        $Server = "localhost";
        $Password = "";
        $Username = "root";
        $DataBase = "people_task_6";

        $Connect = new mysqli($Server,$Username, $Password, $DataBase);

        if ($Connect->connect_error){
            die("Unsuccessful: " . $Connect->connect_error);
        }

        return $Connect;
    }

    function generatePeopleArray(): array{
        return array(
            array(
                "FirstName"=>"Spongebob",
                "Surname"=>"SquarePants",
                "DateOfBirth"=>"1986/07/14",
                "Email"=>"s.squarepants@bikinibottom.com",
                "Age"=> 35
            ),
            array(
                "FirstName"=>"Patrick",
                "Surname"=>"Starfish",
                "DateOfBirth"=>"1984/02/26",
                "Email"=>"p.starfish@bikinibottom.com",
                "Age"=> 38
            ),
            array(
                "FirstName"=>"Michael",
                "Surname"=>"Jameson",
                "DateOfBirth"=>"1997/01/20",
                "Email"=>"jamesonm@gmail.com",
                "Age"=> 35
            ),
            array(
                "FirstName"=>"Abe",
                "Surname"=>"Wilson",
                "DateOfBirth"=>"2002/05/09",
                "Email"=>"abewil112@htmail.com",
                "Age"=> 20
            ),
            array(
                "FirstName"=>"Patricia",
                "Surname"=>"Meyer",
                "DateOfBirth"=>"1956/12/25",
                "Email"=>"patricia.meyer@houss.co.zak",
                "Age"=> 65
            ),
            array(
                "FirstName"=>"Lisa",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1981/05/09",
                "Email"=>"lisa.jsimpson@startv.com",
                "Age"=> 41
            ),
            array(
                "FirstName"=>"Marge",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1958/03/19",
                "Email"=>"marge.simpson@startv.com",
                "Age"=> 64
            ),
            array(
                "FirstName"=>"Bart",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1978/02/23",
                "Email"=>"bart.simpson@startv.com",
                "Age"=> 44
            ),
            array(
                "FirstName"=>"Maggie",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1989/01/14",
                "Email"=>"maggie.simpson@startv.com",
                "Age"=> 33
            ),
            array(
                "FirstName"=>"Homer",
                "Surname"=>"Simpson",
                "DateOfBirth"=>"1956/05/12",
                "Email"=>"homer.simpson@startv.com",
                "Age"=> 66
            )
        );
    }