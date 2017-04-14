<?php include("Classes/Person.php"); ?>
<?php include("Classes/EmergencyContact.php"); ?>
<?php include("Classes/Availability.php"); ?>

<?php
    session_start();


    /**
     * Created by PhpStorm.
     * User: Drew
     * David Speroni : sqitched mysql to mysqli
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
        $PersonCounty = $_POST['PersonCounty'];
        $PersonState = $_POST['PersonState'];
        $PersonCountry = $_POST['PersonCountry'];
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
    //$PersonNotes = $newPerson->getPersonNotes();
        $PersonLastUpdatedBy = $newPerson->getPersonLastUpdatedBy();
        $PersonLastUpdated = $newPerson->getPersonLastUpdated();


        $sqlPerson = "INSERT INTO Person (EmergencyContactID, AccountID, FirstName, MiddleInitial, LastName, StreetAddress, City, County, State, Country, ZipCode, PhoneNumber, DateOfBirth, Allergy, PhysicalLimitation, HavePermit, PermitType, RabiesVaccine, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ? , ?, ?, ? , ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = mysqli_prepare($conn, $sqlPerson);
        $stmt->bind_param("iissssssssissssssss", $EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName,
            $PersonStreetAddress, $PersonCity, $PersonCounty, $_POST['PersonState'], $_POST['PersonCountry'], $PersonZipCode, $PersonPhoneNumber,
            $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies,
            $PersonLastUpdatedBy);

        if($stmt) {

            $stmt->execute();

            $PersonID = $conn->insert_id;

            echo "Person added! Last ID added" . $PersonID;
            //var_dump($stmt);

        }
        else
        {
            echo "Person not added";
        }

        if(!empty($_POST['monday']))
        {
            foreach($_POST['monday'] as $monday) {

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
        if(!empty($_POST['tuesday']))
        {
            foreach($_POST['tuesday'] as $tuesday) {

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
        if(!empty($_POST['wednesday']))
        {
            foreach($_POST['wednesday'] as $wednesday) {

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
        if(!empty($_POST['thursday']))
        {
            foreach($_POST['thursday'] as $thursday) {

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
        if(!empty($_POST['friday']))
        {
            foreach($_POST['friday'] as $friday) {
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
        if(!empty($_POST['saturday']))
        {
            foreach($_POST['saturday'] as $saturday) {

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
        if(!empty($_POST['sunday']))
        {
            foreach($_POST['sunday'] as $sunday) {

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

        // FOR PERMIT
        $fileName = $_FILES['permitUpload']['name'];
        $tmpName  = $_FILES['permitUpload']['tmp_name'];
        $fileSize = $_FILES['permitUpload']['size'];
        $fileType = $_FILES['permitUpload']['type'];

        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);

        $sqlInsertPermit = "INSERT INTO permitUpload (PersonID, name, size, type, content, LastUpdatedBy, LastUpdated) ".
            "VALUES ('$PersonID', '$fileName', '$fileSize', '$fileType', '$content', 'system', CURRENT_TIMESTAMP)";

        $stmt = mysqli_prepare($conn, $sqlInsertPermit);

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
            <div class="smallerheader"><h1>Create A Profile</h1>
                <p>Thank you for your interest in The Wildlife Center of Virginia. Please fill out the form below to create an account.</p></div>

            <div class="col-sm-12">
                <form role="form" name="PersonProfileForm" method="post" action="PersonProfileForm.php" enctype="multipart/form-data">
                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" name="PersonFirstName" placeholder="Enter first name" class="form-control" required></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" name="PersonMiddleInitial" placeholder="Enter middle initial" class="form-control" required></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" name="PersonLastName" placeholder="Enter last name" class="form-control" required></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <label>Birthday</label>
                            <select name="PersonDOBMonth" required>
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

                            <select name="PersonDOBDay" required>
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

                            <select name="PersonDOBYear" required>
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

                            </select>


                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Phone</label> <input type="phone" name="PersonPhoneNumber" placeholder="Enter phone number" class="form-control" required></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Street Address</label> <input type="address" name="PersonStreetAddress" placeholder="Enter street address" class="form-control" required></div></div>

                    <div class="col-md-3 col-md-offset-3"><div class="form-group"><label>City</label> <input type="city" placeholder="Enter city" name="PersonCity" class="form-control" required></div></div>

                    <div class="col-md-3"><div class="form-group"><label>Zip Code</label> <input type="zip" name="PersonZipCode" placeholder="Enter zip code" class="form-control" required></div></div>


                    <div class="col-md-3 col-md-offset-3"><div class="form-group">
                            <label>State</label><br/>
                            <select name="PersonState" required>
                                <?php
            
								$mysqlserver="127.0.0.1";
								$mysqlusername="homestead";
								$mysqlpassword="secret";
                                $mysqlDB="wildlifeDB";

                                $link = mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword, $mysqlDB);

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
                        </div></div>

                    <div class="col-md-3"><div class="form-group">
                            <label>County (Virginia Only)</label><br/>
                            <select name="PersonCounty">

                            <?php

                            $mysqlserver="127.0.0.1";
                            $mysqlusername="homestead";
                            $mysqlpassword="secret";
                            $mysqlDB="wildlifeDB";

                            $link = mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword, $mysqlDB);

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
                            <label>Country</label><br/>
                            <select name="PersonCountry">
                                <?php

                                $mysqlserver="127.0.0.1";
                                $mysqlusername="homestead";
                                $mysqlpassword="secret";
                                $mysqlDB="wildlifeDB";

                                $link = mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword, $mysqlDB);

                                if (!$link) {
                                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                    exit;
                                }

                                $cdquery="SELECT CountryName FROM Country";
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

                    <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" name="EmergencyFirstName" placeholder="Enter first name" class="form-control" required></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" name="EmergencyMiddleInitial" placeholder="Enter middle initial" class="form-control" required></div></div>
                    <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" name="EmergencyLastName" placeholder="Enter last name" class="form-control" required></div></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Relationship to Contact</label> <input type="relationship" name="EmergencyRelationship" placeholder="Enter relationship to contact" class="form-control" required></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Emergency Contact Phone Number</label> <input type="phone" name="EmergencyPhoneNumber" placeholder="Enter contact's number" class="form-control" required></div></div>


                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Allergies</label> <textarea rows="4" type="allergies" name="PersonAllergy" placeholder="Enter allergies" class="form-control" required></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Physical Limitations</label> <textarea rows="4" type="limits" name="PersonPhysical" placeholder="Enter physical limitations" class="form-control" required></textarea></div></div>

                    <div class="form-group"><div class="col-md-6 col-md-offset-3"><label>I have my rabies vaccine: </label><form action="/action_page.php" method="get"></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><input type="radio" name="PersonRabies" value="Yes">Yes<br/>
                                <input type="radio" name="PersonRabies" value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please upload a copy of your paperwork.</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><label class="btn btn-default btn-file"><input name="vaccineUpload" type="file" hidden>
                                </label></div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Do you have a valid permit to rehabilitate wildlife in the state of Virginia?</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <input type="radio" name="PersonHavePermit" value="Yes">Yes<br>
                                <input type="radio" name="PersonHavePermit" value="No">No<br>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>If yes, please select which kind:</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <select name="PersonPermitType">
                                    <option value="cat0"></option>
                                    <option value="cat1">Cat 1</option>
                                    <option value="cat2">Cat 2</option>
                                    <option value="cat3">Cat 3</option>
                                    <option value="cat4">Cat 4</option>
                                </select>
                            </div></div>
                        <div class="col-md-6 col-md-offset-3"><label>If yes, please upload a copy of your paperwork.</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group"><label class="btn btn-default btn-file"><input name="permitUpload" type="file" hidden>
                                </label></div></div>


                        <div class="col-md-6 col-md-offset-3"><label>I'm available:</label></div>

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
                                <label>I'd like to volunteer:</label><br>
                                <select name="season">
                                    <option value="seasonal">Seasonal</option>
                                    <option value="year">Year-Round</option>
                                </select>
                            </div></div>

                        <div class="col-md-6 col-md-offset-3"><label>Please attach your resume.</label></div>
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

