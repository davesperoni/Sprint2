<?php
    /**
     * Created by PhpStorm.
     * User: ViviannRutan
     * Date: 4/8/17
     * Time: 12:34 AM
     */

    session_start();
    require 'databasePDO.php';
    require 'database.php';
    include("Classes/Shift.php");
    include("Classes/Mileage.php");

    $records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName FROM Person where AccountID = :AccountID');
    $records->bindParam(':AccountID', $_SESSION['AccountID']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){
        $personInformation = $results;
    }

    $VolunteerName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];
?>

<?php
    $sqlShowHours= "SELECT Person.FirstName AS 'FN', Person.MiddleInitial AS 'MI', Person.LastName AS 'LN', Shift.ShiftID AS 'ShiftID',
                    Shift.DepartmentID AS 'Dept', Shift.ShiftDate AS 'ShiftDate', Shift.ShiftHours AS 'ShiftHours', 
                    Shift.StartTime AS 'StartTime', Shift.EndTime AS 'EndTime', Volunteer.YTDHours AS 'TotalHours', 
                    Volunteer.YTDMiles AS 'TotalMiles' FROM Person JOIN Volunteer ON Person.PersonID = Volunteer.PersonID
                    JOIN Shift ON Volunteer.VolunteerID = Shift.VolunteerID;";

    $result = mysqli_query($conn, $sqlShowHours) or die("Error " . mysqli_error($conn));

    $sqlHoursMiles= "SELECT Volunteer.YTDHours AS 'TotalHours', Volunteer.YTDMiles AS 'TotalMiles' 
                     FROM Person JOIN Volunteer ON Person.PersonID = Volunteer.PersonID";

    $sqlHoursMiles = mysqli_query($conn, $sqlHoursMiles) or die("Error " . mysqli_error($conn));

    while($row = mysqli_fetch_array($sqlHoursMiles)) {
        $TotalHours = $row['TotalHours'];
        $TotalMiles = $row['TotalMiles'];
    }

    $sqlShowMiles = "Select Mileage.TripID AS 'TripID', Mileage.TripDate AS 'TripDate', Mileage.TripMiles AS 'TripMiles', 
                     Mileage.PickUpStreet AS 'Street', Mileage.PickUpCity AS 'City', Mileage.PickUpState AS 'State', 
                     Mileage.PickUpCountyName AS 'County', Mileage.PickUpZipCode AS 'Zip', Mileage.AnimalTransported AS 'Animal' 
                     FROM Mileage JOIN Volunteer ON Volunteer.VolunteerID = Mileage.VolunteerID";

    $resultMiles = mysqli_query($conn, $sqlShowMiles) or die("Error " . mysqli_error($conn));
?>

<?php
    if (isset($_POST['SubmitHourLog'])) {
        $sql = $connPDO->prepare('SELECT Volunteer.VolunteerID FROM Volunteer JOIN Person ON Person.PersonID = Volunteer.PersonID JOIN Account ON Person.AccountID = Account.AccountID where Account.AccountID = :AccountID');
        $sql->bindParam(':AccountID', $_SESSION['AccountID']);
        $sql->execute();
        $volunteerResult = $sql->fetch(PDO::FETCH_ASSOC);

        $volunteerID= $volunteerResult['VolunteerID'];
        $startTime = $_POST['ShiftStartTime'];

        $date = date('Y-m-d', strtotime($_POST["ShiftDate"]));

        $endTime = $_POST['ShiftEndTime'];
        $department = $_POST['ShiftDepartment'];

        if ($department === "AnimalCare")
        {
            $department = 1;
        }
        else if ($department === "Outreach")
        {
            $department = 2;
        }
        else if($department === "Transport")
        {
            $department = 3;
        }
        else if ($department === "VetTeam")
        {
            $shiftDepartment = 4;
        }

        $startTimeMilitaryTime= date("G:i", strtotime($startTime));
        $endTimeMilitaryTime =date("G:i", strtotime($endTime));

        $day1 = $date . $startTimeMilitaryTime;
        $day1 = strtotime($day1);
        $day2 = $date . $endTimeMilitaryTime;
        $day2 = strtotime($day2);
        $diffHours = round(($day2 - $day1) / 3600);
        $hours = $diffHours;

        var_dump($hours);
        $newShift = new Shift($volunteerID, $department, $date, $startTimeMilitaryTime, $endTimeMilitaryTime, $hours);

        $shiftVolunteerID = $newShift->getShiftVolunteerID();
        $shiftDepartment = $newShift->getShiftDepartmentID();
        $shiftDate = $newShift->getShiftDate();
        $shiftStartTime = $newShift->getShiftStartTime();
        $shiftEndTime = $newShift->getShiftEndTime();
        $shiftHours = $newShift->getShiftHours();
        $shiftLastUpdatedBy = $newShift->getShiftLastUpdatedBy();
        $shiftLastUpdated = $newShift->getShiftLastUpdated();
        $sqlInsertShift = "INSERT INTO Shift (VolunteerID, DepartmentID, ShiftDate, StartTime, EndTime, ShiftHours, LastUpdatedBy, LastUpdated)
        VALUES($shiftVolunteerID, $shiftDepartment, '$shiftDate', '$shiftStartTime', '$shiftEndTime', $shiftHours, '$shiftLastUpdatedBy', $shiftLastUpdated)";

        var_dump($sqlInsertShift);

        $stmt = mysqli_query($conn, $sqlInsertShift);

    }

    if (isset($_POST['SubmitMilesLog'])) {
        $sql = $connPDO->prepare('SELECT Volunteer.VolunteerID FROM Volunteer JOIN Person ON Person.PersonID = Volunteer.PersonID JOIN Account ON Person.AccountID = Account.AccountID where Account.AccountID = :AccountID');
        $sql->bindParam(':AccountID', $_SESSION['AccountID']);
        $sql->execute();
        $volunteerResult = $sql->fetch(PDO::FETCH_ASSOC);

        $volunteerID= $volunteerResult['VolunteerID'];
        $departmentID = 3;
        $tripDate = date('Y-m-d', strtotime($_POST['transportDate']));
        var_dump($tripDate);
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

        $sqlInsertMileage = "INSERT INTO Mileage (DepartmentID, VolunteerID, TripDate, TripMiles, PickUpStreet, PickUpCity, PickUpState, PickUpCountyName, PickUpZipCode, AnimalTransported, LastUpdatedBy, LastUpdated) VALUES ($departmentID, $volunteerID, '$tripDate', $tripMiles, '$pickUpStreet', '$pickUpCity', '$pickUpState', '$pickUpCounty', '$pickUpZipCode', '$animalTransported', '$tripLastUpdatedBy', CURRENT_TIMESTAMP)";

        var_dump($sqlInsertMileage);
        $stmt = mysqli_query($conn, $sqlInsertMileage);
    }
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | Log Hours and Miles</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel= "stylesheet">
    <link href="css/bootstrap-timepicker.min.css" rel="stylesheet">



    <link href="css/style.css" rel="stylesheet">

    <!-- bootstrap datepicker css -->
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <script src = "js/bootstrap-datepicker.js"> </script>
    <script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>


</head>

<body>
<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_pic.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $VolunteerName ?></strong>
                             </span> <span class="text-muted text-xs block">Volunteer<b class="caret"></b></span> </span> </a>
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
                    <a href="volunteer_dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="profile.php"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li class = "active">
                    <a href="loghoursandmiles.php"><i class="fa fa-clock-o"></i> <span class="nav-label">Update</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Training</span>  </a>
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
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div class = "notify-text-desc">
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div class = "notify-text-desc">
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div class = "notify-text-desc">
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong id = "notify-text">See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="login.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

        <!-- BEGINNING OF DATA BOXES -->
        <div class = "row btmSpace">


            <div class = "col-sm-6">
                <div class = "updateNumbers">
                    <h1 class = "updateTitle">  <?php echo $TotalHours ?></h1>
                    <h3 class = "updateSubhead">HOURS VOLUNTEERED</h3>
                </div><!-- end of inner box for logging hours -->
                <div class = "row">
                    <div class = "col-sm-6">

                        <!-- EDIT HOURS MODAL -->
                        <a href="#" class = "editBtns" id = "editHours1" data-toggle = "modal" data-target = "#editHours"> Add Hours <i class="fa fa-pencil"></i></a>

                        <a class="editBtn-right" id = "viewHoursLog"> View Hours</a>


                    </div><!-- end of edit pencil -->
                </div><!-- end of bottom box with edit and view options -->
            </div><!-- log hours -->




            <div class = "col-sm-6">
                <div class = "updateNumbers">
                    <h1 class = "updateTitle"> <?php echo $TotalMiles ?> </h1>
                    <h3 class = "updateSubhead">MILES DRIVEN</h3>
                </div><!-- end of inner box for logging miles -->
                <div class = "row">
                    <div class = "col-sm-6">

                        <!-- EDIT MILES MODAL -->
                        <a href="#" class = "editBtns" id = "editMiles1" data-toggle = "modal" data-target = "#editMiles"> Add Miles <i class="fa fa-pencil"></i></a>

                        <a class="editBtn-right" id = "viewMilesLog"> View Miles</a>

                    </div><!-- end of edit pencil -->
                </div><!-- end of bottom box with edit and view options -->
            </div><!-- end log miles -->

        </div><!-- end of 2 large data boxes -->


        <!-- START TABLES -->
        <div class = "row btmSpaceLess">
            <div class = "col-sm-10 col-sm-offset-1">

                <div id = "wrapperPlaceLog1">
                    <h3 class ="makeOrange place-inline">HOURS LOG </h3>
                    <select class = "selection-box-log pull-right">
                        <option value="volvo">Volunteer Type</option>
                        <option value="saab">Date</option>
                        <option value="mercedes">Number of Hours</option>
                    </select>
                    <!-- was thinking this would sort vol type by alphabetical -->




                    <!--Start Table -->

                    <table class="table table-striped">
                        <thead class="pendingapps-header">
                        <tr>
                            <th class="pendingapps_header_content">VOLUNTEER TYPE</th>
                            <th class="pendingapps_header_content">SHIFT DATE</th>
                            <th class="pendingapps_header_content">START TIME</th>
                            <th class="pendingapps_header_content">END TIME</th>
                            <th class="pendingapps_header_content"># OF HOURS</th>
                            <th class="pendingapps_header_content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            while($row = mysqli_fetch_array($result)) {

                            $FirstName = $row['FN'];
                            $MiddleInitial = $row['MI'];
                            $LastName = $row['LN'];

                            $ShiftID = $row['ShiftID'];

                            $VolunteerFullName = $FirstName . " " . $MiddleInitial . " " . $LastName;
                            $DepartmentName = $row['Dept'];
                            $date = $row['ShiftDate'];
                            $ShiftHours = $row['ShiftHours'];
                            $start = $row['StartTime'];
                            $end = $row['EndTime'];

                            $phpDate = strtotime( $date );
                            $ShiftDate = date( 'm-d-Y', $phpDate);

                            $StartTime= date("g:i a", strtotime($start));
                            $EndTime= date("g:i a", strtotime($end));

                            if ($DepartmentName === '1')
                            {
                                $DepartmentName = "Animal Care";
                            }
                            else if ($DepartmentName === '2')
                            {
                                $DepartmentName = "Outreach";
                            }
                            else if($DepartmentName === '3')
                            {
                                $DepartmentName = "Transport";
                            }
                            else if ($DepartmentName === '4')
                            {
                                $DepartmentName = "Treatment";
                            }

                            ?>
                            <td><?php echo $DepartmentName ?></td>
                            <td><?php echo $ShiftDate ?></td>
                            <td><?php echo $StartTime ?></td>
                            <td><?php echo $EndTime ?></td>
                            <td><?php echo $ShiftHours ?></td>

                            <td><a href="/UPDATEHOURS.php?id=<?php echo $ShiftID ?>" class="editBtns" id="updateHoursEntry"  > Edit Entry <i class="fa fa-pencil"></i></a>

                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <!-- links at the bottom that move through entries in the log -->
                    <div class = "row">
                        <div class = "col-sm-4 col-sm-offset-4">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- end of pagination row -->
                </div><!-- end of wrapperPlaceLog1 -->


                <!-- START MILES LOG -->
                <div id = "wrapperPlaceLog2" style="display:none;">

                    <h3 class ="makeOrange place-inline"> MILES LOG </h3>
                    <select class = "selection-box-log pull-right">
                        <option value="volvo">Volunteer Type</option>
                        <option value="saab">Date</option>
                        <option value="mercedes">Number of Hours</option>
                    </select>
                    <!-- was thinking this would sort vol type by alphabetical -->


                    <table class="table table-striped">
                        <thead class="pendingapps-header">
                        <tr>
                            <th class="pendingapps_header_content">TRANSPORT DATE</th>
                            <th class="pendingapps_header_content">ANIMAL</th>
                            <th class="pendingapps_header_content">PICK UP ADDRESS</th>
                            <th class="pendingapps_header_content">COUNTY</th>
                            <th class="pendingapps_header_content">MILES DRIVEN</th>
                            <th class="pendingapps_header_content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            while($row = mysqli_fetch_array($resultMiles)) {

                                $TripID= $row['TripID'];
                                $date = $row['TripDate'];
                                $TripMiles = $row['TripMiles'];
                                $TripStreet = $row['Street'];
                                $TripCity = $row['City'];
                                $TripCounty = $row['County'];
                                $TripState = $row['State'];
                                $TripZipCode = $row['Zip'];
                                $TripAnimal = $row['Animal'];

                                $phpDate = strtotime( $date );
                                $TripDate = date( 'm-d-Y', $phpDate);

                                ?>

                            <td><?php echo $TripDate ?></td>
                            <td><?php echo $TripAnimal ?></td>
                            <td><?php echo $TripStreet ?></td>
                            <td><?php echo $TripCounty ?></td>
                            <td><?php echo $TripMiles ?></td>
                            <td><a href="/updateMilesEntry.php?id=<?php echo $TripID ?>" class = "editBtns" id = "Purple" > Edit Entry<i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <!-- links at the bottom that move through entries in the log -->
                    <div class = "row">
                        <div class = "col-sm-4 col-sm-offset-4">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- end of pagination row -->
                </div><!-- end of wrapperPlaceLog2 -->









            </div><!--End Table -->
        </div><!-- end wrapper -->

    </div> <!-- end of col -->
</div><!-- end of row -->


</div><!-- end of container -->

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

<!-- Timepicker -->
<script src = "js/bootstrap-timepicker.min.js"> </script>

<script>
    $(document).ready(function(event) {
        $('#viewHoursLog').on('click', displayHours);
        $('#viewMilesLog').on('click', displayMiles);

        function displayHours()
        {

            $('#wrapperPlaceLog1').css('display', 'block');
            $('#wrapperPlaceLog2').css('display', 'none');
        }

        function displayMiles()
        {
            $('#wrapperPlaceLog2').css('display', 'block');
            $('#wrapperPlaceLog1').css('display', 'none');
        }

        $('.datepicker').datepicker();



    });

    $('#updateHours').on('show.bs.modal', function(e) {

        var id = $(e.relatedTarget).data('id');
        $(e.currentTarget).find('input[name="UpdateHoursEntry"]').val(id);
    });



</script>

<div class="modal fade" id="editHours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form name ="SubmitHourLog" method="post" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="checkInTitle"> UPDATE HOURS</h3>
                <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body centered">

                <!-- this will change depending on the type(s) of volunteers that they can be -->
                <h4> SELECT VOLUNTEER TYPE </h4>
                <select name="ShiftDepartment" class = "selection-box-hm">
                    <option value="AnimalCare">Animal Care</option>
                    <option value="Outreach">Outreach</option>
                    <option value="Transport">Transport</option>
                    <option value="VetTeam">Vet Team</option>
                </select>

                <!-- DATE PICKER -->
                <div class="bfh-timepicker" data-mode="12h"></div>
                <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">

                    <label class = "pull-left" for="name">Date:</label>
                    <input type="text" class="input-sm form-control place-inline pull-left" name="ShiftDate"/>

                </div>

                <div class = "row no-btm-space moveDown">
                    <div class = "col-sm-4">
                        <label class = "pull-left place-inline no-btm-space" for="name">Start Time:</label>
                    </div>

                    <div class = "col-sm-4">
                        <label class = "pull-left place-inline" for="name">End Time:</label>
                    </div>

                </div><!-- end of labels row -->

                <!-- TIME PICKER -->
                <div class = "row">
                    <div class = "col-sm-4">

                        <div class="input-group bootstrap-timepicker timepicker">


                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            <input id="timepicker1" type="text" class="form-control input-small" name="ShiftStartTime">

                        </div><!-- end of time picker -->
                    </div><!-- end of start time col-->

                    <div class = "col-sm-4">
                        <div class="input-group bootstrap-timepicker timepicker">

                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            <input id="timepicker2" type="text" class="form-control input-small" name="ShiftEndTime">


                        </div><!-- end of time picker -->

                    </div><!-- end of end time col -->
                </div><!-- end of row -->
            </div><!-- end of modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                <button type="submit" name="SubmitHourLog" class="btn-edit-form">SUBMIT LOG</button>
            </div>
        </div>
    </div>
    </form>
</div><!-- end of edit hours modal -->





<!-- EDIT MILES MODAL -->
<div class="modal fade" id="editMiles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form name ="SubmitMilesLog" method="post" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="checkInTitle"> UPDATE MILES</h3>
                    <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body centered">

                    <div class = "row">
                        <div class = "col-sm-11">

                            <table class = "moveDown ">
                                <tbody class = "">

                                <div class="bfh-timepicker" data-mode="12h"></div>
                                <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">

                                    <label class = "pull-left" for="name">DATE OF TRANSPORT:</label>
                                    <input type="text" class="input-sm form-control place-inline pull-left" name="transportDate" />

                                </div>
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

                    </div><!-- end of modal body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        <button type="submit" name="SubmitMilesLog" class="btn-edit-form">SUBMIT LOG</button>
                    </div>
                </div>
            </div>
    </form>
</div><!-- end of edit hours modal -->



<!-- time picker script -->
<script type="text/javascript">
    $('#timepicker1').timepicker();
    $('#timepicker2').timepicker();
</script>
</body>
</html>

