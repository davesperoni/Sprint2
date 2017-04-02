<?php
session_start();

require 'databasePDO.php';
require 'database.php';
require 'functions.php';

$currentUser = $_SESSION['AccountID'];

    if(isApplicant($currentUser)){ ?>
    <script>
        $('#thankApply').modal('show');
    </script>
    <?php }

/**
 * Created by PhpStorm.
 * User: David Speroni
 * Date: 3/30/2017
 * Time: 3:30 PM
 */
$Date = date("F j, Y");

$records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName FROM Person where AccountID = :AccountID');
$records->bindParam(':AccountID', $_SESSION['AccountID']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0){
    $personInformation = $results;
}

$VolunteerName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];
$PersonID = $personInformation['PersonID'];

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

    <style>
        header{
            background-image: url(img/hawkflyin.jpg);

        }
    </style>

</head>
<body>
<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $VolunteerName ?></strong>
                             </span> <span class="text-muted text-xs block">Applicant<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li class = "active">
                    <a href="applicant_dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="PersonApplicationForm.php"><i class="fa fa-clipboard"></i> <span class="nav-label">Application</span></a>
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
                <header class="image-bg-fluid-height " >
                    <div class = "text-overlay">


                        <h3 class = "date"><?php echo $Date ?></h3>
                        <h1 class = "welcome-user"> HELLO APPLICANT </h1>



                        <!-- Button trigger modal -->
                        <!-- checks whether or not account has applied yet -->

                      <?php if(isApplicant($currentUser)){ ?>

                          <script>
                              $('#thankApply').modal('show');
                          </script>

                        <a href="#" id = "checkIn" data-toggle = "modal" data-target = "#thankApply"> APPLICATION PENDING </a>
                       <?php }
                        else{ ?>
                      <a href="PersonProfileForm.php" id = "checkIn" data-toggle = "modal" data-target = "#checkInUser"> APPLY TO BE A VOLUNTEER </a>
                        <?php } ?>


                    </div>
                </header>
            </div>
        </div>




        <!-- ABOUT THE DIFFERENT VOLUNTEER TYPES -->
        <div class = "row">
            <div class = "col-xs-10 col-xs-offset-1 moveDown" id = "appRow">

                <h1 class = "app-types"> VOLUNTEER OPPORTUNITIES <div class = "pull-right"><i class="fa fa-chevron-left smallerIcon"> <i class="fa fa-chevron-right smallerIcon"></i></i></div></h1>

                <h3 class = "position-title">ANIMAL CARE</h3>
                <p class = "app-text">
                    Animal care volunteers work closely with the rehabilitation staff as they perform daily tasks including meal preparation and daily feeding/watering; monitoring progress of patients; recording weights and food intake; cage set-up and maintaining proper environment; daily exercise of raptor patients; assisting staff with capture and restraint of patients; hand-feeding orphaned birds; cleaning, hosing, and scrubbing pens of all animals housed in indoor and outdoor enclosures; and general cleaning including sweeping/mopping floors, washing dishes, disinfecting counters/sinks. Pre-exposure rabies vaccination is required to work with all juvenile and adult mammals. Responsibilities increase with experience and demonstrated commitment.
                </p>

                <p class = "app-text">
                    <strong> Requirements:</strong> Animal care volunteers must be at least 18 years of age and able to commit to a minimum of one shift per week for either six months or one year. Shifts run from 8:00 a.m. to 1:00 p.m., seven days per week. Space is limited to one volunteer per shift.
                </p>

                <p class = "app-text">
                    <strong>Availability and application:</strong> The rehabilitation department currently has a limited number of open volunteer positions. Please complete the Animal Care Volunteer application for consideration.
                </p>




            </div><!-- end of col -->
        </div> <!--END OF TEXT DESCRIPTION -->


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
                    <p>... do we want a modal here? no se </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button type="button" class="btn-edit-form" >CHECK IN</button>
                </div>
            </div>
        </div>
    </div>


<!-- thank you for applying! -->
    <div class="modal fade" id="thankApply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="checkInTitle">Thank you for applying! You will recieve an email about your applicaiton status when updated by an admin.</h3>
                    <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

