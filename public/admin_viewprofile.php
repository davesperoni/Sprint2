<?php include("Classes/Availability.php"); ?>
<?php
/**
 * Created by PhpStorm.
 * User: Sean H
 * Date: 4/20/17
 * Time: 12:00 PM
 */
session_start();
require 'databasePDO.php';
require 'database.php';
?>
<?php

if(isset($_SESSION['AccountID'])) {


    $adminRecords = $connPDO->prepare('SELECT AccountID,email,password FROM Account WHERE AccountID = :AccountID');
    $adminRecords->bindParam(':AccountID', $_SESSION['AccountID']);
    $adminRecords->execute();
    $results = $adminRecords->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }
    $adminRecords = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where AccountID = :AccountID');
    $adminRecords->bindParam(':AccountID', $_SESSION['AccountID']);
    $adminRecords->execute();
$results = $adminRecords->fetch(PDO::FETCH_ASSOC);

if (count($results) > 0) {
    $personInformation = $results;
}

$adminName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];
}



?>

<?php



$PersonID = $_GET['id'];
$records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0){
    $personInformation = $results;
}


$records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

$user = NULL;

if (count($results) > 0) {
    $user = $results;
}

$VolunteerName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];
$VolunteerPhoneNumber = $personInformation['PhoneNumber'];
$VolunteerEmail = $user['email'];
$PersonID = $personInformation['PersonID'];
$VolunteerAllergy = $personInformation['Allergy'];
$VolunteerPhysicalLimitation = $personInformation['PhysicalLimitation'];

$records = $connPDO->prepare('select EmergencyContact.FirstName, EmergencyContact.MiddleInitial, EmergencyContact.LastName, EmergencyContact.PhoneNumber, EmergencyContact.Relationship from EmergencyContact join Person on EmergencyContact.EmergencyContactID = Person.EmergencyContactID where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0) {
$emergencyContact = $results;
}

$EmergencyContactName = $emergencyContact['FirstName'] . " " . $emergencyContact['MiddleInitial'] . " " . $emergencyContact['LastName'];
$EmergencyContactFirstName = $emergencyContact['FirstName'];
$EmergencyContactMI = $emergencyContact['MiddleInitial'];
$EmergencyContactLastName = $emergencyContact['LastName'];
$EmergencyContactPhoneNumber = $emergencyContact['PhoneNumber'];
$EmergencyContactRelationship = $emergencyContact['Relationship'];


$records = $connPDO->prepare('select Volunteer.YTDHours, Volunteer.YTDMiles, Volunteer.Notes from Volunteer where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0) {
$volunteerInformation = $results;
}

$volunteerYTDHours = $volunteerInformation['YTDHours'];
$volunteerYTDMiles = $volunteerInformation['YTDMiles'];
$volunteerNotes = $volunteerInformation['Notes'];


// SUNDAY

$sqlSunday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1;";
$resultsSunday = mysqli_query($conn, $sqlSunday);

/*$sqlUpdateSunday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1;";
$resultsUpdateSunday = mysqli_query($conn, $sqlUpdateSunday);*/

$sqlSundayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1 AND Availability.AvailableShift = 'morning';";
$resultsSundayMorning = mysqli_query($conn, $sqlSundayMorning);

$sqlSundayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1 AND Availability.AvailableShift = 'afternoon';";
$resultsSundayAfternoon = mysqli_query($conn, $sqlSundayAfternoon);

$sqlSundayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1 AND Availability.AvailableShift = 'night';";
$resultsSundayNight = mysqli_query($conn, $sqlSundayNight);

$resultSunMorn = mysqli_fetch_row($resultsSundayMorning);
$resultSunAfternoon = mysqli_fetch_row($resultsSundayAfternoon);
$resultSunNight = mysqli_fetch_row($resultsSundayNight);


// MONDAY

$sqlMonday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2;";
$resultsMonday = mysqli_query($conn, $sqlMonday);

/*$sqlUpdateMonday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2;";
$resultsUpdateMonday = mysqli_query($conn, $sqlUpdateMonday);*/

$sqlMondayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2 AND Availability.AvailableShift = 'morning';";
$resultsMondayMorning = mysqli_query($conn, $sqlMondayMorning);

$sqlMondayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2 AND Availability.AvailableShift = 'afternoon';";
$resultsMondayAfternoon = mysqli_query($conn, $sqlMondayAfternoon);

$sqlMondayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2 AND Availability.AvailableShift = 'night';";
$resultsMondayNight = mysqli_query($conn, $sqlMondayNight);

$resultMonMorn = mysqli_fetch_row($resultsMondayMorning);
$resultMonAfternoon = mysqli_fetch_row($resultsMondayAfternoon);
$resultMonNight = mysqli_fetch_row($resultsMondayNight);

// TUESDAY

$sqlTuesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3;";
$resultsTuesday = mysqli_query($conn, $sqlTuesday);

/*$sqlUpdateTuesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3;";
$resultsUpdateTuesday = mysqli_query($conn, $sqlUpdateTuesday);*/

$sqlTuesdayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3 AND Availability.AvailableShift = 'morning';";
$resultsTuesdayMorning = mysqli_query($conn, $sqlTuesdayMorning);

$sqlTuesdayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3 AND Availability.AvailableShift = 'afternoon';";
$resultsTuesdayAfternoon = mysqli_query($conn, $sqlTuesdayAfternoon);

$sqlTuesdayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3 AND Availability.AvailableShift = 'night';";
$resultsTuesdayNight = mysqli_query($conn, $sqlTuesdayNight);

$resultTueMorn = mysqli_fetch_row($resultsTuesdayMorning);
$resultTueAfternoon = mysqli_fetch_row($resultsTuesdayAfternoon);
$resultTueNight = mysqli_fetch_row($resultsTuesdayNight);


// WEDNESDAY

$sqlWednesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4;";
$resultsWednesday = mysqli_query($conn, $sqlWednesday);

/*$sqlUpdateWednesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4;";
$resultsUpdateWednesday = mysqli_query($conn, $sqlUpdateWednesday);*/

$sqlWednesdayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4 AND Availability.AvailableShift = 'morning';";
$resultsWednesdayMorning = mysqli_query($conn, $sqlWednesdayMorning);

$sqlWednesdayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4 AND Availability.AvailableShift = 'afternoon';";
$resultsWednesdayAfternoon = mysqli_query($conn, $sqlWednesdayAfternoon);

$sqlWednesdayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4 AND Availability.AvailableShift = 'night';";
$resultsWednesdayNight = mysqli_query($conn, $sqlWednesdayNight);

$resultWedMorn = mysqli_fetch_row($resultsWednesdayMorning);
$resultWedAfternoon = mysqli_fetch_row($resultsWednesdayAfternoon);
$resultWedNight = mysqli_fetch_row($resultsWednesdayNight);

// THURSDAY

$sqlThursday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5;";
$resultsThursday = mysqli_query($conn, $sqlThursday);

/*$sqlUpdateThursday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5;";
$resultsUpdateThursday = mysqli_query($conn, $sqlUpdateThursday);*/

$sqlThursdayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5 AND Availability.AvailableShift = 'morning';";
$resultsThursdayMorning = mysqli_query($conn, $sqlThursdayMorning);

$sqlThursdayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5 AND Availability.AvailableShift = 'afternoon';";
$resultsThursdayAfternoon = mysqli_query($conn, $sqlThursdayAfternoon);

$sqlThursdayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5 AND Availability.AvailableShift = 'night';";
$resultsThursdayNight = mysqli_query($conn, $sqlThursdayNight);

$resultThurMorn = mysqli_fetch_row($resultsThursdayMorning);
$resultThurAfternoon = mysqli_fetch_row($resultsThursdayAfternoon);
$resultThurNight = mysqli_fetch_row($resultsThursdayNight);

// FRIDAY

$sqlFriday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6;";
$resultsFriday = mysqli_query($conn, $sqlFriday);

/*$sqlUpdateFriday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6;";
$resultsUpdateFriday = mysqli_query($conn, $sqlUpdateFriday);*/

$sqlFridayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6 AND Availability.AvailableShift = 'morning';";
$resultsFridayMorning = mysqli_query($conn, $sqlFridayMorning);

$sqlFridayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6 AND Availability.AvailableShift = 'afternoon';";
$resultsFridayAfternoon = mysqli_query($conn, $sqlFridayAfternoon);

$sqlFridayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6 AND Availability.AvailableShift = 'night';";
$resultsFridayNight = mysqli_query($conn, $sqlFridayNight);

$resultFriMorn = mysqli_fetch_row($resultsFridayMorning);
$resultFriAfternoon = mysqli_fetch_row($resultsFridayAfternoon);
$resultFriNight = mysqli_fetch_row($resultsFridayNight);

// SATURDAY

$sqlSaturday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7;";
$resultsSaturday = mysqli_query($conn, $sqlSaturday);

/*$sqlUpdateSaturday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7;";
$resultsUpdateSaturday = mysqli_query($conn, $sqlUpdateSaturday);*/

$sqlSaturdayMorning = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7 AND Availability.AvailableShift = 'morning';";
$resultsSaturdayMorning = mysqli_query($conn, $sqlSaturdayMorning);

$sqlSaturdayAfternoon = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7 AND Availability.AvailableShift = 'afternoon';";
$resultsSaturdayAfternoon = mysqli_query($conn, $sqlSaturdayAfternoon);

$sqlSaturdayNight = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
    JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7 AND Availability.AvailableShift = 'night';";
$resultsSaturdayNight = mysqli_query($conn, $sqlSaturdayNight);

$resultSatMorn = mysqli_fetch_row($resultsSaturdayMorning);
$resultSatAfternoon = mysqli_fetch_row($resultsSaturdayAfternoon);
$resultSatNight = mysqli_fetch_row($resultsSaturdayNight);

$server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sqlVolunteerDepartments = "select distinct Department.DepartmentName FROM Department
JOIN VolunteerDepartment ON Department.DepartmentID = VolunteerDepartment.DepartmentID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID
JOIN Person ON Volunteer.PersonID = Person.PersonID
JOIN Account ON Person.AccountID = Account.AccountID
WHERE Person.PersonID = '$PersonID'";

$resultsDepartments = mysqli_query($conn, $sqlVolunteerDepartments);

$departmentNumber = 0;

// Print Teams

$sqlVolunteerTeams = "select distinct Department.DepartmentName FROM Department
JOIN VolunteerDepartment ON Department.DepartmentID = VolunteerDepartment.DepartmentID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID
JOIN Person ON Volunteer.PersonID = Person.PersonID
JOIN Account ON Person.AccountID = Account.AccountID
WHERE Person.PersonID = '$PersonID';";

$resultsTeams = mysqli_query($conn, $sqlVolunteerTeams);

// Get team lead info for Animal Care dept

		$sqlAnimalCareTeam = "Select Account.Email, Person.FirstName, Person.LastName FROM Account
  JOIN Person ON Account.AccountID = Person.AccountID
  JOIN Employee ON Person.PersonID = Employee.PersonID
  JOIN Department ON Employee.EmployeeID = Department.EmployeeID
  Where Department.DepartmentName = 'Animal Care';";
  
  $resultsAnimalCareTeam = mysqli_query($conn, $sqlAnimalCareTeam);
  
  // Get team lead info for Outreach dept
  
		$sqlOutreachTeam = "Select Account.Email, Person.FirstName, Person.LastName FROM Account
  JOIN Person ON Account.AccountID = Person.AccountID
  JOIN Employee ON Person.PersonID = Employee.PersonID
  JOIN Department ON Employee.EmployeeID = Department.EmployeeID
  Where Department.DepartmentName = 'Outreach';";
  
  $resultsOutreachTeam = mysqli_query($conn, $sqlOutreachTeam);
		
  // Get team lead info for Transport dept

		$sqlTransportTeam = "Select Account.Email, Person.FirstName, Person.LastName FROM Account
  JOIN Person ON Account.AccountID = Person.AccountID
  JOIN Employee ON Person.PersonID = Employee.PersonID
  JOIN Department ON Employee.EmployeeID = Department.EmployeeID
  Where Department.DepartmentName = 'Transport';";
  
  $resultsTransportTeam = mysqli_query($conn, $sqlTransportTeam);
  
  // Get team lead info for Treatment dept
	
		$sqlTreatmentTeam = "Select Account.Email, Person.FirstName, Person.LastName FROM Account
  JOIN Person ON Account.AccountID = Person.AccountID
  JOIN Employee ON Person.PersonID = Employee.PersonID
  JOIN Department ON Employee.EmployeeID = Department.EmployeeID
  Where Department.DepartmentName = 'Treatment';";
  
  $resultsTreatmentTeam = mysqli_query($conn, $sqlTreatmentTeam);





if(isset($_POST['uploadProfilePicture']))
{

    $image = addslashes($_FILES['image']['tmp_name']);
    $name = addslashes($_FILES['image']['name']);
    $image = file_get_contents($image);
    $image = base64_encode($image);

    saveImage($name, $image);

}

function saveImage($name, $image)
{
    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Need to figure out how to get session variable for PersonID to insert
    // and select as well.. Right now it currently displays all pics in DB
    $currentAccountID = $_SESSION['AccountID'];

    $sqlDeleteOldPic = "DELETE FROM picUpload WHERE AccountID = '$currentAccountID'";
    $result = mysqli_query($conn, $sqlDeleteOldPic) or die('Error, query failed');

    $sqlInsertPic = "INSERT INTO picUpload (AccountID, name, image) VALUES ('$currentAccountID', '$name', '$image')";
    $result = mysqli_query($conn, $sqlInsertPic) or die('Error, query failed');
}

function displayImage()
{

    $server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $sqlDisplayPic = "SELECT * FROM picUpload JOIN Account ON Account.AccountID = picUpload.AccountID
  JOIN Person ON Person.AccountID = Account.AccountID WHERE Person.PersonID = '$PersonID'";

    $result = mysqli_query($conn, $sqlDisplayPic) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo '<img src="img/emptyprofilepic.png" class="img-responsive col-xs-8' . '">';
    }
    else {
        while ($row = mysqli_fetch_array($result)) {
            echo '<img class="img-responsive col-xs-8" src="data:image;base64,' . $row[3] . '">';
        }
    }

}

function displayResume()
{

    $server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $query = "SELECT UploadID, name, Person.PersonID FROM Upload
                  JOIN Person ON Upload.PersonID = Person.PersonID
                  JOIN Account ON Person.AccountID = Account.AccountID
                  WHERE Person.PersonID = '$PersonID' AND Person.PersonID = Upload.PersonID
                  AND Upload.Specification = 'Resume'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\"><img src=\"img/resumeDoc.jpg\" class=\"img-responsive\"></a><br>";
        }
    }
}

function displayVaccine()
{

    $server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $query = "SELECT UploadID, name, Person.PersonID FROM Upload
                  JOIN Person ON Upload.PersonID = Person.PersonID
                  JOIN Account ON Person.AccountID = Account.AccountID
                  WHERE Person.PersonID = '$PersonID' AND Person.PersonID = Upload.PersonID
                  AND Upload.Specification = 'Vaccine'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\"><img src=\"img/vaccineDoc.jpg\" class=\"img-responsive\"></a><br>";
        }
    }
}

function displayPermit()
{

    $server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $query = "SELECT UploadID, name, Person.PersonID FROM Upload
                  JOIN Person ON Upload.PersonID = Person.PersonID
                  JOIN Account ON Person.AccountID = Account.AccountID
                  WHERE Person.PersonID = '$PersonID' AND Person.PersonID = Upload.PersonID
                  AND Upload.Specification = 'Permit'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\"><img src=\"img/permitDoc.jpg\" class=\"img-responsive\"></a><br>";
        }
    }
}



if (isset($_POST['UpdateProfile'])) {


    $updateVolunteerPhoneNumber = $_POST['updateVolunteerPhoneNumber'];
    $updateVolunteerEmail = $_POST['updateVolunteerEmail'];
    $updateVolunteerAllergy = $_POST['updateVolunteerAllergies'];
    $updateVolunteerPhysicalLimitation = $_POST['updateVolunteerPhysicalLimitations'];


    $sqlPersonInformation = "UPDATE Person p SET p.PhoneNumber = :phoneNumber, p.Allergy = :allergy, p.PhysicalLimitation = :physicalLimitation where p.PersonID = :PersonID";
    $stmt = $connPDO->prepare($sqlPersonInformation);

    $stmt->bindParam(':phoneNumber', $updateVolunteerPhoneNumber);
    $stmt->bindParam(':allergy', $updateVolunteerAllergy);
    $stmt->bindParam(':physicalLimitation', $updateVolunteerPhysicalLimitation);
    $stmt->bindParam(':PersonID', $PersonID);


    if ($stmt->execute()) {

    } else {
    }

    $sqlAccountInformation = "UPDATE Account a join Person p on a.AccountID = p.AccountID SET a.Email = :email where p.PersonID = :PersonID";
    $stmt = $connPDO->prepare($sqlAccountInformation);

    $stmt->bindParam(':email', $updateVolunteerEmail);
    $stmt->bindParam(':PersonID', $PersonID);

    if ($stmt->execute()) {

    } else {
    }

    $updateEmergencyFirstName = $_POST['updateEmergencyFirstName'];
    $updateEmergencyMiddleInitial = $_POST['updateEmergencyMiddleInitial'];
    $updateEmergencyLastName = $_POST['updateEmergencyLastName'];
    $updateEmergencyPhoneNumber= $_POST['updateEmergencyPhoneNumber'];
    $updateEmergencyRelationship = $_POST['updateEmergencyRelationship'];
    $updateEmergencyLastUpdatedBy = "System";


    $sqlUpdateEmergencyContactInformation = "UPDATE EmergencyContact e join Person p on e.EmergencyContactID = p.EmergencyContactID SET e.FirstName = :firstName , e.MiddleInitial = :middleInitial, e.LastName = :lastName, e.PhoneNumber = :phoneNumber, e.Relationship = :relationship, e.LastUpdatedBy = :lastUpdatedBy, e.LastUpdated = CURRENT_TIMESTAMP where p.PersonID = :PersonID";

    $stmt = $connPDO->prepare($sqlUpdateEmergencyContactInformation);

    $stmt->bindParam(':firstName', $updateEmergencyFirstName);
    $stmt->bindParam(':middleInitial', $updateEmergencyMiddleInitial);
    $stmt->bindParam(':lastName', $updateEmergencyLastName);
    $stmt->bindParam(':phoneNumber', $updateEmergencyPhoneNumber);
    $stmt->bindParam(':relationship', $updateEmergencyRelationship);
    $stmt->bindParam(':PersonID', $PersonID);
    $stmt->bindParam(':lastUpdatedBy', $updateEmergencyLastUpdatedBy);


    if ($stmt->execute()) {

    } else {
    }


    $sqlDeleteAvailability = "delete from Availability where PersonID = :PersonID";

    $stmt = $connPDO->prepare($sqlDeleteAvailability);
    $stmt->bindParam(':PersonID', $PersonID);

    if ($stmt->execute()) {

    } else {
    }


    if(!empty($_POST['updateMonday']))
    {
        foreach($_POST['updateMonday'] as $updateMonday) {

            $newShift = new Availability(2, $PersonID, $updateMonday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateTuesday']))
    {
        foreach($_POST['updateTuesday'] as $updateTuesday) {

            $newShift = new Availability(3, $PersonID, $updateTuesday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateWednesday']))
    {
        foreach($_POST['updateWednesday'] as $updateWednesday) {

            $newShift = new Availability(4, $PersonID, $updateWednesday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateThursday']))
    {
        foreach($_POST['updateThursday'] as $updateThursday) {

            $newShift = new Availability(5, $PersonID, $updateThursday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateFriday']))
    {
        foreach($_POST['updateFriday'] as $updateFriday) {
            $DayID = 6;

            $newShift = new Availability(6, $PersonID, $updateFriday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateSaturday']))
    {
        foreach($_POST['updateSaturday'] as $updateSaturday) {

            $newShift = new Availability(7, $PersonID, $updateSaturday);

            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['updateSunday']))
    {
        foreach($_POST['updateSunday'] as $updateSunday) {

            $newShift = new Availability(1, $PersonID, $updateSunday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
}
                                    $server = '127.0.0.1';
                                    $username = 'homestead';
                                    $password = 'secret';
                                    $database = 'wildlifeDB';

                                    try
                                    {
                                        /*PDO is the new standard for SQL
                                        the most secure way for doing db transactions in php*/
                                        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
                                    }
                                    catch(PDOException $e)
                                    {
                                        die("Connection failed: " . $e->getMessage());
                                    }

                                    $PersonID = $_GET['id'];
                                    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
                                    $records->bindParam(':PersonID', $PersonID);
                                    $records->execute();
                                    $results = $records->fetch(PDO::FETCH_ASSOC);

                                    if(count($results) > 0){
                                        $personInformation = $results;
                                    }


                                    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
                                    $records->bindParam(':PersonID', $PersonID);
                                    $records->execute();
                                    $results = $records->fetch(PDO::FETCH_ASSOC);

                                    $user = NULL;

                                    if (count($results) > 0) {
                                        $user = $results;
                                    }

                                    $PersonID = $personInformation['PersonID'];


                                    $server = "127.0.0.1";
                                    $username = "homestead";
                                    $password = "secret";
                                    $database = "wildlifeDB";

                                    $conn = new mysqli($server, $username, $password, $database);

                                    if ($conn->connect_error) {
                                        die("connection failed!\n" . $conn->connect_error);
                                    } else {
                                    }
                                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                                    $sqlCountDocs = "SELECT COUNT(*) AS DocCount FROM Upload 
                                      JOIN Person ON Upload.PersonID = Person.PersonID
                                      JOIN Account ON Person.AccountID = Account.AccountID
                                      WHERE Person.PersonID = '$PersonID' AND Person.PersonID = Upload.PersonID";

                                    $result = mysqli_query($conn, $sqlCountDocs);
                                    while($row = mysqli_fetch_array($result)) {
                                        $docCount = $row['DocCount'];
                                    }

                                    $UploadCount = $docCount;

if(isset($_POST['uploadDocument'])) {

    $server = '127.0.0.1';
    $username = 'homestead';
    $password = 'secret';
    $database = 'wildlifeDB';

    try
    {
        /*PDO is the new standard for SQL
        the most secure way for doing db transactions in php*/
        $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }
    catch(PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    $PersonID = $_GET['id'];
    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account join Person ON Account.AccountID = Person.AccountID Where Person.PersonID = :PersonID');
    $records->bindParam(':PersonID', $PersonID);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if (count($results) > 0) {
        $user = $results;
    }

    $PersonID = $personInformation['PersonID'];


    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $fileName = $_FILES['newDoc']['name'];
    $tmpName = $_FILES['newDoc']['tmp_name'];
    $fileSize = $_FILES['newDoc']['size'];
    $fileType = $_FILES['newDoc']['type'];
    $specification = $_POST['Specifications'];

    $fp = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    $sqlInsertNewDoc = "INSERT INTO Upload (PersonID, Name, Specification, Size, Type, Content) " .
        "VALUES ('$PersonID', '$fileName', '$specification', '$fileSize', '$fileType', '$content')";

    $stmt = mysqli_prepare($conn, $sqlInsertNewDoc);


    if ($stmt) {

        $stmt->execute();
    }
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | User Profile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/personPicSmall.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $adminName ?></strong>
                             </span> <span class="text-muted text-xs block">Team Lead<?php while($row = mysqli_fetch_array($resultsDepartments)) { $departmentNumber++; } ?><b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.php">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li>
                    <a href="/admin_dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="/who's_here.php"><i class="fa fa-users"></i> <span class="nav-label">Who's Here</span></a>
                </li>
                <li>
                    <a target="_blank" href="/Calendar/index.php"><i class="fa fa-calendar"></i> <span class="nav-label">Calendar</span></a></li>
                <li>
                <li class="active">
                    <a href="/search_volunteers_admin.php"><i class="fa fa-search"></i> <span class="nav-label">Search</span></a>
                </li>
				<li>
                    <a href="/training_admin_view.php"><i class="fa fa-cogs"></i> <span class="nav-label">Training</span>  </a>
                </li>
                <li>
                    <a href="/pending_apps.php"><i class="fa fa-clipboard"></i> <span class="nav-label">Applications</span>  </a>
                </li>
                <li>
                    <a href="/statistics_admin.php"><i class="fa fa-bar-chart"></i> <span class="nav-label">Statistics</span>  </a>
                </li class = "active">				
                <li>
                    <a href="/admin_profile.php"><i class="fa fa-user"></i> <span class="nav-label">My Profile</span>  </a>
                </li>

            </ul>
        </div>


    </nav> <!-- end of navigation -->


    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>


                </div>

                 

                <ul class="nav navbar-top-links navbar-right">

                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper-prof border-bottom white-bg page-heading">
            <div class="col-lg-12">
                  <img src="img/mtn.jpg" class="img-responsive">
            </div>

        </div>
        <div class="wrapper-prof wrapper-content-prof">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div>
                            <div class="ibox-content">
                                <div class="profile">
                                    <?php
                                    displayImage();
                                    ?>
                                </div>
                                <div class="col-xs-1">
                                    <div class="edit">
                                        <!-- Button trigger modal -->

                                        <a href="#" data-toggle="modal" data-target="#profilePicture"><!--<i class="fa fa-pencil edit"></i>--></a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="profilePicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form id ="changeProfilePictureForm" method = "post">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title pull-left" >Change Profile Picture</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body btmSpace">

                                                            <div class="fileinput fileinput-new pull-left moveDown" data-provides="fileinput">
                                                                <span class="btn btn-default btn-file" name ="pictureUpload"><input type="file"></span>
                                                                <span class="fileinput-filename"></span>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                            <button type="submit" name ="uploadProfilePicture" class="btn-edit-form">UPLOAD</button>
                                                        </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>



                    <div class="ibox-content profile-content">
                        <!-- trigger modal pencil icon -->
                        <a href="#" data-toggle = "modal" data-target = "#myModal"><!--<i class="fa fa-pencil edit pull-right moveDown"></i>--></a>

                        <!-- modal content aka FORM THAT POPS OPEN ON CLICK OF PENCIL -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title-2 no-margin" id="myModalLabel">Edit Profile Information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form  class = "pop-up-form" method="post">
                                            <h2 class = "form-title"> PERSONAL INFORMATION </h2>
                                            <label>Phone:</label> <input type = "text" name = "updateVolunteerPhoneNumber" size = "12" value = <?php echo $VolunteerPhoneNumber ?>><br>
                                            <label>Email:</label> <input type = "email" name ="updateVolunteerEmail" value = <?php echo $VolunteerEmail ?>><br>
                                            <hr class = "pop-up-form">
                                            <h2 class = "form-title">EMERGENCY CONTACT INFO
                                            </h2>

                                            <div style="float:left;margin-right:20px;">
                                                <label class = "label-top" for="name">First Name:</label>
                                                <input class = "label-top" id="emergencyname" type="text" name="updateEmergencyFirstName" value=<?php echo $EmergencyContactFirstName ?>>
                                            </div>
                                            <div style="float:left;margin-right:20px;">
                                                <label class = "label-top" for="name">Middle Initial:</label>
                                                <input class = "label-top" id="name" type="text" name="updateEmergencyMiddleInitial" size="1" maxlength="1" value=<?php echo $EmergencyContactMI ?> >
                                            </div>
                                            <div style="float:left;margin-right:20px;">
                                                <label class = "label-top" for="name">Last Name:</label>
                                                <input class = "label-top" id="name" type="text" name="updateEmergencyLastName" value= <?php echo $EmergencyContactLastName ?>><br>
                                            </div>
                                            <div class = "label-top">
                                                <label class = "modal-label">Phone:</label> <input type = "text" name = "updateEmergencyPhoneNumber" size = "12" value = <?php echo $EmergencyContactPhoneNumber ?>><br>
                                            </div>
                                            <div>
                                                <label class = "modal-label">Relationship:</label> <input type = "text" name = "updateEmergencyRelationship" value = <?php echo $EmergencyContactRelationship ?>><br>
                                            </div>
                                            <div>
                                                <div>
                                                    Allergies:<br><textarea rows="4" cols="70" name = "updateVolunteerAllergies"> <?php echo $VolunteerAllergy ?></textarea>
                                                </div>

                                                <div>
                                                    Physical Limitation:<br><textarea rows="4" cols="70" name = "updateVolunteerPhysicalLimitations" ><?php echo $VolunteerPhysicalLimitation ?></textarea>
                                                </div>
                                                <hr class = "pop-up-form">
                                            </div>

                                            <h2 class = "form-title"> AVAILABILITY</h2>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td class = "avail_space table-date-title"> SUNDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateSunday[]" value="morning"'; ?>
                                                        <?php if($resultSunMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateSunday[]" value="afternoon"'; ?>
                                                        <?php  if($resultSunAfternoon != null) { echo 'checked="checked"'; } else {echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateSunday[]" value="night"'; ?>
                                                        <?php if($resultSunNight != null) { echo 'checked="checked"'; } else {echo ' ';}?><?php echo '>Night</td>' ?>
                                                </tr>

                                                <tr>
                                                    <td class = "avail_space table-date-title"> MONDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateMonday[]" value="morning"'; ?>
                                                        <?php if($resultMonMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateMonday[]" value="afternoon"'; ?>
                                                        <?php  if($resultMonAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateMonday[]" value="night"'; ?>
                                                        <?php if($resultMonNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>

                                                <tr>
                                                    <td class = "avail_space table-date-title"> TUESDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateTuesday[]" value="morning"'; ?>
                                                        <?php if($resultTueMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateTuesday[]" value="afternoon"'; ?>
                                                        <?php  if($resultTueAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateTuesday[]" value="night"'; ?>
                                                        <?php if($resultTueNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>

                                                <tr>
                                                    <td class = "avail_space table-date-title"> WEDNESDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateWednesday[]" value="morning"'; ?>
                                                        <?php if($resultWedMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateWednesday[]" value="afternoon"'; ?>
                                                        <?php  if($resultWedAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateWednesday[]" value="night"'; ?>
                                                        <?php if($resultWedNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>

                                                <tr>
                                                    <td class = "avail_space table-date-title"> THURSDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateThursday[]" value="morning"'; ?>
                                                        <?php if($resultThurMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateThursday[]" value="afternoon"'; ?>
                                                        <?php  if($resultThurAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateThursday[]" value="night"'; ?>
                                                        <?php if($resultThurNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>

                                                <tr>
                                                    <td class = "avail_space table-date-title"> FRIDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateFriday[]" value="morning"'; ?>
                                                        <?php if($resultFriMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateFriday[]" value="afternoon"'; ?>
                                                        <?php  if($resultFriAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateFriday[]" value="night"'; ?>
                                                        <?php if($resultFriNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>


                                                <tr>
                                                    <td class = "avail_space table-date-title"> SATURDAY </td>
                                                    <td class = "avail_space" >


                                                        <?php echo '<input type="checkbox" name="updateSaturday[]" value="morning"'; ?>
                                                        <?php if($resultSatMorn != null) { echo 'checked="checked"'; } else {echo ' ';} ?><?php echo '>Morning</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php echo '<input type="checkbox" name="updateSaturday[]" value="afternoon"'; ?>
                                                        <?php  if($resultSatAfternoon != null) { echo 'checked="checked"'; } else { echo ' ';}?> <?php echo '>Afternoon</td>' ?>

                                                    <td class = "avail_space">
                                                        <?php  echo '<input type="checkbox" name="updateSaturday[]" value="night"'; ?>
                                                        <?php if($resultSatNight != null) { echo 'checked="checked"'; } else { echo ' ';} ?><?php echo '>Night</td>' ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                <button name = "UpdateProfile" type = "submit" class="btn-edit-form">SAVE CHANGES</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- continue profile content -->
                        <h2><?php echo $VolunteerName ?></h2>
                        <h4>Volunteer</h4>
                        <p><?php echo $VolunteerPhoneNumber ?><br/>
                            <em><?php echo $VolunteerEmail ?></em></p>
                        <hr/>

                        <h4>Emergency Information</h4>
                        <p class="emergency">Emergency Contact</p>
                        <p><?php echo $EmergencyContactName ?><br/>
                            <?php echo $EmergencyContactPhoneNumber ?><br/>
                            <em><?php echo $EmergencyContactRelationship ?></em></p>
                        <p>
                        <p class="emergency">Allergies: </p>
                        <p><?php echo $VolunteerAllergy ?></p>
                        <p class="emergency">Physical Limitations: </p>
                        <p><?php echo $VolunteerPhysicalLimitation ?></p>
                        <hr>
                        <h4>Availability</h4>
                        <div class="col-sm-4">
                            <table class = "ibox-content">
                                <tbody >
                                <tr>
                                    <td class = "avail_space table-date-title"> SUN. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsSunday)) {
                                    $sundayShift = $row['AvailableShift'];?>

                                    <td class = "avail_space"> <?php echo $sundayShift ?> <?php } ?></td>

                                </tr>

                                <tr>
                                    <td class = "avail_space table-date-title"> MON. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsMonday)) {
                                    $mondayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space"> <?php echo $mondayShift ?> <?php }?></td>

                                </tr>

                                <tr>
                                    <td class = "avail_space table-date-title"> TUES. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsTuesday)) {
                                    $tuesdayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space"> <?php echo $tuesdayShift ?> <?php }?></td> </td>

                                </tr>

                                <tr>
                                    <td class = "avail_space table-date-title"> WED. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsWednesday)) {
                                    $wednesdayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space"> <?php echo $wednesdayShift ?> <?php }?></td> </td>

                                </tr>

                                <tr>
                                    <td class = "avail_space table-date-title"> THURS. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsThursday)) {
                                    $thursdayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space">  <?php echo $thursdayShift ?> <?php }?></td> </td>

                                </tr>

                                <tr>
                                    <td class = "avail_space table-date-title"> FRI. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsFriday)) {
                                    $fridayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space"> <?php echo $fridayShift ?> <?php }?></td> </td>

                                </tr>


                                <tr>
                                    <td class = "avail_space table-date-title"> SAT. </td>
                                    <?php
                                    while($row = mysqli_fetch_array($resultsSaturday)) {
                                    $saturdayShift = $row['AvailableShift']; ?>

                                    <td class = "avail_space"> <?php echo $saturdayShift ?> <?php }?></td> </td>

                                </tr>

                                </tbody>
                            </table>

                        </div>




                        <div class="user-button">
                            <div class="row">

                            </div>
                        </div>
                    </div>
                    <div class=grayback>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="ibox float-e-margins">
            </div>
            <div class="counters">
                <div class="col-md-6">
                    <div class="hours">
                        <h3>YOU HAVE WORKED</h3>
                        <h1><?php echo $volunteerYTDHours ?></h1>
                        <h3>HOURS</h3>
                    </div>
                </div>
            </div>
            <div class="counters">
                <div class="col-md-6">
                    <div class="miles">
                        <h3>YOU HAVE DRIVEN</h3>
                        <h1><?php echo $volunteerYTDMiles ?></h1>
                        <h3>MILES</h3>
                    </div>
                </div>
            </div>
            <div class="ibox-content">

                <div class="docspadding">
                    <div class="col-md-12">
                        <div class="feed-activity-list">
                            <div class="col-md-8">
                                <div class="col-md-2">
                                    <h1><?php echo $departmentNumber ?></h1>
                                </div><!-- end of col-md-2-->

                                <div class="col-md-6">
                                    <h3>Teams</h3>
                                </div>

                            </div><!-- end of col-md-8-->

                            <div class="col-md-4">
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo"><i class="fa fa-angle-down"></i></button>
                            </div>
                            <div class="col-md-5">
                            </div>

                            <div id="demo" class="collapse">
                                <div class="col-md-12">
                                    <?php while($rowDept = mysqli_fetch_array($resultsTeams)) {
												
												if($rowDept['DepartmentName'] === 'Animal Care' ){ echo "<h4>" . $rowDept['DepartmentName'] . "<br/>"; ?></h4>
												<p class="emergency"><br/><?php while($rowTeamLeadInfo = mysqli_fetch_array($resultsAnimalCareTeam)) 
												{echo $rowTeamLeadInfo['FirstName'] . " " . $rowTeamLeadInfo['LastName'] . "<br/>" . $rowTeamLeadInfo['Email']; }} ?> </p>
												<?php
												if($rowDept['DepartmentName'] === 'Outreach' ){ echo "<h4>" . $rowDept['DepartmentName'] . "<br/>"; ?></h4>
												<p class="emergency"><br/><?php while($rowTeamLeadInfo = mysqli_fetch_array($resultsOutreachTeam)) 
												{echo $rowTeamLeadInfo['FirstName'] . " " . $rowTeamLeadInfo['LastName'] . "<br/>" . $rowTeamLeadInfo['Email']; }}?> </p>
												<?php
												if($rowDept['DepartmentName'] === 'Transport' ){ echo "<h4>" . $rowDept['DepartmentName'] . "<br/>"; ?></h4>
												<p class="emergency"><br/><?php while($rowTeamLeadInfo = mysqli_fetch_array($resultsTransportTeam)) 
												{echo $rowTeamLeadInfo['FirstName'] . " " . $rowTeamLeadInfo['LastName'] . "<br/>" . $rowTeamLeadInfo['Email']; }}?> </p>
												<?php
												if($rowDept['DepartmentName'] === 'Treatment' ){ echo "<h4>" . $rowDept['DepartmentName'] . "<br/>"; ?></h4>
												<p class="emergency"><br/><?php while($rowTeamLeadInfo = mysqli_fetch_array($resultsTreatmentTeam)) 
												{echo $rowTeamLeadInfo['FirstName'] . " " . $rowTeamLeadInfo['LastName'] . "<br/>" . $rowTeamLeadInfo['Email']; }}?> </p>
											
										<?php	} ?>
                                </div>
                            </div><!-- end of id = demo collapse -->
                        </div>
                    </div><!-- end of row -->
                    <div class="modal fade" id="addDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form id ="addDocument" method = "post" enctype="multipart/form-data">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title pull-left" >Upload Documents</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body btmSpace">

                                        <label>Type of Document</label>
                                        <select name="Specifications">
                                            <option> - Type - </option>
                                            <option value="Resume">Resume</option>
                                            <option value="Vaccine">Vaccine</option>
                                            <option value="Permit">Permit</option>
                                        </select>

                                        <div class="fileinput fileinput-new pull-left moveDown" data-provides="fileinput">
                                            <span class="btn btn-default btn-file"><input type="file" name="newDoc"></span>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                        <button type="submit" name ="uploadDocument" class="btn-edit-form">UPLOAD</button>
                                    </div>
                        </form>

                                </div>
                </div>
            </div>

                    <div class="col-md-12">
                        <div class="feed-activity-list">
                            <div class="col-md-8">
                                <div class="col-md-3">
                                    <h1><?php echo $UploadCount ?></h1>
                                </div>

                                <div class="col-md-6">
                                    <h3>
                                        Documents
                                        <a href="#" id="addDocument1" data-toggle="modal" data-target="#addDocument"><i class="fa fa-plus-circle edit"></i></a>
                                    </h3>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <button type="button" class="btn btn-info2" data-toggle="collapse" data-target="#demo2"><i class="fa fa-angle-down"></i></button>
                            </div>
                            <div class="col-md-5">
                            </div>
                            <div id="demo2" class="collapse">
                                <div class="col-md-12">
                                    <!--<h4>Outreach</h4>
                                    <p class="emergency">Raina Krasner<br/>
                                        <em>Rkrasner@wildlifecenter.org</em></p>

                                    <h4>Veterinary</h4>
                                    <p class="emergency">Leigh-Ann Horne<br/>
                                        <em>Lhorne@wildlifecenter.org</em></p> -->

                                    <div class="docs">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="docspadding">
                                                    <?php
                                                    displayResume();
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="docspadding">
                                                    <?php
                                                    displayVaccine();
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="docspadding">
                                                    <?php
                                                    displayPermit();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


</div>

</div>





<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity -->
<script src="js/demo/peity-demo.js"></script>

</body>

</html>
