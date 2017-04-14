
<?php
session_start();

require 'databasePDO.php';
require 'database.php';
require 'functions.php';

/**
 * Created by PhpStorm.
 * User: David Speroni, Jenny Mandel
 * Date: 4/11/2017
 * Time: 11:30 PM
 */

$currentUser = $_SESSION['AccountID'];

if(isApplicant($currentUser)){ ?>
    <script>
        $('#thankApply').modal('show');
    </script>
<?php }

$Date = date("F j, Y");

$records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName FROM Person where AccountID = :AccountID');
$records->bindParam(':AccountID', $_SESSION['AccountID']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0)
{
    $personInformation = $results;
}

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
    <link href="css/slick.css" rel="stylesheet">
    <link href="css/slick-theme.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>

        @font-face
        {
            font-family: 'slick';
            font-weight: normal;
            font-style: normal;

            src: url('fonts/slick.eot');
            src: url('fonts/slick.eot?#iefix') format('embedded-opentype'), url('fonts/slick.woff') format('woff'), url('fonts/slick.ttf') format('truetype'), url('fonts/slick.svg#slick') format('svg');
        }
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
                    <div class="dropdown profile-element">

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Applicant</strong>
                             </span> <span class="text-muted text-xs block dropdown">Contact Us<b class="caret"></b></span> </span> </a>
                        <a href="#"><i class="fa fa-phone"></i> <span class="nav-label text-muted">(540) 942-9453</span></a>
                        <a href="#"><span class="nav-label text-muted">wildlife@wildlifecenter.org</span></a>

                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li class = "active">
                    <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-clipboard"></i> <span class="nav-label">Apply</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-spinner"></i> <span class="nav-label">Application Status</span></a>
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
                        <h1 class = "welcome-user">
                            <?php if( !empty($VolunteerFirstName) ): ?>
                                HELLO <?= strtoupper($VolunteerFirstName); ?>
                            <?php else: ?>
                                HELLO APPLICANT
                            <?php endif; ?> </h1>

                        <!-- Button trigger modal -->
                        <!-- checks whether or not account has applied yet -->

                        <?php if(isApplicant($currentUser)){ ?>
                            <a href="PersonApplicationForm.php" id = "checkIn" data-target = "#thankApply"> APPLY TO ANOTHER DEPARTMENT </a>
                        <?php }
                        else{ ?>
                            <a href="PersonProfileForm.php" id = "checkIn" > APPLY TO BE A VOLUNTEER </a>
                        <?php } ?>


                    </div>
                </header>
            </div>
        </div>


        <!-- NEWWWWWWW  ABOUT THE DIFFERENT VOLUNTEER TYPES -->
        <div class="row moveMore">
            <div class="col-md-10 col-md-offset-1">
                <div class="ibox">


                    <div class="slick_demo_3">
                        <div>
                            <div class="ibox-content">
                                <h1 class = "app-types" style="padding:5px 5px 5px 20px;">VOLUNTEER OPPORTUNITIES</h1>
                                <h3 class = "position-title">ANIMAL CARE</h3>
                                <p class = "app-text">
                                    Animal care volunteers work closely with the rehabilitation staff as they perform daily tasks including meal preparation and daily feeding/watering; monitoring progress of patients; recording weights and food intake; cage set-up and maintaining proper environment; daily exercise of raptor patients; assisting staff with capture and restraint of patients; hand-feeding orphaned birds; cleaning, hosing, and scrubbing pens of all animals housed in indoor and outdoor enclosures; and general cleaning including sweeping/mopping floors, washing dishes, disinfecting counters/sinks. Pre-exposure rabies vaccination is required to work with all juvenile and adult mammals. Responsibilities increase with experience and demonstrated commitment.
                                </p>

                                <p class = "app-text">
                                    <strong>Requirements:</strong> Treatment team volunteers must be must be at least 18 years of age and able to commit to a minimum of one three-hour shift per month for one year. The morning treatment team shift is from 9 am-12 pm, the afternoon shift is from 3 pm-6 pm. Afternoon shifts are not available during the winter months. Space is limited to two volunteers per shift.
                                </p>

                                <p class = "app-text">
                                    <strong>Availability and application:</strong> The rehabilitation department currently has a limited number of open volunteer positions. Please complete the Animal Care Volunteer application for consideration.
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="ibox-content">
                                <h1 class = "app-types" style="padding:5px 5px 5px 20px;">VOLUNTEER OPPORTUNITIES</h1>
                                <h3 class = "position-title">OUTREACH DOCENT</h3>
                                <p class = "app-text">
                                    Outreach docents assist the staff with educating the public about the Center’s mission and the importance of protecting wildlife and the environment. Our outreach programs promote positive attitudes toward wildlife and emphasize how the personal choices we make affect the health of the environment. Outreach volunteers assist with leading on-site programs, including tours, hikes, and open houses for a variety of groups including adults, families, school children, scouts, and clubs.
                                </p>

                                <p class = "app-text">
                                    <strong>Requirements:</strong> Docents must be at least 18 years of age. Docents must be comfortable with speaking in public and able to hike a mile-long trail. There are no set shift requirements; on-site school field trips are usually scheduled for weekday mornings during the spring and fall; open house tours are scheduled on weekend afternoons seasonally.
                                </p>

                                <p class = "app-text" style="margin-bottom:-20px;">
                                    <strong>Availability and application:</strong> The outreach department currently has a limited number of open volunteer positions.
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="ibox-content">
                                <h1 class = "app-types" style="padding:5px 5px 5px 20px;">VOLUNTEER OPPORTUNITIES</h1>
                                <h3 class = "position-title">TREATMENT TEAM</h3>
                                <p class = "app-text">
                                    Treatment team volunteers will have the opportunity to work hands-on with the patients at the Wildlife Center by assisting the veterinary staff with daily medical and diagnostic procedures. Tasks may include patient capture and restraint, weighing, administering medications, positioning patients for radiographs, and some laboratory work. No prior veterinary or animal handling experience is needed; the veterinary staff will provide all the necessary training and supervision. The first day will be spent in an orientation and observing patient care. Pre-exposure rabies vaccination is required to work with all juvenile and adult mammals. Responsibilities increase with experience and demonstrated commitment.
                                </p>

                                <p class = "app-text">
                                    <strong>Requirements:</strong> Treatment team volunteers must be must be at least 18 years of age and able to commit to a minimum of one three-hour shift per month for one year. The morning treatment team shift is from 9 am-12 pm, the afternoon shift is from 3 pm-6 pm. Afternoon shifts are not available during the winter months. Space is limited to two volunteers per shift.
                                </p>

                                <p class = "app-text" style="margin-bottom:-20px;">
                                    <strong> Availability</strong> and application: There are no treatment team positions available at this time.
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="ibox-content">
                                <h1 class = "app-types" style="padding:5px 5px 5px 20px;">VOLUNTEER OPPORTUNITIES</h1>
                                <h3 class = "position-title">TRANSPORT AND RESCUE</h3>
                                <p class = "app-text">
                                    The Wildlife Center receives many calls from members of the public who want to help rescue wildlife, but are unable to transport and/or capture the animal. Volunteer transporters provide a vital, life-saving service to both the Wildlife Center and the community by facilitating the rescue/transport of wild animals. Transport/rescue volunteers may choose to assist with wildlife capture and transport, or may choose to simply provide transport only for an already-captured animal.
                                </p>

                                <p class = "app-text">
                                    <strong> Requirements:</strong> Transporters must have a valid driver’s license and be willing to drive contained, injured or orphaned wild animals to/from the Center in their own vehicle. Transporters must agree to follow the recommended guidelines provided by the Wildlife Center of Virginia.
                                </p>

                                <p class = "app-text lessSpaceBtm">
                                    <strong>Availability and application:</strong>Transporters from all over the state of Virginia are always needed, but especially so in the following areas:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- DISPLAY APPLICANT'S APPLICATIONS -->
        <div class = "row">
            <div class = "col-md-10 col-md-offset-1 moveDown" id = "submittedRow">
                <h1 class = "app-types">SUBMITTED APPLICATIONS</h1>
                <!--Start Table -->
                <div class="pendingapps_table">
                    <table class="table table-striped">
                        <thead class="pendingapps-header"> Thank you for applying to become a volunteer!
                        Applications will be reviewed by a Wildlife Center admin as quickly as possible and your status will be posted here.
                        You will also receive an email notification if there are any updates regarding your application status.
                        If you have any questions, please contact us at (540) 942-9453 or wildlife@wildlifecenter.org.
                        <tr>
                            <th class="pendingapps_header_content">Name</th>
                            <th class="pendingapps_header_content">Department</th>
                            <th class="pendingapps_header_content">Date</th>
                            <th class="pendingapps_header_content">Status</th>
                            <th class="pendingapps_header_content"></th>
                        </tr>
                        </thead>
                        <?php
                        //Display records from the applications table

                        $server = '127.0.0.1';
                        $username = 'homestead';
                        $password = 'secret';
                        $database = 'wildlifeDB';

                        $conn = new mysqli($server, $username, $password, $database);

                        if ($conn->connect_error)
                        {
                            die("Error: Connection failed!\n" . $conn->connect_error);
                        }
                        else
                        {
                        }
                        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                        if(isApplicant($currentUser)) {
                            $sqlShowApps = "SELECT Person.FirstName AS 'FN', Person.MiddleInitial AS 'MI',
                                               Person.LastName AS 'LN', Department.DepartmentName AS 'Dept', 
                                               Application.LastUpdated AS 'AppLastUpdated', Application.ApplicationStatus AS 'Status', 
                                               Application.ApplicationID AS 'AppID'
                                               FROM Person
                                               JOIN Application ON Person.PersonID = Application.PersonID
                                               JOIN Department ON Application.DepartmentID = Department.DepartmentID
                                               WHERE Person.PersonID = $PersonID
                                               ORDER BY Application.LastUpdated;";

                            $result = mysqli_query($conn, $sqlShowApps) or die("Error " . mysqli_error($conn));

                            mysqli_close($conn);

                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <br/>
                                <tbody>
                                <tr>
                                    <?php

                                    $FirstName = $row['FN'];
                                    $MiddleInitial = $row['MI'];
                                    $LastName = $row['LN'];

                                    $ApplicantFullName = ucfirst($FirstName) . " " . ucfirst($MiddleInitial) . " " . ucfirst($LastName);
                                    $DepartmentName = $row['Dept'];
                                    $AppLastUpdated = $row['AppLastUpdated'];
                                    $ApplicationStatus = $row['Status'];

                                    $AppID = $row['AppID'];

                                    $phpdate = strtotime($AppLastUpdated);
                                    $AppLastUpdated = date('m-d-Y', $phpdate);

                                 ?>
                                <td><?php echo $ApplicantFullName ?></td>
                                <td><?php echo $DepartmentName ?></td>
                                <td><?php echo $AppLastUpdated ?></td>
                                <td><?php echo $ApplicationStatus ?></td>
                                <td>
                                    <button onclick="location.href='#'" class="btn btn-sm btn-primary pull-right"
                                            name="ViewPersonApplication" type="submit" class="viewapp">View
                                    </button>
                                </td>
                            </tr>
                        <?php
                            } //END OF WHILE LOOP
                        } //END OF IF STATEMENT
                        ?>

                        </tbody>
                    </table>
                </div>
                <!--END TABLE -->
            </div><!-- END OF COL-->
        </div> <!--END OF APPLICATIONS DISPLAY-->
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

    <!-- slick carousel-->
    <script src="js/slick.min.js"></script>

    <script>
        $(document).ready(function(){



            $('.slick_demo_1').slick({
                dots: true
            });

            $('.slick_demo_2').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.slick_demo_3').slick({
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                adaptiveHeight: true
            });
        });

    </script>



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
                    <h3 class="modal-title" id="checkInTitle">Thank you for applying! You will receive an email about your application status once it has been reviewed.</h3>
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

