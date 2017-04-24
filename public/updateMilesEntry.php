<?php
/**
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 4/11/17
 * Time: 3:00 AM
 */

session_start();
require 'database.php';
require 'databasePDO.php';
include ("Classes/Mileage.php");

$TripID = $_GET['id'];

$sql = $connPDO->prepare('Select Volunteer.VolunteerID from Volunteer JOIN Person ON Person.PersonID = Volunteer.PersonID JOIN Account ON Person.AccountID = Account.AccountID where Account.AccountID = :AccountID');
$sql->bindParam(':AccountID', $_SESSION['AccountID']);
$sql->execute();
$volunteerResult = $sql->fetch(PDO::FETCH_ASSOC);

$volunteerID= $volunteerResult['VolunteerID'];

if (isset($_POST['submitMilesUpdate']))
{
    header("Location: /loghoursandmiles.php");
    $departmentID = 3;
    $tripDate = date('Y-m-d', strtotime($_POST['tripDate']));
    $tripMiles = $_POST['numMiles'];
    $pickUpStreet = $_POST['pickUpStreet'];
    $pickUpCity = $_POST['pickUpCity'];
    $pickUpState = $_POST['pickUpState'];
    $pickUpCounty = $_POST['pickUpCounty'];
    $pickUpZipCode = $_POST['pickUpZipCode'];
    $animalTransported = $_POST['animalTransported'];

    $newMileage = new Mileage($departmentID, $volunteerID, $tripDate, $tripMiles, $pickUpStreet, $pickUpCity, $pickUpState, $pickUpCounty, $pickUpZipCode, $animalTransported);


    $DepartmentID = $newMileage->getMileageDepartmentID();
    $VolunteerID = $newMileage->getMileageVolunteerID();
    $tripDate = $newMileage->getMileageTripDate();
    $tripMiles = $newMileage->getMileageTripMiles();
    $pickUpStreet = $newMileage->getMileageTripStreet();
    $pickUpCity = $newMileage->getMileageTripCity();
    $pickUpState = $newMileage->getMileageTripState();
    $pickUpCounty = $newMileage->getMileageTripCounty();
    $pickUpZipCode = $newMileage->getMileageTripZipCode();
    $animalTransported = $newMileage->getMileageAnimalTransported();
    $tripLastUpdatedBy = $newMileage->getMileageLastUpdatedBy();

   // var_dump($tripDate, $tripMiles, $pickUpStreet, $pickUpCity, $pickUpState, $pickUpCounty, $pickUpZipCode, $animalTransported, $TripID);

    $sqlUpdateMileage = "UPDATE Mileage SET TripDate = :tripDate, TripMiles = :tripMiles, 
PickUpStreet = :pickUpStreet, PickUpCity = :pickUpCity, PickUpState = :pickUpState, 
PickUpCountyName = :pickUpCountyName,
PickUpZipCode = :pickUpZipCode, AnimalTransported = :animalTransported, LastUpdated = CURRENT_TIMESTAMP where TripID = :TripID;";
    $stmt = $connPDO->prepare($sqlUpdateMileage);

    var_dump($sqlUpdateMileage);


    $stmt->bindParam(':tripDate', $tripDate);
    $stmt->bindParam(':tripMiles', $tripMiles);
    $stmt->bindParam(':pickUpStreet', $pickUpStreet);
    $stmt->bindParam(':pickUpCity', $pickUpCity);
    $stmt->bindParam(':pickUpState', $pickUpState);
    $stmt->bindParam(':pickUpCountyName', $pickUpCounty);
    $stmt->bindParam(':pickUpZipCode', $pickUpZipCode);
    $stmt->bindParam(':animalTransported', $animalTransported);
    $stmt->bindParam(':TripID', $TripID);

    $stmt->execute();

	header("Location: /loghoursandmiles.php");


}




$sqlShowMiles = "Select Mileage.TripID AS 'TripID', Mileage.TripDate AS 'TripDate', Mileage.TripMiles AS 'TripMiles', 
Mileage.PickUpStreet AS 'Street', Mileage.PickUpCity AS 'City', Mileage.PickUpState AS 'State', 
Mileage.PickUpCountyName AS 'County', Mileage.PickUpZipCode AS 'Zip', Mileage.AnimalTransported AS 'Animal' 
from Mileage JOIN Volunteer ON Volunteer.VolunteerID = Mileage.VolunteerID WHERE Mileage.TripID = $TripID;";

$resultMiles = mysqli_query($conn, $sqlShowMiles) or die("Error " . mysqli_error($conn));

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
    <form name="UpdateMilesEntry" method="post">
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


        <!-- start thing -->
        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">
                <h3 class="equalSpaceForm"> UPDATE MILES</h3>
                <div class = "col-sm-3">
                    <label class = "pull-left" for="name">Date</label>
                </div>

                <div class = "col-sm-3">
                    <div class="bfh-timepicker" data-mode="12h"></div>
                    <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">
                        <input type="text" class="input-sm form-control place-inline pull-left" name="tripDate" value="<?php echo $TripDate?>"/>
                    </div>
                </div>

                <div class = "col-sm-3">
                    <label>Animal Transported</label>
                </div>

                <div class = "col-sm-3">
                    <input type="text" name="animalTransported" value="<?php echo $TripAnimal ?>" size="15">
                </div>
            </div><!-- end of container col -->
        </div><!-- end of row 1 -->

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">
                    <label>Miles Driven</label>
                </div>

                <div class = "col-sm-3">
                    <input type="text" name="numMiles" value="<?php echo $TripMiles ?>" size="5">
                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 2 -->

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">
                    <label>Pick Up Address</label>
                </div>

                <div class = "col-sm-3">
                    <input type="text" name="pickUpStreet" value="<?php echo $TripStreet ?>" size = "30">
                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 3 -->

        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">

                </div>

                <div class = "col-sm-3">
                    <label>City</label>
                    <input type="text" name="pickUpCity" value="<?php echo $TripCity ?>" size = "20">
                </div>
                <div class = "col-sm-3">
                    <label class = "moveSelectDown">State</label>
                    <select name="pickUpState">
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

                </div>

            </div><!-- end of container col -->
        </div><!-- end of row 4 -->


        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">

                <div class = "col-sm-3">

                </div>

                <div class = "col-sm-3">
                    <label>Zip Code</label>
                    <input type="text" name="pickUpZipCode" value="<?php echo $TripZipCode ?>" size = "20">
                </div>
                <div class = "col-sm-3">
                    <label class = "moveSelectDown">County</label>
                    <select name="pickUpCounty">
                        <option><?php echo $TripCounty ?></option>
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

                </div>

            </div><!-- end of container col -->

        </div><!-- end of row 5 -->


        <?php } ?>
        <div class = "row equalSpaceForm">
            <div class = "col-sm-10 col-sm-offset-1">


                <div class = "col-sm-5 ">
                    <a type="submit" href="/loghoursandmiles.php" class="btn btn-default">CANCEL</a>
                    <button type="submit" name="submitMilesUpdate" class="btn btn-default orangeButton">UPDATE</button>

                </div>


            </div><!-- end of container col -->
        </div>
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
</body>
</html>

