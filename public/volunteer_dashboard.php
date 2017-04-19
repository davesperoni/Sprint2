<?php
session_start();
include("Classes/Shift.php");
include("Classes/Mileage.php");

require 'databasePDO.php';
require 'database.php';
/**
 * Created by PhpStorm.
 * User: Shanika Wije
 * Date: 4/02/2017
 * Time: 3:30 PM
 */

 
date_default_timezone_set("America/New_York");
$Date = date('F j, Y');
$currentTime = date('h:i:s');
$currentTime = date("h:i:s", strtotime($currentTime));

$records = $connPDO->prepare('select FirstName, MiddleInitial, LastName FROM Person where AccountID = :AccountID');
$records->bindParam(':AccountID', $_SESSION['AccountID']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0){
    $personName = $results;
}

$VolunteerName = ucfirst($personName['FirstName']) . " " . ucfirst($personName['MiddleInitial']) . " " . ucfirst($personName['LastName']);
$VolunteerFirstName = $personName['FirstName'];


// Select departments that a volunteer is in
$AccountID = $_SESSION['AccountID'];

$sqlVolunteerDepartments = "select distinct Department.DepartmentName FROM Department
JOIN VolunteerDepartment ON Department.DepartmentID = VolunteerDepartment.DepartmentID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID
JOIN Person ON Volunteer.PersonID = Person.PersonID
JOIN Account ON Person.AccountID = Account.AccountID
WHERE Account.AccountID = $AccountID;";

$resultsDepartments = mysqli_query($conn, $sqlVolunteerDepartments);
?>

<?php

if (isset($_POST['submitCheckIn'])) {
    $nullEnd = null;
    $sql = $connPDO->prepare('Select Volunteer.VolunteerID from Volunteer JOIN Person ON Person.PersonID = Volunteer.PersonID JOIN Account ON Person.AccountID = Account.AccountID where Account.AccountID = :AccountID');
    $sql->bindParam(':AccountID', $_SESSION['AccountID']);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    $startTimeMilitaryTime = date("G:i", strtotime($currentTime));
    $volunteerID= $result['VolunteerID'];
    $startTime = $startTimeMilitaryTime;
    $shiftDate = "CURRENT_TIMESTAMP";
    $endTime = "0";
    $shiftHours = 0;
    $shiftDepartment = $_POST['Department'];
    if ($shiftDepartment === "Animal Care")
    {
        $shiftDepartment = 1;
    }
    else if ($shiftDepartment === "Outreach")
    {
        $shiftDepartment = 2;
    }
    else if($shiftDepartment === "Transport")
    {
        $shiftDepartment = 3;
    }
    else if ($shiftDepartment === "Treatment")
    {
        $shiftDepartment = 4;
    }


    //var_dump($shiftDepartment);

    $newShift = new Shift($volunteerID, $shiftDepartment, $shiftDate, $startTime, $endTime, $shiftHours);

    $volunteerID = $newShift->getShiftVolunteerID();
    $shiftDepartment = $newShift->getShiftDepartmentID();
    $shiftDate = $newShift->getShiftDate();
    $startTime = $newShift->getShiftStartTime();
    $endTime = $newShift->getShiftEndTime();
    $shiftHours = $newShift->getShiftHours();
    $shiftLastUpdatedBy = $newShift->getShiftLastUpdatedBy();
    $shiftLastUpdated = $newShift->getShiftLastUpdated();

    $sqlInsertShift = "INSERT INTO Shift (VolunteerID, DepartmentID, ShiftDate, StartTime, EndTime, ShiftHours, LastUpdatedBy, LastUpdated)
    VALUES($volunteerID, $shiftDepartment, $shiftDate, '$startTime', $endTime, $shiftHours, '$shiftLastUpdatedBy', $shiftLastUpdated)";

    // var_dump($sqlInsertShift);
    $stmt = mysqli_query($conn, $sqlInsertShift);

if ($shiftDepartment === 3) {

    $departmentID = 3;
    $tripDate = $shiftDate;
    $tripMiles = $_POST['numMiles'];
    $pickUpStreet = $_POST['pickUpStreet'];
    $pickUpCity = $_POST['pickUpCity'];
    $pickUpState = $_POST['pickUpState'];
    $pickUpCounty = $_POST['pickUpCounty'];
    $pickUpZipCode = $_POST['pickUpZipCode'];
    $animalTransported = $_POST['animalTransported'];

    $newMileage = new Mileage($departmentID, $volunteerID, $tripDate, $tripMiles, $pickUpStreet, $pickUpCity, $pickUpState, $pickUpCounty, $pickUpZipCode, $animalTransported);

    $departmentID = $newMileage->getMileageDepartmentID();
    $volunteerID = $newMileage->getMileageVolunteerID();
    $tripDate = $newMileage->getMileageTripDate();
    $tripMiles = $newMileage->getMileageTripMiles();
    $pickUpStreet = $newMileage->getMileageTripStreet();
    $pickUpCity = $newMileage->getMileageTripCity();
    $pickUpState = $newMileage->getMileageTripState();
    $pickUpCounty = $newMileage->getMileageTripCounty();
    $pickUpZipCode = $newMileage->getMileageTripZipCode();
    $animalTransported = $newMileage->getMileageAnimalTransported();
    $tripLastUpdatedBy = $newMileage->getMileageLastUpdatedBy();

    $sqlInsertMileage = "INSERT INTO Mileage (DepartmentID, VolunteerID, TripDate, TripMiles, PickUpStreet, PickUpCity, PickUpState, PickUpCountyName, PickUpZipCode, AnimalTransported, LastUpdatedBy, LastUpdated) VALUES ($departmentID, $volunteerID, $tripDate, $tripMiles, '$pickUpStreet', '$pickUpCity', '$pickUpState', '$pickUpCounty', '$pickUpZipCode', '$animalTransported', '$tripLastUpdatedBy', CURRENT_TIMESTAMP)";

    //  var_dump($sqlInsertMileage);

    $stmt = mysqli_query($conn, $sqlInsertMileage);
}

//    $sql = $connPDO->prepare("Select s.ShiftID, s.VolunteerID FROM Shift s
//    JOIN Volunteer ON Volunteer.VolunteerID = s.VolunteerID JOIN Person
//    ON Person.PersonID = Volunteer.PersonID JOIN Account
//    ON Account.AccountID = Person.AccountID
//    WHERE Account.AccountID = :AccountID AND s.CheckedIn = 'n'");


    $sql = $connPDO->prepare("Select s.ShiftID, s.VolunteerID FROM Shift s
    JOIN Volunteer ON Volunteer.VolunteerID = s.VolunteerID JOIN Person
    ON Person.PersonID = Volunteer.PersonID JOIN Account
    ON Account.AccountID = Person.AccountID
    WHERE Account.AccountID = :AccountID AND CheckedIn = 'n' AND EndTime = 0");

    $sql->bindParam(':AccountID', $_SESSION['AccountID']);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    $shiftID= $result['ShiftID'];

    //$sqlUpdateCheck = "UPDATE Shift SET CheckedIn = 'y' WHERE VolunteerID = $volunteerID";
    $sqlUpdateCheck = "UPDATE Shift SET CheckedIn = 'y' WHERE ShiftID = $shiftID";

    $stmt = mysqli_query($conn, $sqlUpdateCheck);

    //var_dump($shiftID);
    //mysqli_close($conn);
}

if (isset($_POST['submitCheckOut'])) {

    $sql = $connPDO->prepare("Select s.ShiftID, s.VolunteerID, s.StartTime, s.ShiftDate FROM Shift s
    JOIN Volunteer ON Volunteer.VolunteerID = s.VolunteerID JOIN Person
    ON Person.PersonID = Volunteer.PersonID JOIN Account
    ON Account.AccountID = Person.AccountID
    WHERE Account.AccountID = :AccountID AND s.CheckedIn = 'y'");

    $sql->bindParam(':AccountID', $_SESSION['AccountID']);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    $shiftID= $result['ShiftID'];

    $volunteerID = 0;
    $startTime = $result['StartTime'];
    $shiftDate = $result['ShiftDate'];
    $endTime = $currentTime;

    $startTimeMilitaryTime = date("G:i", strtotime($startTime));
    $endTimeMilitaryTime = date("G:i", strtotime($endTime));

    $day1 = $shiftDate . $startTimeMilitaryTime;
    $day1 = strtotime($day1);
    $day2 = $shiftDate . $endTimeMilitaryTime;
    $day2 = strtotime($day2);
    $diffHours = round(($day2 - $day1) / 3600);
    $hours = $diffHours;

    $shiftDepartment = 'none';

    //select the shiftid thats equal to y of that volunteerID

    //$sqlUpdateShift = "UPDATE Shift SET EndTime = $endTime, CheckedIn = 'n' WHERE ShiftID = $shiftID";
    $sqlUpdateShift = "UPDATE Shift SET EndTime = '$endTimeMilitaryTime', ShiftHours = $hours, CheckedIn = 'n' WHERE ShiftID = $shiftID AND CheckedIn = 'y'";
    //$sqlUpdateShift = "UPDATE Shift SET CheckedIn = 'n' WHERE ShiftID = $shiftID";

    $stmt = mysqli_query($conn, $sqlUpdateShift);

    //  var_dump($shiftID);
//    var_dump($currentTime);

}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | Volunteer Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>
<script>

    function displayInfo(elem){
        if(elem.value === "Transport") {
            document.getElementById('transport').style.display = "block";
        }
        else
        {
            document.getElementById('transport').style.display = "none";
        }
    }
</script>
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
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $VolunteerName?></strong>
                             
							 <a href="#"><span class="nav-label text-muted"><?php while($row = mysqli_fetch_array($resultsDepartments)) { echo $row['DepartmentName'] . " Volunteer" . "<br/>"; } ?></span></a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.php">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li class = "active">
                    <a href="volunteer_dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="profile.php"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li>
                    <a href="loghoursandmiles.php"><i class="fa fa-clock-o"></i> <span class="nav-label">Hours/Miles</span></a>
                </li>
				<li>
                    <a href="/Calendar"><i class="fa fa-calendar"></i> <span class="nav-label">Calendar</span></a></li>
                <li>
                <li>
                    <a href="training.php"><i class="fa fa-cogs"></i> <span class="nav-label">Training</span>  </a>
                </li>

                <li>
                    <a href="personApplicationForm.php"><i class="fa fa-user"></i> <span class="nav-label">Apply</span>  </a>
                </li>

                <li>
                    <a href="volunteer_applicationInfo.php"><i class="fa fa-clipboard"></i> <span class="nav-label">Applications</span></a>
                </li>
				<li>
                    <a href="transporter_map.html"><i class="fa fa-clipboard"></i> <span class="nav-label">Maps</span></a>
                </li>
            </ul>
        </div>
    </nav> <!-- end of navigation -->


    <!-- TOP WHITE BAR WITH HAMBURGER MENU & LOGOUT BUTTON -->
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
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

        <!-- BEGINNING OF HEADER -->
        <div class = "row">
            <div class = "col-sm-12">
                <header class="image-bg-fluid-height ">
                    <div class = "text-overlay">


                        <h3 class = "date"><?php echo $Date ?></h3>
                        <h1 class = "welcome-user">  HELLO <?= strtoupper($VolunteerFirstName); ?></h1>

                        <!-- Button trigger modal -->
                        <?php
                        global $conn;

                        $currentAcc =  $_SESSION['AccountID'];

                        $records = "SELECT s.CheckedIn FROM Shift s
                        JOIN Volunteer on Volunteer.VolunteerID = s.VolunteerID
                        JOIN Person on Person.PersonID = Volunteer.PersonID
                        JOIN Account on Account.AccountID = Person.AccountID
                        Where Account.AccountID = $currentAcc AND s.CheckedIn = 'y'";

                        $admin_set = mysqli_query($conn, $records);
                        // confirm_query($admin_set);
                        if (!$admin_set) {
                            die("Database query failed");
                        }

                        $results = $admin_set->fetch_all(MYSQLI_ASSOC);

                        foreach ($results as $result) {
                            if ($result['CheckedIn'] !== 'n') {
                                ?>
                                <!--                                <a href="#" id="checkIn" data-toggle="modal" data-target="#checkInUser"> CHECK OUT <i-->
                                <!--                                            class="fa fa-check-square-o"></i></a>-->
                                <form id="submitCheckOut" method="post">
                                    <button name="submitCheckOut" id="checkOut" type="submit" class="">CHECK OUT</button>
                                </form>

                            <?php } else { ?>
                                <a href="#" id="checkIn" data-toggle="modal" data-target="#checkInUser"> CHECK IN <i
                                            class="fa fa-check-square-o"></i></a>
                            <?php }
                        }
                        if($results == null){ ?>
                            <a href="#" id="checkIn" data-toggle="modal" data-target="#checkInUser"> CHECK IN <i
                                        class="fa fa-check-square-o"></i></a>
                        <?php }
                        // var_dump($result['CheckedIn']);
                        ?>
                    </div>
                </header>
            </div>
        </div>




        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-xs-3">
                    <div class="ibox float-e-margins">

                        <!-- BEGINNING OF TOP LINKS -->
                        <a href = "profile.php">
                            <div class="ibox-title">
                                <!-- top green bar decoration -->
                            </div>
                            <div class="ibox-content-dash centered">
                                <i class="fa fa-user enlarge-icons centered"></i>
                                <div>
                                    <h2 class = "icon-title centered">PROFILE</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="ibox float-e-margins">

                        <!-- BEGINNING OF TOP LINKS -->
                        <a href = "#">
                            <div class="ibox-title">
                                <!-- top green bar decoration -->
                            </div>
                            <div class="ibox-content-dash centered">
                                <i class="fa fa-calendar enlarge-icons centered"></i>
                                <div>
                                    <h2 class = "icon-title centered">CALENDAR</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="ibox float-e-margins">

                        <!-- BEGINNING OF TOP LINKS -->
                        <a href = "loghoursandmiles.php">
                            <div class="ibox-title">
                                <!-- top green bar decoration -->
                            </div>
                            <div class="ibox-content-dash centered">
                                <i class="fa fa-clock-o enlarge-icons centered"></i>
                                <div>
                                    <h2 class = "icon-title centered">Hours/Miles</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="ibox float-e-margins">

                        <!-- BEGINNING OF TOP LINKS -->
                        <a href = "#">
                            <div class="ibox-title">
                                <!-- top green bar decoration -->
                            </div>
                            <div class="ibox-content-dash centered">
                                <i class="fa fa-cogs enlarge-icons centered"></i>
                                <div>
                                    <h2 class = "icon-title centered">TRAINING</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- END OF ROW 1 ICONS -->


            <div class="col-sm-12">

                <div id="calendar"></div>
            </div>
        </div><!-- end row -->
    </div> <!-- end row -->



</div>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>


<!-- Modal -->
<div class="modal fade" id="checkInUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="submitCheckIn" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="checkInTitle">CHECK IN TO VOLUNTEER</h3>
                    <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body centered">

                    <h1> <?php echo $currentTime ?> </h1>
                    <div class = "orangeBackground">
                    <h4 class="whiteText"> SELECT VOLUNTEER TYPE </h4>
                    <select name="Department"id="Department" onchange=displayInfo(this)>
                        <option>- Select -</option>
                        <?php

                        $mysqlserver="localhost";
                        $mysqlusername="root";
                        $mysqlpassword="secret";
                        $mysqlDB="wildlifeDB";

                        $link = mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword, $mysqlDB);

                        if (!$link) {
                            echo "Error: Unable to connect to MySQL." . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                            exit;
                        }

                        $currentAccountID = $_SESSION['AccountID'];

                        $cdquery="SELECT Department.DepartmentName
                        FROM Department
                        JOIN VolunteerDepartment ON Department.DepartmentID = VolunteerDepartment.DepartmentID
                        JOIN Volunteer ON Volunteer.VolunteerID = VolunteerDepartment.VolunteerID
                        JOIN Person ON Volunteer.PersonID = Person.PersonID
                        JOIN Account ON Account.AccountID = Person.AccountID
                        WHERE Account.AccountID = '$currentAccountID'";
                        $cdresult=mysqli_query($link, $cdquery);

                        while ($cdrow=mysqli_fetch_array($cdresult)) {
                            $DepartmentName=$cdrow["DepartmentName"];
                            echo "<option>
										$DepartmentName
									</option>";

                        }

                        ?>
                    </select>
                </div>
                </div>
            <div id="transport" style="display: none;"  >
                <div class = "row" >
                    <div class = "col-sm-11">

                        <table class = "moveDown ">
                            <tbody class = "">
                            <tr>
                                <td class = "avail_space space-left text-left">ANIMAL TRANSPORTED </td>
                                <td class = "avail_space pull-left">
                                    <input type="text" name="animalTransported" value="" size="15">
                                </td>
                                <td class = "avail_space"> </td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left">MILES DRIVEN </td>
                                <td class = "avail_space pull-left"><input type="text" name="numMiles" value="" size="5"></td>
                                <td class = "avail_space"> </td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left"> PICK UP ADDRESS </td>
                                <td class = "avail_space pull-left"><input type="text" name="pickUpStreet" value="" size = "20"></td>
                                <td class = "avail_space"></td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left">  </td>
                                <td class = "avail_space space-left text-left">CITY<input type="text" name="pickUpCity" value="" size = "20"></td>
                                <td class = "avail_space space-left text-left"> STATE
                                    <select name="pickUpState" >
                                        <option value="Virginia">Virginia</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="MD">Maryland</option>
                                        <option value="n/a">----------</option>
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
                                        <option value="WA">Washington</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select>

                                <td class = "avail_space"></td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left">  </td>
                                <td class = "avail_space space-left text-left">COUNTY
                                    <select name="pickUpCounty">
                                        <option value="Accomack">Accomack</option>
                                        <option value="Albemarle">Albemarle</option>
                                        <option value="Alleghany">Alleghany</option>
                                        <option value="Amelia">Amelia</option>
                                        <option value="Amherst">Amherst</option>
                                        <option value="Appomattox">Appomattox</option>
                                        <option value="Arlington">Arlington</option>
                                        <option value="Augusta">Augusta</option>
                                        <option value="Bath">Bath</option>
                                        <option value="Bedford">Bedford</option>
                                        <option value="Bland">Bland</option>
                                        <option value="Botetourt">Botetourt</option>
                                        <option value="Brunswick">Brunswick</option>
                                        <option value="Buchanan">Buchanan</option>
                                        <option value="Buckingham">Buckingham</option>
                                        <option value="Campbell">Campbell</option>
                                        <option value="Caroline">Caroline</option>
                                        <option value="Carroll">Carroll</option>
                                        <option value="Charles City">Charles City</option>
                                        <option value="Charlotte">Charlotte</option>
                                        <option value="Chesterfield">Chesterfield</option>
                                        <option value="Clarke">Clarke</option>
                                        <option value="Craig">Craig</option>
                                        <option value="Culpeper">Culpeper</option>
                                        <option value="Cumberland">Cumberland</option>
                                        <option value="Dickenson">Dickenson</option>
                                        <option value="Dinwiddie">Dinwiddie</option>
                                        <option value="Essex">Essex</option>
                                        <option value="Fairfax">Fairfax</option>
                                        <option value="Fauquier">Fauquier</option>
                                        <option value="Floyd">Floyd</option>
                                        <option value="Fluvanna">Fluvanna</option>
                                        <option value="Franklin">Franklin</option>
                                        <option value="Frederick">Frederick</option>
                                        <option value="Giles">Giles</option>
                                        <option value="Gloucester">Gloucester</option>
                                        <option value="Goochland">Goochland</option>
                                        <option value="Grayson">Grayson</option>
                                        <option value="Greene">Greene</option>
                                        <option value="Greensville">Greensville</option>
                                        <option value="Halifax">Halifax</option>
                                        <option value="Hanover">Hanover</option>
                                        <option value="Henrico">Henrico</option>
                                        <option value="Henry">Henry</option>
                                        <option value="Highland">Highland</option>
                                        <option value="Isle of Wight">Isle of Wight</option>
                                        <option value="James City">James City</option>
                                        <option value="King and Queen">King and Queen</option>
                                        <option value="King George">King George</option>
                                        <option value="King William">King William</option>
                                        <option value="Lancaster">Lancaster</option>
                                        <option value="Lee">Lee</option>
                                        <option value="Loudoun">Loudoun</option>
                                        <option value="Louisa">Louisa</option>
                                        <option value="Lunenburg">Lunenburg</option>
                                        <option value="Madison">Madison</option>
                                        <option value="Mathews">Mathews</option>
                                        <option value="Mecklenburg">Mecklenburg</option>
                                        <option value="Middlesex">Middlesex</option>
                                        <option value="Montgomery">Montgomery</option>
                                        <option value="Nelson">Nelson</option>
                                        <option value="New Kent">New Kent</option>
                                        <option value="Northampton">Northampton</option>
                                        <option value="Northumberland">Northumberland</option>
                                        <option value="Nottoway">Nottoway</option>
                                        <option value="Orange">Orange</option>
                                        <option value="Page">Page</option>
                                        <option value="Patrick">Patrick</option>
                                        <option value="Pittsylvania">Pittsylvania</option>
                                        <option value="Powhatan">Powhatan</option>
                                        <option value="Prince Edward">Prince Edward</option>
                                        <option value="Prince George">Prince George</option>
                                        <option value="Prince William">Prince William</option>
                                        <option value="Pulaski">Pulaski</option>
                                        <option value="Rappahannock">Rappahannock</option>
                                        <option value="Richmond">Richmond</option>
                                        <option value="Roanoke">Roanoke</option>
                                        <option value="Rockbridge">Rockbridge</option>
                                        <option value="Rockingham">Rockingham</option>
                                        <option value="Russell">Russell</option>
                                        <option value="Scott">Scott</option>
                                        <option value="Shenandoah">Shenandoah</option>
                                        <option value="Smyth">Smyth</option>
                                        <option value="Southampton">Southampton</option>
                                        <option value="Spotsylvania">Spotsylvania</option>
                                        <option value="Stafford">Stafford</option>
                                        <option value="Surry">Surry</option>
                                        <option value="Sussex">Sussex</option>
                                        <option value="Tazewell">Tazewell</option>
                                        <option value="Warren">Warren</option>
                                        <option value="Washington">Washington</option>
                                        <option value="Westmoreland">Westmoreland</option>
                                        <option value="Wise">Wise</option>
                                        <option value="Wythe">Wythe</option>
                                        <option value="York">York</option>
                                    </select>
                                </td>
                                <td class = "avail_space space-left text-left btmSpace"> ZIP CODE
                                    <input type="text" name="pickUpZipCode" value="" size = "20"> </td>
                                <td class = "avail_space"> </td>
                            </tr>


                            </tbody>
                        </table>


                    </div><!-- end of selection box row -->

                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button name="submitCheckIn" type="submit" class="btn-edit-form">CHECK IN</button>
                </div>
            </div>
    </form>
</div>
</div>
</div>
</body>
</html>