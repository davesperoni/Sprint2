<?php
/**
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 4/1/17
 * Time: 12:21 AM
 */

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


$sqlShowHours= "SELECT Person.FirstName AS 'FN', Person.MiddleInitial AS 'MI', Person.LastName AS 'LN',
  Department.DepartmentName AS 'Dept', Shift.ShiftDate AS 'ShiftDate', Shift.ShiftHours AS 'ShiftHours', Shift.StartTime AS 'StartTime', Shift.EndTime AS 'EndTime', Volunteer.YTDHours AS 'TotalHours', Volunteer.YTDMiles AS 'TotalMiles' FROM Person JOIN Volunteer ON Person.PersonID = Volunteer.PersonID
  JOIN VolunteerDepartment ON Volunteer.VolunteerID = VolunteerDepartment.VolunteerID
  JOIN Department ON VolunteerDepartment.DepartmentID = Department.DepartmentID
JOIN Shift ON Volunteer.VolunteerID = Shift.VolunteerID;";

$result = mysqli_query($conn, $sqlShowHours) or die("Error " . mysqli_error($conn));
?>


<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | Pending Applications</title>

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
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Shelly Hokanson</strong>
                             </span> <span class="text-muted text-xs block">Volunteer<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
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
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
</a>
                </li>
            </ul>

        </nav>
        </div>

        <!-- BEGINNING OF DATA BOXES -->
         <div class = "row">


		         <div class = "col-sm-6">
		         	<div class = "updateNumbers">
                        <?php
                        while($row = mysqli_fetch_array($result)) {

                        $FirstName = $row['FN'];
                        $MiddleInitial = $row['MI'];
                        $LastName = $row['LN'];

                        $VolunteerFullName = $FirstName . " " . $MiddleInitial . " " . $LastName;
                        $DepartmentName = $row['Dept'];
                        $ShiftDate = $row['ShiftDate'];
                        $ShiftHours = $row['ShiftHours'];
                        $StartTime = $row['StartTime'];
                        $EndTime = $row['EndTime'];

                        $phpdate = strtotime( $ShiftDate );
                        $ShiftDate = date( 'm-d-Y', $phpdate);
                        $TotalHours = $row['TotalHours'];
                        $TotalMiles = $row['TotalMiles'];

                        ?>

		         		<h1 class = "updateTitle"> <?php echo $TotalHours ?> </h1>
		         		<h3 class = "updateSubhead">HOURS VOLUNTEERED</h3>
		         	</div><!-- end of inner box for logging hours -->
			         	<div class = "row">
			         		<div class = "col-sm-3">

						        <!-- EDIT HOURS MODAL -->
								<a href="#" class = "editBtns" id = "editHours1" data-toggle = "modal" data-target = "#editHours"> Edit <i class="fa fa-pencil"></i></a>

			         			<a class="editBtns">Hours</a>

			         		</div><!-- end of edit pencil -->
			         	</div><!-- end of bottom box with edit and view options -->
		         </div><!-- log hours -->

		         <div class = "col-sm-6">
		         	<div class = "updateNumbers">
		         		<h1 class = "updateTitle"> <?php echo $TotalMiles ?></h1>
		         		<h3 class = "updateSubhead">MILES DRIVEN</h3>

		         	</div><!-- end of inner box for logging miles -->
		         	<div class = "row">
			         		<div class = "col-sm-3">

			         		<!-- EDIT HOURS MODAL -->
								<a href="#" class = "editBtns" id = "editMiles" data-toggle = "modal" data-target = "#editMiles"> Edit <i class="fa fa-pencil"></i></a>

			         		</div><!-- end of edit pencil -->
			         	</div><!-- end of bottom box with edit and view options -->
		         </div><!-- log miles -->

    	</div><!-- end of 2 large data boxes -->

   <!--Start Table -->
   <div class = "row moveDown">
   <div class = "col-sm-10 col-sm-offset-1">
	<div class="pendingapps_table">
    <table class="table table-striped">
    <thead class="pendingapps-header">
      <tr>
        <th class="pendingapps_header_content">Type of Volunteer</th>
        <th class="pendingapps_header_content">Shift Date</th>
        <th class="pendingapps_header_content">Start Time</th>
        <th class="pendingapps_header_content">End Time</th>
        <th class="pendingapps_header_content">Hours</th>
      </tr>
    </thead>

        <br />
        <tbody>
        <tr>

            <td><?php echo $DepartmentName ?></td>
            <td><?php echo $ShiftDate ?></td>
            <td><?php echo $StartTime ?></td>
            <td><?php echo $EndTime ?></td>
            <td><?php echo $ShiftHours ?></td>

        </tr>

        <?php } ?>

    </tbody>
  </table>

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

  </div>
            <!--End Table -->


</div><!-- end row -->
</div> <!-- end row -->
</div>
</div>



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
        $('#placeLog').html("hi")

       		}

    function displayMiles()
    {
        $('#placeLog').html("<p>bitch i'm a dog</p>");
    }

    $('.datepicker').datepicker();



});
    </script>



     <!-- EDIT HOURS MODAL -->
			        <div class="modal fade" id="editHours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
			                       <select class = "selection-box-hm">
			                          <option value="volvo">Animal Care</option>
			                          <option value="saab">Outreach</option>
			                          <option value="mercedes">Transport</option>
			                          <option value="audi">Vet Team</option>
			                          <option value="audi">Other</option>
			                    </select>

			                    <!-- DATE PICKER -->
			                    <div class="bfh-timepicker" data-mode="12h"></div>
			                      <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">

                                      <label class = "pull-left" for="name">Date:</label>
									    <input type="text" class="input-sm form-control place-inline pull-left" name="start" />

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
		            						<input id="timepicker1" type="text" class="form-control input-small">

	        						  </div><!-- end of time picker -->
	        					  </div><!-- end of start time col-->

	        					<div class = "col-sm-4">
	        						  <div class="input-group bootstrap-timepicker timepicker">

	        								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
		            						<input id="timepicker2" type="text" class="form-control input-small">


	        						  </div><!-- end of time picker -->

	        				    </div><!-- end of end time col -->
	        					</div><!-- end of row -->
			                    </div><!-- end of modal body -->

			                    <div class="modal-footer">
			                             <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
			                        <button type="button" class="btn-edit-form">UPDATE LOG</button>
			                    </div>
			                </div>
			            </div>
			        </div><!-- end of edit hours modal -->



		<!-- time picker script -->
	    <script type="text/javascript">
    $('#timepicker1').timepicker();
        </script>
</body>
</html>