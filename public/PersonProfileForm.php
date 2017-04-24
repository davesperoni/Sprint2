<?php include("Classes/Person.php"); ?>
<?php include("Classes/EmergencyContact.php"); ?>
<?php include("Classes/Availability.php"); ?>

<?php
    session_start();


    /**
     * Created by PhpStorm.
     * User: Jenny - added validation - 4/19/2017 - need to fix so that data stays on form after submit
     * David Speroni : switched mysql to mysqli - 3/30/2017
     * Other contributors: Drew
     */

//Declare variables
$PersonFirstName = "";
$PersonMiddleInitial = "";
$PersonLastName = "";
$PersonPhoneNumber = "";
$PersonStreetAddress = "";
$PersonCity = "";
$PersonZipCode = "";
$PersonState = "";
$PersonCounty = "";
$PersonCountry = "";
$PersonDateOfBirth = "";
$PersonDateOfBirthDay = "";
$PersonDateOfBirthMonth = "";
$PersonDateOfBirthYear = "";
$EmergencyFirstName = "";
$EmergencyMiddleInitial = "";
$EmergencyLastName = "";
$EmergencyRelationship = "";
$EmergencyPhoneNumber = "";
$PersonAllergy = "";
$PersonPhysicalLimitation = "";
$PersonRabies = "";
$PersonHavePermit = "";
$PersonPermitType = "";

//Declare error messages;
$personFirstNameErr = "";
$personMidInitialErr = "";
$personLastNameErr = "";
$personDOBErr = "";
$phoneNumberErr = "";
$addressErr = "";
$cityErr = "";
$zipCodeErr = "";
$stateErr = "";
$countyErr = "";
$countryErr = "";
$ICEFirstNameErr = "";
$ICEMidInitialErr = "";
$ICELastNameErr = "";
$ICERelationshipErr = "";
$ICEPhoneNumberErr = "";
$allergiesErr = "";
$physicalLimitErr = "";
$rabiesErr = "";
$vaccineUploadErr = "";
$havePermitErr = "";
$permitCategoryErr = "";
$permitUploadErr = "";
$availabilityErr = "";
$selectSeasonErr = "";
$resumeErr = "";

if(empty($_SESSION['AccountID']))
{
    header("Location: /logout.php"); //logs out any active sessions and takes the user to the login screen
}
else {
    $PersonAccountID = $_SESSION['AccountID'];

    if (isset($_POST['SubmitPersonProfileForm'])) {

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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //VALIDATE EMERGENCY CONTACT INFO
            if (empty($_POST['EmergencyFirstName'])) {
                $ICEFirstNameErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['EmergencyFirstName'])) {
                $ICEFirstNameErr = "Must be 1-20 letters.";
            } else {
                $EmergencyFirstName = test_input($_POST['EmergencyFirstName']);
            }

            if (empty($_POST['EmergencyMiddleInitial'])) {
                $ICEMidInitialErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1}$/", $_POST['EmergencyMiddleInitial'])) {
                $ICEMidInitialErr = "Must be one letter.";
            } else {
                $EmergencyMiddleInitial = test_input($_POST['EmergencyMiddleInitial']);
            }

            if (empty($_POST['EmergencyLastName'])) {
                $ICELastNameErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['EmergencyLastName'])) {
                $ICELastNameErr = "Must be 1-20 letters.";
            } else {
                $EmergencyLastName = test_input($_POST['EmergencyLastName']);
            }

            if (empty($_POST['EmergencyPhoneNumber'])) {
                $ICEPhoneNumberErr = "Required";
            } else {
                $phone = preg_replace('/[^\d]/', '', test_input($_POST['EmergencyPhoneNumber']));
                if (!preg_match('/^\d{10}$/', $phone)) {
                    $ICEPhoneNumberErr = "Phone number must be 10 digits (U.S. format)";
                } else {
                    $EmergencyPhoneNumber = $phone;
                }
            }

            if (empty($_POST['EmergencyRelationship'])) {
                $ICERelationshipErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['EmergencyRelationship'])) {
                $ICERelationshipErr = "Must be 1-20 letters.";
            } else {
                $EmergencyRelationship = test_input($_POST['EmergencyRelationship']);
            }

            //VALIDATE PERSON INFO
            if (empty($_POST['PersonFirstName'])) {
                $personFirstNameErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['PersonFirstName'])) {
                $personFirstNameErr = "Must be 1-20 letters.";
            } else {
                $PersonFirstName = test_input($_POST['PersonFirstName']);
            }

            if (empty($_POST['PersonMiddleInitial'])) {
                $personMidInitialErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1}$/", $_POST['PersonMiddleInitial'])) {
                $personMidInitialErr = "Must be 1 letter.";
            } else {
                $PersonMiddleInitial = test_input($_POST['PersonMiddleInitial']);
            }

            if (empty($_POST['PersonLastName'])) {
                $personLastNameErr = "Required";
            } else if (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['PersonLastName'])) {
                $personLastNameErr = "Must be 1-20 letters.";
            } else {
                $PersonLastName = test_input($_POST['PersonLastName']);
            }

            if (empty($_POST['PersonStreetAddress'])) {
                $addressErr = "Required";
            } else if (!preg_match("/^[0-9a-zA-Z-. ]{1,50}$/", $_POST['PersonStreetAddress'])) {
                $addressErr = "Must be 1-50 letters.";
            } else {
                $PersonStreetAddress = test_input($_POST['PersonStreetAddress']);
            }

            if (empty($_POST['PersonCity'])) {
                $cityErr = "Required";
            } else if (!preg_match("/^[a-zA-Z ]{1,40}$/", $_POST['PersonCity'])) {
                $cityErr = "Must be 1-40 letters.";
            } else {
                $PersonCity = test_input($_POST['PersonCity']);
            }

            if (empty($_POST['PersonCounty'])) {
                $countyErr = "Required";
            } else {
                $PersonCounty = test_input($_POST['PersonCounty']);
            }

            if (empty($_POST['PersonState'])) {
                $stateErr = "Required";
            } else {
                $PersonState = test_input($_POST['PersonState']);
            }

            if (empty($_POST['PersonCountry'])) {
                $countryErr = "Required";
            } else {
                $PersonCountry = test_input($_POST['PersonCountry']);
            }

            if (empty($_POST['PersonZipCode'])) {
                $zipCodeErr = "Required";
            } else if (preg_match("/^([0-9]{5})(-[0-9]{4})?$/i", test_input($_POST['PersonZipCode']))) {
                $PersonZipCode = test_input($_POST['PersonZipCode']);
            } else {
                $zipCodeErr = "Invalid zip code format. Please enter a US-format zip code.";
            }

            if (empty($_POST['PersonPhoneNumber'])) {
                $phoneNumberErr = "Required";
            } else {
                $phone = preg_replace('/[^\d]/', '', test_input($_POST['PersonPhoneNumber']));
                if (!preg_match('/^\d{10}$/', $phone)) {
                    $phoneNumberErr = "Phone number must be 10 digits (U.S. format)";
                } else {
                    $PersonPhoneNumber = $phone;
                }
            }

            if (empty($_POST['PersonDOBYear'])) {
                $personDOBErr = "Required";
            } else if (empty($_POST['PersonDOBMonth'])) {
                $personDOBErr = "Required";
            } else if (empty($_POST['PersonDOBDay'])) {
                $personDOBErr = "Required";
            } else if ($_POST['PersonDOBYear'] === " - Year - " ^ $_POST['PersonDOBMonth'] === " - Month - " ^ $_POST['PersonDOBDay'] === " - Day - ") {
                $personDOBErr = "Required";
            } else {
                $PersonDateOfBirthYear = test_input($_POST['PersonDOBYear']);
                $PersonDateOfBirthMonth = test_input($_POST['PersonDOBMonth']);
                $PersonDateOfBirthDay = test_input($_POST['PersonDOBDay']);

                if (!empty($PersonDateOfBirthYear && $PersonDateOfBirthMonth && $PersonDateOfBirthYear)) {
                    $PersonDateOfBirth = $PersonDateOfBirthYear . '-' . $PersonDateOfBirthMonth . '-' . $PersonDateOfBirthDay;
                }
            }

            if (empty($_POST['PersonAllergy'])) {
                $allergiesErr = "Required";
            } else if (!preg_match('/^[a-zA-Z0-9,. ]{0,255}$/', $_POST['PersonAllergy'])) {
                $allergiesErr = "Maximum 255 characters.";
            } else {
                $PersonAllergy = test_input($_POST['PersonAllergy']);
            }

            if (empty($_POST['PersonPhysical'])) {
                $physicalLimitErr = "Required";
            } else if (!preg_match('/^[a-zA-Z0-9,. ]{0,255}$/', $_POST['PersonPhysical'])) {
                $physicalLimitErr = "Maximum 255 characters.";
            } else {
                $PersonPhysicalLimitation = test_input($_POST['PersonPhysical']);
            }

            if (empty($_POST['PersonHavePermit'])) {
                $havePermitErr = "Required";
            } else {
                $PersonHavePermit = test_input($_POST['PersonHavePermit']);
            }

            if (empty($_POST['PersonPermitType'])) {
                $permitCategoryErr = "Required";
            } else {
                $PersonPermitType = test_input($_POST['PersonPermitType']);
            }

            if (empty($_POST['PersonRabies'])) {
                $rabiesErr = "Required";
            } else {
                $PersonRabies = test_input($_POST['PersonRabies']);
            }

            //Check if all required fields have been assigned values
            if (!empty($EmergencyFirstName && $EmergencyMiddleInitial && $EmergencyLastName && $EmergencyPhoneNumber && $EmergencyRelationship && $PersonFirstName && $PersonMiddleInitial && $PersonLastName && $PersonStreetAddress && $PersonCity && $PersonCounty && $PersonState && $PersonCountry && $PersonZipCode && $PersonPhoneNumber && $PersonDateOfBirth && $PersonAllergy && $PersonPhysicalLimitation && $PersonHavePermit && $PersonPermitType && $PersonRabies)) {
                //INSERT EMERGENCY CONTACT INFO
                $newEmergencyContact = new EmergencyContact($EmergencyFirstName, $EmergencyMiddleInitial, $EmergencyLastName, $EmergencyPhoneNumber, $EmergencyRelationship);

                $EmergencyFirstName = $newEmergencyContact->getEmergencyFirstName();
                $EmergencyMiddleInitial = $newEmergencyContact->getEmergencyMiddleInitial();
                $EmergencyLastName = $newEmergencyContact->getEmergencyLastName();
                $EmergencyPhoneNumber = $newEmergencyContact->getEmergencyPhoneNumber();
                $EmergencyRelationship = $newEmergencyContact->getEmergencyRelationship();
                $EmergencyLastUpdatedBy = $newEmergencyContact->getEmergencyLastUpdatedBy();
                $EmergencyLastUpdated = $newEmergencyContact->getEmergencyLastUpdated();

                $sqlEmergencyContact = "INSERT INTO EmergencyContact (FirstName, MiddleInitial, LastName, PhoneNumber, Relationship, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
                $stmt = mysqli_prepare($conn, $sqlEmergencyContact);
                $stmt->bind_param("ssssss", $EmergencyFirstName, $EmergencyMiddleInitial, $EmergencyLastName, $EmergencyPhoneNumber, $EmergencyRelationship, $EmergencyLastUpdatedBy);

                if ($stmt) {
                    $stmt->execute();
                }
                //echo "Emergency Contact added to database!";

                $EmergencyContactID = $conn->insert_id;
                //echo "New record created successfully. Last inserted ID is: " . $EmergencyContactID;


                //INSERT PERSON INFO
                //$PersonAccountID = $_SESSION['AccountID'];

                if (!empty($PersonAccountID)) {
                    $newPerson = new Person($EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName, $PersonStreetAddress, $PersonCity, $PersonCounty, $PersonState, $PersonCountry, $PersonZipCode, $PersonPhoneNumber, $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies);

                    $EmergencyContactID = $newPerson->getEmergencyContactID();
                    $PersonAccountID = $newPerson->getPersonAccountID();
                    $PersonFirstName = $newPerson->getPersonFirstName();
                    $PersonMiddleInitial = $newPerson->getPersonMiddleInitial();
                    $PersonLastName = $newPerson->getPersonLastName();
                    $PersonStreetAddress = $newPerson->getPersonStreetAddress();
                    $PersonCity = $newPerson->getPersonCity();
                    $PersonCounty = $newPerson->getPersonCounty();
                    $PersonState = $newPerson->getPersonState();
                    $PersonCountry = $newPerson->getPersonCountry();
                    $PersonZipCode = $newPerson->getPersonZipCode();
                    $PersonPhoneNumber = $newPerson->getPersonPhoneNumber();
                    $PersonDateOfBirth = $newPerson->getPersonDateOfBirth();
                    $PersonAllergy = $newPerson->getPersonAllergy();
                    $PersonPhysicalLimitation = $newPerson->getPersonPhysicalLimitation();
                    $PersonHavePermit = $newPerson->getPersonHavePermit();
                    $PersonPermitType = $newPerson->getPersonPermitType();
                    $PersonRabies = $newPerson->getPersonRabiesVaccine();
                    $PersonLastUpdatedBy = $newPerson->getPersonLastUpdatedBy();
                    $PersonLastUpdated = $newPerson->getPersonLastUpdated();

                    $sqlPerson = "INSERT INTO Person (EmergencyContactID, AccountID, FirstName, MiddleInitial, LastName, StreetAddress, City, County, State, Country, ZipCode, PhoneNumber, DateOfBirth, Allergy, PhysicalLimitation, HavePermit, PermitType, RabiesVaccine, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ? , ?, ?, ? , ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
                    $stmt = mysqli_prepare($conn, $sqlPerson);
                    $stmt->bind_param("iissssssssissssssss", $EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName,
                        $PersonStreetAddress, $PersonCity, $PersonCounty, $PersonState, $PersonCountry, $PersonZipCode, $PersonPhoneNumber,
                        $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies,
                        $PersonLastUpdatedBy);
                }

                if ($stmt) {
                    $stmt->execute();
                    $PersonID = $conn->insert_id;
                    //echo "Person added! Last ID added" . $PersonID;
                    //var_dump($stmt);
                } else {
                    //echo "Person not added";
                }

                if (!empty($PersonID)) {
                    //AVAILABILITY INFO
                    if (!empty($_POST['monday'])) {
                        foreach ($_POST['monday'] as $monday) {

                            $newShift = new Availability(2, $PersonID, $monday);
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
                    if (!empty($_POST['tuesday'])) {
                        foreach ($_POST['tuesday'] as $tuesday) {

                            $newShift = new Availability(3, $PersonID, $tuesday);
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
                    if (!empty($_POST['wednesday'])) {
                        foreach ($_POST['wednesday'] as $wednesday) {

                            $newShift = new Availability(4, $PersonID, $wednesday);
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
                    if (!empty($_POST['thursday'])) {
                        foreach ($_POST['thursday'] as $thursday) {

                            $newShift = new Availability(5, $PersonID, $thursday);
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
                    if (!empty($_POST['friday'])) {
                        foreach ($_POST['friday'] as $friday) {
                            $DayID = 6;

                            $newShift = new Availability(6, $PersonID, $friday);
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
                    if (!empty($_POST['saturday'])) {
                        foreach ($_POST['saturday'] as $saturday) {

                            $newShift = new Availability(7, $PersonID, $saturday);

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
                    if (!empty($_POST['sunday'])) {
                        foreach ($_POST['sunday'] as $sunday) {

                            $newShift = new Availability(1, $PersonID, $sunday);
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


                    // FOR RESUME
                    $fileName = $_FILES['resumeUpload']['name'];
                    $tmpName = $_FILES['resumeUpload']['tmp_name'];
                    $fileSize = $_FILES['resumeUpload']['size'];
                    $fileType = $_FILES['resumeUpload']['type'];
					$resumeSpecification = 'Resume';

                    if (!empty($fileName) && !empty($tmpName) && !empty($fileSize) && !empty($fileType)) {
                        $fp = fopen($tmpName, 'r');
                        $content = fread($fp, filesize($tmpName));
                        $content = addslashes($content);
                        fclose($fp);

                        if (!empty($PersonID && $fileName && $fileSize && $fileType && $content)) {
                            $sqlInsertResume = "INSERT INTO Upload (PersonID, name, specification, size, type, content ) " .
                                "VALUES ('$PersonID', '$fileName', '$resumeSpecification', '$fileSize', '$fileType', '$content')";

                            $stmt = mysqli_prepare($conn, $sqlInsertResume);

                            if ($stmt) {

                                $stmt->execute();
                            }
                        }
                    }

                    // FOR VACCINE
                    $fileName = $_FILES['vaccineUpload']['name'];
                    $tmpName = $_FILES['vaccineUpload']['tmp_name'];
                    $fileSize = $_FILES['vaccineUpload']['size'];
                    $fileType = $_FILES['vaccineUpload']['type'];
					$vaccineSpecification = 'Vaccine';

                    if (!empty($fileName) && !empty($tmpName) && !empty($fileSize) && !empty($fileType)) {
                        $fp = fopen($tmpName, 'r');
                        $content = fread($fp, filesize($tmpName));
                        $content = addslashes($content);
                        fclose($fp);

                        if (!empty($PersonID && $fileName && $fileSize && $fileType && $content)) {
                            $sqlInsertVaccine = "INSERT INTO Upload (PersonID, name, specification, size, type, content, LastUpdatedBy, LastUpdated) " .
                                "VALUES ('$PersonID', '$fileName', '$vaccineSpecification', '$fileSize', '$fileType', '$content', 'System', CURRENT_TIMESTAMP)";

                            $stmt = mysqli_prepare($conn, $sqlInsertVaccine);

                            if ($stmt) {

                                $stmt->execute();
                            }
                        }
                    }

                    // FOR PERMIT
                    $fileName = $_FILES['permitUpload']['name'];
                    $tmpName = $_FILES['permitUpload']['tmp_name'];
                    $fileSize = $_FILES['permitUpload']['size'];
                    $fileType = $_FILES['permitUpload']['type'];
					$permitSpecification = 'Permit';

                    if (!empty($fileName) && !empty($tmpName) && !empty($fileSize) && !empty($fileType)) {
                        $fp = fopen($tmpName, 'r');
                        $content = fread($fp, filesize($tmpName));
                        $content = addslashes($content);
                        fclose($fp);

                        if (!empty($PersonID && $fileName && $fileSize && $fileType && $content)) {
                            $sqlInsertPermit = "INSERT INTO Upload (PersonID, name, specification, size, type, content, LastUpdatedBy, LastUpdated) " .
                                "VALUES ('$PersonID', '$fileName', '$permitSpecification', '$fileSize', '$fileType', '$content', 'System', CURRENT_TIMESTAMP)";

                            $stmt = mysqli_prepare($conn, $sqlInsertPermit);

                            if ($stmt) {

                                $stmt->execute();
                            }
                        }
                    }  
					//Bring the user to the application form page once all else is complete
                    header("Location: /PersonApplicationForm.php");
					exit;
                }		
            }
        }
    }
}
?>

<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
            <div class="smallerheader"><h1>Create A Profile</h1>
                <p>Thank you for your interest in The Wildlife Center of Virginia. Please fill out the form below to create an account.</p></div>

            <div class="col-sm-12">
                <form role="form" name="PersonProfileForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label><span class="error"> * <?php echo $personFirstNameErr;?></span><input type="name" name="PersonFirstName" placeholder="Enter first name" class="form-control" required value="<?php echo $PersonFirstName;?>"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label><span class="error"> * <?php echo $personMidInitialErr;?></span>  <input type="name" name="PersonMiddleInitial" placeholder="Enter middle initial" class="form-control" required value="<?php echo $PersonMiddleInitial;?>"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label><span class="error"> * <?php echo $personLastNameErr;?></span>  <input type="name" name="PersonLastName" placeholder="Enter last name" class="form-control" required value="<?php echo $PersonLastName;?>"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>Birthday</label> <span class="error"> * <?php echo $personDOBErr;?></span>
                            <select name="PersonDOBMonth" required <?php echo $PersonDateOfBirthMonth;?>>
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

                            <select name="PersonDOBDay" required <?php echo $PersonDateOfBirthDay?>>
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

                            <select name="PersonDOBYear" required <?php echo $PersonDateOfBirthYear;?>>
                                <option> - Year - </option>
                                <?php
                                for($year=date("Y"); $year>(date("Y")-100); $year--) {
                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                }
                                ?>
                            </select>

                            <!-- OLD YEAR SELECT
                            <select name="PersonDOBYear" required <?php //echo $PersonDateOfBirthYear;?>>
                                <option> - Year - </option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
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
                                <option value="1947">1946</option>
                                <option value="1947">1945</option>
                                <option value="1947">1944</option>
                                <option value="1947">1943</option>
                                <option value="1947">1942</option>
                                <option value="1947">1941</option>
                                <option value="1947">1940</option>

                            </select> -->
                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Phone</label><span class="error"> * <?php echo $phoneNumberErr;?></span>  <input type="phone" name="PersonPhoneNumber" placeholder="Enter phone number" class="form-control" required value="<?php echo $PersonPhoneNumber;?>"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Street Address</label><span class="error"> * <?php echo $addressErr;?></span>  <input type="address" name="PersonStreetAddress" placeholder="Enter street address" class="form-control" required value="<?php echo $PersonStreetAddress;?>"></div></div>

                    <div class="col-md-3 col-md-offset-3"><div class="form-group"><label>City</label><span class="error"> * <?php echo $cityErr;?></span>  <input type="city" placeholder="Enter city" name="PersonCity" class="form-control" required value="<?php echo $PersonCity;?>"></div></div>

                    <div class="col-md-3"><div class="form-group"><label>Zip Code</label><span class="error"> * <?php echo $zipCodeErr;?></span>  <input type="zip" name="PersonZipCode" placeholder="Enter zip code" class="form-control" required value="<?php echo $PersonZipCode;?>"></div></div>

                    <div class="col-md-3 col-md-offset-3"><div class="form-group">
                            <label>State</label><span class="error"> * <?php echo $stateErr;?></span><br/>
                            <select name="PersonState" required value="<?php echo $PersonState;?>">
                                <?php
            
								$server="127.0.0.1";
								$username="homestead";
								$password="secret";
                                $database="wildlifeDB";

                                $link = mysqli_connect($server, $username, $password, $database);

                                if (!$link) {
                                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                    exit;
                                }

								$cdquery="SELECT StateName FROM State ORDER BY isDefault DESC, StateName";
								$cdresult=mysqli_query($link, $cdquery);;
								
								while ($cdrow=mysqli_fetch_array($cdresult)) {
								$PersonState=$cdrow["StateName"];
									echo "<option>
										$PersonState
									</option>";
								
								}
									
								?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3"><div class="form-group">
                            <label>County (Virginia Only)</label><span class="error"> * <?php echo $countyErr;?></span><br/>
                            <select name="PersonCounty">

                            <?php

                            $server="127.0.0.1";
							$username="homestead";
							$password="secret";
							$database="wildlifeDB";

							$link = mysqli_connect($server, $username, $password, $database);

                            if (!$link) {
                                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                exit;
                            }

                            $cdquery="SELECT CountyName FROM County";
                            $cdresult=mysqli_query($link, $cdquery);;

                            while ($cdrow=mysqli_fetch_array($cdresult)) {
                                $PersonCounty=$cdrow["CountyName"];
                                echo "<option>
										$PersonCounty
									</option>";

                            }

                            ?>

                            </select>
                        </div></div>


                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>Country</label><span class="error"> * <?php echo $countryErr;?></span> <br/>
                            <select name="PersonCountry">
                                <?php

                                $server="127.0.0.1";
								$username="homestead";
								$password="secret";
                                $database="wildlifeDB";

                                $link = mysqli_connect($server, $username, $password, $database);

                                if (!$link) {
                                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                    exit;
                                }

                                $cdquery="SELECT CountryName FROM Country ORDER BY isDefault DESC, CountryName";
                                $cdresult=mysqli_query($link, $cdquery);;

                                while ($cdrow=mysqli_fetch_array($cdresult)) {
                                    $PersonCountry=$cdrow["CountryName"];
                                    echo "<option>
										$PersonCountry
									</option>";
                                }
                                ?>

                            </select>
                        </div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><h4>Emergency Contact Information</h4></div></div>

                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label><span class="error"> * <?php echo $ICEFirstNameErr;?></span>  <input type="name" name="EmergencyFirstName" placeholder="Enter first name" class="form-control" required value="<?php echo $EmergencyFirstName;?>"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label><span class="error"> * <?php echo $ICEMidInitialErr;?></span>  <input type="name" name="EmergencyMiddleInitial" placeholder="Enter middle initial" class="form-control" required value="<?php echo $EmergencyMiddleInitial;?>"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label><span class="error"> * <?php echo $ICELastNameErr;?></span>  <input type="name" name="EmergencyLastName" placeholder="Enter last name" class="form-control" required value="<?php echo $EmergencyLastName;?>"></div></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Relationship to Contact</label><span class="error"> * <?php echo $ICERelationshipErr;?></span> <input type="relationship" name="EmergencyRelationship" placeholder="Enter relationship to contact" class="form-control" required value="<?php echo $EmergencyRelationship;?>"></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Emergency Contact Phone Number</label><span class="error"> * <?php echo $ICEPhoneNumberErr;?></span>  <input type="phone" name="EmergencyPhoneNumber" placeholder="Enter contact's number" class="form-control" required value="<?php echo $EmergencyPhoneNumber;?>"></div></div>


                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Allergies</label><span class="error"> * <?php echo $allergiesErr;?></span> <textarea rows="4" type="allergies" name="PersonAllergy" placeholder="Enter allergies" class="form-control" <?php echo $PersonAllergy;?> required ></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Physical Limitations</label><span class="error"> * <?php echo $physicalLimitErr;?></span> <textarea rows="4" type="limits" name="PersonPhysical" placeholder="Enter physical limitations" class="form-control" <?php echo $PersonPhysicalLimitation;?>required ></textarea></div></div>

                    <div class="form-group"><div class="col-md-6 col-md-offset-3"><label>I have my rabies vaccine: </label><span class="error"> * <?php echo $rabiesErr;?></span><form action="/action_page.php" method="get"></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <input type="radio" name="PersonRabies" <?php if (isset($PersonRabies) && $PersonRabies=="Yes") echo "checked";?>value="Yes">Yes<br/>
                                <input type="radio" name="PersonRabies" <?php if (isset($PersonRabies) && $PersonRabies=="No") echo "checked";?>value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please upload a copy of your paperwork.</label><span class="error"> * <?php echo $vaccineUploadErr;?></span></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><label class="btn btn-default btn-file"><input name="vaccineUpload" type="file" hidden>
                                </label></div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Do you have a valid permit to rehabilitate wildlife in the state of Virginia?</label><span class="error"> * <?php echo $havePermitErr;?></span></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <input type="radio" name="PersonHavePermit" value="Yes">Yes<br>
                                <input type="radio" name="PersonHavePermit" value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please select which kind:</label><span class="error"> * <?php echo $permitCategoryErr;?></span></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <select name="PersonPermitType">
                                    <option value="cat0"></option>
                                    <option value="cat1">Cat 1</option>
                                    <option value="cat2">Cat 2</option>
                                    <option value="cat3">Cat 3</option>
                                    <option value="cat4">Cat 4</option>
                                </select>
                            </div></div>
                        <div class="col-md-6 col-md-offset-3"><label>If yes, please upload a copy of your paperwork.</label><span class="error"> * <?php echo $permitUploadErr;?></span></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><label class="btn btn-default btn-file"><input name="permitUpload" type="file" hidden>
                                </label></div></div>

                        <div class="col-md-6 col-md-offset-3"><label>I'm available:</label><span class="error"> * <?php echo $availabilityErr;?></span></div>

                        <div class="col-md-6 col-md-offset-3" name="PersonAvailability">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="form_table" id = "sunday">SUNDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="sunday[]" value="morning"> Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="sunday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="sunday[]" value="night"> Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id = "monday">MONDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="monday[]" value="morning"> Morning</td>
                                    <td  class="form_table"class="avail_space"><input type="checkbox" name="monday[]" value="afternoon"> Afternoon</td>
                                    <td  class="form_table" class="avail_space"><input type="checkbox" name="monday[]" value="night" > Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id = "tuesday">TUESDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="tuesday[]" value="morning"> Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="tuesday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="tuesday[]" value="night"> Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id="wednesday" >WEDNESDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="wednesday[]" value="morning"> Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="wednesday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="wednesday[]" value="night"> Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id="thursday">THURSDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="thursday[]" value="morning"> Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="thursday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="thursday[]" value="night"> Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id="friday">FRIDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="friday[]" value="morning"> Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="friday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="friday[]" value="night"> Night</td>
                                </tr>
                                <tr>
                                    <td class="form_table" id="saturday" >SATURDAY</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="saturday[]" value="morning" > Morning</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="saturday[]" value="afternoon"> Afternoon</td>
                                    <td class="form_table" class="avail_space"><input type="checkbox" name="saturday[]" value="night"> Night</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <br>
                                <label>I'd like to volunteer:</label><span class="error"> * <?php echo $selectSeasonErr;?></span><br>
                                <select name="season">
                                    <option value="seasonal">Seasonal</option>
                                    <option value="year">Year-Round</option>
                                </select>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Please attach your resume.</label><span class="error"> * <?php echo $resumeErr;?></span></div>
                        <div class="col-md-6 col-md-offset-3"><label class="btn btn-default btn-file"> <input name="resumeUpload" type="file" hidden required>
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


