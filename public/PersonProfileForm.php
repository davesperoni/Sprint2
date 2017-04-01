<?php include("Classes/Person.php"); ?>
<?php include("Classes/EmergencyContact.php"); ?>
<?php include("Classes/Availability.php"); ?>

<?php
session_start();


/**
 * Created by PhpStorm.
 * User: David Speroni
 * Date: 3/30/17
 * Time: 11:10 AM
 */


if (isset($_POST['SubmitPersonProfileForm'])) {

    header("Location: /PersonApplicationForm.php");
    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    }
    else
    {
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $EmergencyFirstName = $_POST['EmergencyFirstName'];
    $EmergencyMiddleInitial = $_POST['EmergencyMiddleInitial'];
    $EmergencyLastName = $_POST['EmergencyLastName'];
    $EmergencyPhoneNumber= $_POST['EmergencyPhoneNumber'];
    $EmergencyRelationship = $_POST['EmergencyRelationship'];

    $newEmergencyContact = new EmergencyContact($EmergencyFirstName, $EmergencyMiddleInitial, $EmergencyLastName, $EmergencyPhoneNumber, $EmergencyRelationship);

    $EmergencyFirstName = $newEmergencyContact->getEmergencyFirstName();
    $EmergencyMiddleInitial = $newEmergencyContact->getEmergencyMiddleInitial();
    $EmergencyLastName = $newEmergencyContact->getEmergencyLastName();
    $EmergencyPhoneNumber = $newEmergencyContact->getEmergencyPhoneNumber();
    $EmergencyRelationship = $newEmergencyContact->getEmergencyRelationship();
    $EmergencyLastUpdatedBy =$newEmergencyContact->getEmergencyLastUpdatedBy();
    $EmergencyLastUpdated =$newEmergencyContact->getEmergencyLastUpdated();

    $sqlEmergencyContact = "INSERT INTO EmergencyContact (FirstName, MiddleInitial, LastName, PhoneNumber, Relationship, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_prepare($conn, $sqlEmergencyContact);
    $stmt->bind_param("ssssss", $EmergencyFirstName, $EmergencyMiddleInitial, $EmergencyLastName, $EmergencyPhoneNumber, $EmergencyRelationship, $EmergencyLastUpdatedBy);

    if($stmt) {

        $stmt->execute();
    }
    echo "Emergency Contact added to database!";

    $EmergencyContactID = $conn->insert_id;

    echo "New record created successfully. Last inserted ID is: " . $EmergencyContactID;


    $PersonFirstName = $_POST['PersonFirstName'];
    $PersonMiddleInitial = $_POST['PersonMiddleInitial'];
    $PersonLastName = $_POST['PersonLastName'];
    $PersonStreetAddress = $_POST['PersonStreetAddress'];
    $PersonCity = $_POST['PersonCity'];
    $PersonStateAbb = $_POST['PersonState'];
    $PersonCountryAbb = $_POST['PersonCountry'];
    $PersonZipCode = $_POST['PersonZipCode'];
    $PersonEmail = $_POST['PersonEmail'];
    $PersonPhoneNumber= $_POST['PersonPhoneNumber'];
    $PersonDateOfBirthYear = $_POST['PersonDOBYear'];
    $PersonDateOfBirthMonth = $_POST['PersonDOBMonth'];
    $PersonDateOfBirthDay = $_POST['PersonDOBDay'];
    $PersonDateOfBirth = $PersonDateOfBirthYear . '-' . $PersonDateOfBirthMonth . '-' . $PersonDateOfBirthDay;
    $PersonAllergy = $_POST['PersonAllergy'];
    $PersonPhysicalLimitation = $_POST['PersonPhysical'];
    $PersonHavePermit = $_POST['PersonHavePermit'];
    $PersonPermitType = $_POST['PersonPermitType'];
    $PersonRabies = $_POST['PersonRabies'];
//$PersonNotes = $_POST['PersonNotes'];

    $PersonAccountID = $_SESSION['AccountID'];

    $newPerson = new Person($EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName, $PersonStreetAddress, $PersonCity, $PersonStateAbb, $PersonCountryAbb, $PersonZipCode, $PersonPhoneNumber, $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies);

    $EmergencyContactID = $newPerson->getEmergencyContactID();
    $PersonAccountID = $newPerson->getPersonAccountID();
    $PersonFirstName = $newPerson->getPersonFirstName();
    $PersonMiddleInitial = $newPerson->getPersonMiddleInitial();
    $PersonLastName = $newPerson->getPersonLastName();
    $PersonStreetAddress = $newPerson->getPersonStreetAddress();
    $PersonCity = $newPerson->getPersonCity();
    $PersonStateAbb = $newPerson->getPersonStateAbb();
    $PersonCountryAbb = $newPerson->getPersonCountryAbb();
    $PersonZipCode = $newPerson->getPersonZipCode();
    $PersonPhoneNumber = $newPerson->getPersonPhoneNumber();
    $PersonDateOfBirth = $newPerson->getPersonDateOfBirth();
    $PersonAllergy = $newPerson->getPersonAllergy();
    $PersonPhysicalLimitation = $newPerson->getPersonPhysicalLimitation();
    $PersonHavePermit = $newPerson->getPersonHavePermit();
    $PersonPermitType = $newPerson->getPersonPermitType();
    $PersonRabies = $newPerson->getPersonRabiesVaccine();
//$PersonNotes = $newPerson->getPersonNotes();
    $PersonLastUpdatedBy = $newPerson->getPersonLastUpdatedBy();
    $PersonLastUpdated = $newPerson->getPersonLastUpdated();


    $sqlPerson = "INSERT INTO Person (EmergencyContactID, AccountID, FirstName, MiddleInitial, LastName, StreetAddress, City, State, Country, ZipCode, PhoneNumber, DateOfBirth, Allergy, PhysicalLimitation, HavePermit, PermitType, RabiesVaccine, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ? , ?, ?, ? , ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_prepare($conn, $sqlPerson);
    $stmt->bind_param("iisssssssissssssss", $EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName,
        $PersonStreetAddress, $PersonCity, $PersonStateAbb, $PersonCountryAbb, $PersonZipCode, $PersonPhoneNumber,
        $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies,
        $PersonLastUpdatedBy);

    if($stmt) {

        $stmt->execute();

        $PersonID = $conn->insert_id;

        echo "Person added! Last ID added" . $PersonID;

    }

    if(!empty($_POST['monday']))
    {
        foreach($_POST['monday'] as $monday) {
            if ($monday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($monday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($monday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(2, $PersonID, $AvailabilityShiftID, $monday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['tuesday']))
    {
        foreach($_POST['tuesday'] as $tuesday) {
            if ($tuesday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($tuesday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($tuesday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(3, $PersonID, $AvailabilityShiftID, $tuesday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['wednesday']))
    {
        foreach($_POST['wednesday'] as $wednesday) {
            if ($wednesday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($wednesday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($wednesday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(4, $PersonID, $AvailabilityShiftID, $wednesday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['thursday']))
    {
        foreach($_POST['thursday'] as $thursday) {
            if ($thursday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($thursday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($thursday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(5, $PersonID, $AvailabilityShiftID, $thursday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['friday']))
    {
        foreach($_POST['friday'] as $friday) {
            if ($friday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($friday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($friday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(6, $PersonID, $AvailabilityShiftID, $friday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['saturday']))
    {
        foreach($_POST['saturday'] as $saturday) {
            if ($saturday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($saturday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($saturday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(7, $PersonID, $AvailabilityShiftID, $saturday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }
    if(!empty($_POST['sunday']))
    {
        foreach($_POST['sunday'] as $sunday) {
            if ($sunday === "morning")
            {
                $AvailabilityShiftID = 1;
            }
            else if ($sunday === "afternoon")
            {
                $AvailabilityShiftID = 2;
            }
            else if ($sunday === "evening")
            {
                $AvailabilityShiftID = 3;
            }
            $newShift = new Availability(1, $PersonID, $AvailabilityShiftID, $sunday);
            $AvailabilityDayID = $newShift->getAvailabilityDayID();
            $AvailabilityPersonID = $newShift->getAvailabilityPersonID();
            $AvailabilityShiftID = $newShift->getAvailabilityShiftID();
            $AvailabilityShift = $newShift->getAvailabilityShift();
            $AvailabilityLastUpdatedBy = $newShift->getAvailabilityLastUpdatedBy();
            $AvailabilityLastUpdated = $newShift->getAvailabilityLastUpdated();
            $sqlInsertShift = "INSERT INTO Availability (DayID, PersonID, AvailabilityShiftID, AvailableShift, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = mysqli_prepare($conn, $sqlInsertShift);
            $stmt->bind_param("iiiss", $AvailabilityDayID, $AvailabilityPersonID, $AvailabilityShiftID, $AvailabilityShift, $AvailabilityLastUpdatedBy);
            if ($stmt) {
                $stmt->execute();
            }
        }
    }

    // FOR RESUME
    $fileName = $_FILES['resumeUpload']['name'];
    $tmpName  = $_FILES['resumeUpload']['tmp_name'];
    $fileSize = $_FILES['resumeUpload']['size'];
    $fileType = $_FILES['resumeUpload']['type'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    $sqlInsertResume = "INSERT INTO resumeUpload (PersonID, name, size, type, content ) ".
        "VALUES ('$PersonID', '$fileName', '$fileSize', '$fileType', '$content')";

    $stmt = mysqli_prepare($conn, $sqlInsertResume);

    if ($stmt) {

        $stmt->execute();
    }


    // FOR VACCINE
    $fileName = $_FILES['vaccineUpload']['name'];
    $tmpName  = $_FILES['vaccineUpload']['tmp_name'];
    $fileSize = $_FILES['vaccineUpload']['size'];
    $fileType = $_FILES['vaccineUpload']['type'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    $sqlInsertVaccine = "INSERT INTO vaccineUpload (PersonID, name, size, type, content, LastUpdatedBy, LastUpdated) ".
        "VALUES ('$PersonID', '$fileName', '$fileSize', '$fileType', '$content', 'system', CURRENT_TIMESTAMP)";

    $stmt = mysqli_prepare($conn, $sqlInsertVaccine);

    if ($stmt) {

        $stmt->execute();
    }


}

?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create A Profile</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">



</head>

<body class="grayform">
<div class="ibox-content-form">
    <div class="formpadding">
        <div class="row">
            <div class="smallerheader"><h1>Create a Profile</h1>
                <p>Thank you for your interest in The Wildlife Center of Virginia. Please fill out the form below to create a profile.</p></div>

            <div class="col-sm-12">
                <form role="form" name="PersonProfileForm" method="post" action="PersonProfileForm.php" enctype="multipart/form-data">
                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" name="PersonFirstName" placeholder="Enter first name" class="form-control"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" name="PersonMiddleInitial" placeholder="Enter middle initial" class="form-control"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" name="PersonLastName" placeholder="Enter last name" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Email</label> <input type="email" name="PersonEmail" placeholder="Enter email" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>Birthday</label>
                            <select name="PersonDOBMonth">
                                <option> - Month - </option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>

                            <select name="PersonDOBDay">
                                <option> - Day - </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>

                            <select name="PersonDOBYear">
                                <option> - Year - </option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>

                            </select>


                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Phone</label> <input type="phone" name="PersonPhoneNumber" placeholder="Enter phone number" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Street Address</label> <input type="address" name="PersonStreetAddress" placeholder="Enter street address" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>City</label> <input type="city" placeholder="Enter city" name="PersonCity" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>State</label><br/>
                            <select name="PersonState">
                                <option value = "VA">Virginia</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>Country</label><br/>
                            <select name="PersonCountry">
                                <option value="US">United States</option>
                                <option value="null">--------------</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia, Plurinational State of</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, the Democratic Republic of the</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Côte d'Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curaçao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and McDonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Réunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="BL">Saint Barthélemy</option>
                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MF">Saint Martin (French part)</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten (Dutch part)</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                <option value="VN">Vietnam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.S.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select>
                        </div></div>


                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Zip Code</label> <input type="zip" name="PersonZipCode" placeholder="Enter zip code" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><h4>Emergency Contact Information</h4></div></div>

                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" name="EmergencyFirstName" placeholder="Enter first name" class="form-control"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" name="EmergencyMiddleInitial" placeholder="Enter middle initial" class="form-control"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" name="EmergencyLastName" placeholder="Enter last name" class="form-control"></div></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Relationship to Contact</label> <input type="relationship" name="EmergencyRelationship" placeholder="Enter relationship to contact" class="form-control"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Emergency Contact Phone Number</label> <input type="phone" name="EmergencyPhoneNumber" placeholder="Enter contact's number" class="form-control"></div></div>


                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Allergies</label> <textarea rows="4" type="allergies" name="PersonAllergy" placeholder="Enter allergies" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Physical Limitations</label> <textarea rows="4" type="limits" name="PersonPhysical" placeholder="Enter physical limitations" class="form-control"></textarea></div></div>


                    <div class="form-group"><div class="col-md-6 col-md-offset-3"><label>I have my rabies vaccine: </label><form action="/action_page.php" method="get"></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><input type="checkbox" name="PersonRabies" value="Yes">Yes<br/>
                                <input type="checkbox" name="PersonRabies" value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please upload a copy of your paperwork.</label></div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><label class="btn btn-default btn-file"><input name="vaccineUpload" type="file" hidden>
                                </label></div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Do you have a valid permit to rehabilitate wildlife in the state of Virginia?</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <input type="checkbox" name="PersonHavePermit" value="Yes">Yes<br>
                                <input type="checkbox" name="PersonHavePermit" value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please select which kind:</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <select name="PersonPermitType">
                                    <option value="cat1">Cat 1</option>
                                    <option value="cat2">Cat 2</option>
                                    <option value="cat3">Cat 3</option>
                                    <option value="cat4">Cat 4</option>
                                </select>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>I'm available:</label></div>
                        <div class="col-md-6 col-md-offset-3" name="PersonAvailability">

                            <fieldset>
                                <label id = "monday">MONDAY</label>
                                <label><input type = "checkbox" name = "monday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "monday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "monday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "tuesday">TUESDAY</label>
                                <label><input type = "checkbox" name = "tuesday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "tuesday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "tuesday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "wednesday">WEDNESDAY</label>
                                <label><input type = "checkbox" name = "wednesday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "wednesday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "wednesday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "thursday">THURSDAY</label>
                                <label><input type = "checkbox" name = "thursday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "thursday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "thursday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "friday">FRIDAY</label>
                                <label><input type = "checkbox" name = "friday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "friday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "friday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "saturday">SATURDAY</label>
                                <label><input type = "checkbox" name = "saturday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "saturday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "saturday[]" value = "night">Night</label>
                            </fieldset>

                            <fieldset>
                                <label id = "sunday">SUNDAY</label>
                                <label><input type = "checkbox" name = "sunday[]" value = "morning">Morning</label>
                                <label><input type = "checkbox" name = "sunday[]" value = "afternoon">Afternoon</label>
                                <label><input type = "checkbox" name = "sunday[]" value = "night">Night</label>
                            </fieldset>


                        </div><!-- end of col -->

                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <br>
                                <label>I'd like to work volunteer:</label><br>
                                <select name="season">
                                    <option value="seasonal">Seasonal</option>
                                    <option value="year">Year-Round</option>
                                </select>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Please attach your resume.</label></div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                        <div class="col-md-6 col-md-offset-3"><label class="btn btn-default btn-file"><input name="resumeUpload" type="file" hidden>
                            </label></div>

                </form>

                <div class="col-md-6 col-md-offset-2">
                    <br>
                    <button class="btn btn-sm btn-primary pull-right" name="SubmitPersonProfileForm" type="submit" ><strong>Save and Continue</strong></button>              </div>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>

