<?php
session_start();

include("Classes/Shift.php");
require 'databasePDO.php';
require 'database.php';

/**
 * Created by PhpStorm.
 * User: David Speroni
 * Date: 3/30/2017
 * Time: 3:30 PM
 */

date_default_timezone_set("America/New_York");
$Date = date('Y/m/d');
$currentTime = date("h:i:sa");

if (isset($_POST['CheckIn'])) {

    header("Location: /volunteer_dashboard.php");
    $volunteerID= 1;
    $startTime = $currentTime;
    $shiftType = $_POST['Department'];
    $shiftDate = $Date;
    $endTime = null;
    $shiftHours = null;

    $newShift = new Shift($volunteerID, $shiftDate, $startTime, $endTime, $shiftHours);

    $volunteerID = $newShift->getShiftVolunteerID();
    $shiftDate = $newShift->getShiftDate();
    $startTime = $newShift->getShiftStartTime();
    $endTime = $newShift->getShiftEndTime();
    $shiftHours = $newShift->getShiftHours();
    $shiftLastUpdatedBy = $newShift->getShiftLastUpdatedBy();
    $shiftLastUpdated = $newShift->getShiftLastUpdated();


    $sqlInsertShift = "INSERT INTO Shift (VolunteerID, ShiftDate, StartTime, EndTime, ShiftHours, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_prepare($conn, $sqlInsertShift);
    $stmt->bind_param("iiiiss", $volunteerID, $shiftDate, $startTime, $endTime, $shiftHours, $shiftLastUpdatedBy);


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

    <title>Wildlife Center of Virginia | Volunteer Dashboard</title>

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
                            <img alt="image" class="img-circle" src="img/profile_pic.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Shelly Hokanson</strong>
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
               
                <li class = "active">
                    <a href="volunteer_dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="profile.php"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li>
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

		        	
					<h3 class = "date">March 23, 2017</h3>
					<h1 class = "welcome-user"> HELLO USER </h1>

                    <!-- Button trigger modal -->
					<a href="#" id = "checkIn" data-toggle = "modal" data-target = "#checkInUser"> CHECK IN <i class="fa fa-check-square-o"></i></a>
				
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
                                <h2 class = "icon-title centered">UPDATE</h2>
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
                      <h4> SELECT VOLUNTEER TYPE </h4>
                      <select name = "Department">
                          <option value="AnimalCare">Animal Care</option>
                          <option value="Outreach">Outreach</option>
                          <option value="Transport">Transport</option>
                          <option value="VetTeam">Vet Team</option>
                          <option value="Other">Other</option>
                    </select>
                    </div>
                    <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                             <button name = "CheckIn" type="submit" class="btn-edit-form">CHECK IN</button>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
