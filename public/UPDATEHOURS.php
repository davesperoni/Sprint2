<?php
/**
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 4/11/17
 * Time: 3:00 AM
 */
include 'database.php';
include 'databasePDO.php';
include ("Classes/Shift.php");

$ShiftID = $_GET['id'];

$sql = $connPDO->prepare('Select Volunteer.VolunteerID from Volunteer JOIN Person ON Person.PersonID = Volunteer.PersonID JOIN Account ON Person.AccountID = Account.AccountID where Account.AccountID = :AccountID');
$sql->bindParam(':AccountID', $_SESSION['AccountID']);
$sql->execute();
$volunteerResult = $sql->fetch(PDO::FETCH_ASSOC);

$volunteerID= $volunteerResult['VolunteerID'];

if (isset($_POST['updateHourLog'])) {
    $startTime = $_POST['ShiftStartTime'];
    $date = date('Y-m-d', strtotime($_POST['ShiftDate']));
    $endTime = $_POST['ShiftEndTime'];
    $department = $_POST['ShiftDepartment'];

    if ($department === "AnimalCare") {
        $department = 1;
    } else if ($department === "Outreach") {
        $department = 2;
    } else if ($department === "Transport") {
        $department = 3;
    } else if ($department === "Treatment") {
        $department = 4;
    }

    $startTimeMilitaryTime = date("G:i", strtotime($startTime));
    $endTimeMilitaryTime = date("G:i", strtotime($endTime));

    $day1 = $date . $startTimeMilitaryTime;
    $day1 = strtotime($day1);
    $day2 = $date . $endTimeMilitaryTime;
    $day2 = strtotime($day2);
    $diffHours = round(($day2 - $day1) / 3600);
    $hours = $diffHours;

    $newShift = new Shift($volunteerID, $department, $date, $startTimeMilitaryTime, $endTimeMilitaryTime, $hours);

    $shiftVolunteerID = $newShift->getShiftVolunteerID();
    $shiftDepartment = $newShift->getShiftDepartmentID();
    $shiftDate = $newShift->getShiftDate();
    $shiftStartTime = $newShift->getShiftStartTime();
    $shiftEndTime = $newShift->getShiftEndTime();
    $shiftHours = $newShift->getShiftHours();

    var_dump($shiftDepartment, $shiftDate, $shiftStartTime, $shiftEndTime, $shiftHours, $ShiftID);

    $sqlUpdateShift = "UPDATE Shift Set DepartmentID = $shiftDepartment, ShiftDate= '$shiftDate', 
StartTime= '$shiftStartTime', EndTime= '$shiftEndTime', ShiftHours = $shiftHours, LastUpdated = CURRENT_TIMESTAMP WHERE ShiftID = $ShiftID;";

    $stmt = $connPDO->prepare($sqlUpdateShift);
/*    $stmt->bindParam(':departmentID', $shiftDepartment);
    $stmt->bindParam(':shiftDate', $shiftDate);
    $stmt->bindParam(':startTime', $shiftStartTime);
    $stmt->bindParam(':endTime', $shiftEndTime);
    $stmt->bindParam(':shiftHours', $shiftHours);
    $stmt->bindParam(':shiftID', $ShiftID);*/

    var_dump($sqlUpdateShift);

    $stmt->execute();


}

$sqlShowHoursToUpdate= "SELECT Person.FirstName AS 'FN', Person.MiddleInitial AS 'MI', Person.LastName AS 'LN', Shift.ShiftID AS 'ShiftID',
  Shift.DepartmentID AS 'Dept', Shift.ShiftDate AS 'ShiftDate', Shift.ShiftHours AS 'ShiftHours', 
  Shift.StartTime AS 'StartTime', Shift.EndTime AS 'EndTime', Volunteer.YTDHours AS 'TotalHours', 
  Volunteer.YTDMiles AS 'TotalMiles' FROM Person JOIN Volunteer ON Person.PersonID = Volunteer.PersonID
JOIN Shift ON Volunteer.VolunteerID = Shift.VolunteerID where Shift.ShiftID = $ShiftID;";


$result = mysqli_query($conn, $sqlShowHoursToUpdate) or die("Error " . mysqli_error($conn));

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

    $phpDate = strtotime($date);
    $ShiftDate = date('m/d/Y', $phpDate);

    $StartTime = date("g:i a", strtotime($start));
    $EndTime = date("g:i a", strtotime($end));

    if ($DepartmentName === '1') {
        $DepartmentName = "Animal Care";
    } else if ($DepartmentName === '2') {
        $DepartmentName = "Outreach";
    } else if ($DepartmentName === '3') {
        $DepartmentName = "Transport";
    } else if ($DepartmentName === '4') {
        $DepartmentName = "Treatment";
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
<form name="UpdateHours" method="post">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_pic.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $VolunteerFullName ?></strong>
                             </span> <span class="text-muted text-xs block">Volunteer<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.php">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="login.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li>
                    <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li class = "active">
                    <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">Update</span></a>
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
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <h3 class="equalSpaceForm moveDown"> UPDATE HOURS</h3>

                <div class = "col-sm-3">
                    <label>Select Volunteer Type</label>
                </div>

                <div class = "col-sm-3">

                    <select class = "selection-box-hm" name="ShiftDepartment">
                        <option value="AnimalCare">Animal Care</option>
                        <option value="Outreach">Outreach</option>
                        <option value="Transport">Transport</option>
                        <option value="Treatment">Treatment</option>
                    </select>

                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 1 -->


        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">
                    <label class = "pull-left" for="name">Date</label>
                </div>

                <div class = "col-sm-3">
                    <div class="bfh-timepicker" data-mode="12h"></div>
                    <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">
                        <input type="text" name= "ShiftDate" class="input-sm form-control place-inline pull-left" value="<?php echo $ShiftDate?>">
                    </div>
                </div>
            </div><!-- end of container col -->
        </div><!-- end of row 2 -->

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">
                    <label class = "pull-left place-inline no-btm-space" for="name">Start Time</label>
                </div>

                <div class = "col-sm-3">
                    <div class="input-group bootstrap-timepicker timepicker">


                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        <input id="timepicker1" name="ShiftStartTime" type="text" class="form-control input-small" value="<?php echo $StartTime?>">

                    </div><!-- end of time picker -->
                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 3 -->

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">
                    <label class = "pull-left place-inline no-btm-space" for="name">End Time</label>
                </div>

                <div class = "col-sm-3">
                    <div class="input-group bootstrap-timepicker timepicker">


                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        <input id="timepicker2" name="ShiftEndTime" type="text" class="form-control input-small" value="<?php echo $EndTime?>">

                    </div><!-- end of time picker -->
                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 4 -->
        <?php } ?>

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">


                <div class = "col-sm-5 ">
                    <a type="submit" href="/loghoursandmiles.php" class="btn btn-default" data-dismiss="modal">CANCEL</a>
                    <button type="submit" name= "updateHourLog" class="btn btn-default orangeButton" data-dismiss="modal">UPDATE</button>

                </div>


            </div><!-- end of container col -->
        </div><!-- end of row 6 -->

    </form>

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
                $('#wrapperPlaceTable1').style.display == 'block';
                $('wrapperPlaceTable2').style.display == 'none';
            }

            function displayMiles()
            {
                $('#wrapperPlaceTable2').style.display == 'block';
                $('wrapperPlaceTable1').style.display == 'none';
            }

            $('.datepicker').datepicker();



        });
    </script>

    <!-- time picker script -->
    <script type="text/javascript">
        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();
    </script>
</div>
</body>
</html>