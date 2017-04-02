<?php

session_start();

require 'databasePDO.php';
require 'database.php';

if(isset($_SESSION['AccountID'])){


    $records = $connPDO->prepare('SELECT AccountID,email,password FROM Account WHERE AccountID = :AccountID');
    $records->bindParam(':AccountID', $_SESSION['AccountID']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if(count($results) > 0){
        $user = $results;
    }

}

?>


<?php
$records = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber FROM Person where AccountID = :AccountID');
$records->bindParam(':AccountID', $_SESSION['AccountID']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0){
    $personInformation = $results;
}

$VolunteerName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];
$VolunteerPhoneNumber = $personInformation['PhoneNumber'];
$VolunteerEmail = $user['email'];
$PersonID = $personInformation['PersonID'];


$records = $connPDO->prepare('select EmergencyContact.FirstName, EmergencyContact.MiddleInitial, EmergencyContact.LastName, EmergencyContact.PhoneNumber, EmergencyContact.Relationship from EmergencyContact join Person on EmergencyContact.EmergencyContactID = Person.EmergencyContactID where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0) {
    $emergencyContact = $results;
}

$EmergencyContactName = $emergencyContact['FirstName'] . " " . $emergencyContact['MiddleInitial'] . " " . $emergencyContact['LastName'];
$EmergencyContactFirstName = $emergencyContact['FirstName'];
$EmergencyContactMI = $emergencyContact['MiddleInitial'];
$EmergencyContactLastName = $emergencyContact['LastName'];
$EmergencyContactPhoneNumber = $emergencyContact['PhoneNumber'];
$EmergencyContactRelationship = $emergencyContact['Relationship'];


$records = $connPDO->prepare('select Volunteer.YTDHours, Volunteer.YTDMiles, Volunteer.Notes from Volunteer where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0) {
    $volunteerInformation = $results;
}

$volunteerYTDHours = $volunteerInformation['YTDHours'];
$volunteerYTDMiles = $volunteerInformation['YTDMiles'];
$volunteerNotes = $volunteerInformation['Notes'];



$sqlSunday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =1;";
$resultsSunday = mysqli_query($conn, $sqlSunday);

$sqlMonday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =2;";
$resultsMonday = mysqli_query($conn, $sqlMonday);


$sqlTuesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =3;";
$resultsTuesday = mysqli_query($conn, $sqlTuesday);

$sqlWednesday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =4;";
$resultsWednesday = mysqli_query($conn, $sqlWednesday);

$sqlThursday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =5;";
$resultsThursday = mysqli_query($conn, $sqlThursday);

$sqlFriday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =6;";
$resultsFriday = mysqli_query($conn, $sqlFriday);

$sqlSaturday = "select Availability.AvailableShift from Availability Join Person ON Person.PersonID = Availability.PersonID
JOIN Day ON Availability.DayID = Day.DayID where Availability.PersonID = $PersonID AND Availability.DayID =7;";
$resultsSaturday = mysqli_query($conn, $sqlSaturday);


?>

<?php
 if (isset ($_POST['UpdateProfile'])) {

     //$sqlUpdateEmergencyContactInformation = "UPDATE EmergencyContact SET FirstName = @FirstName, MiddleInitial = @MiddleInitial, LastName = @LastName, PhoneNumber = @PhoneNumber, Relationship = @Relationship join Person on EmergencyContact.EmergencyContactID = Person.EmergencyContactID where PersonID = :PersonID"





 }








?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | User Profile</title>

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

                <li class = "active">
                    <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li>
                    <a href="#"><i class="fa fa-clipboard"></i> <span class="nav-label">Applications</span></a>
                </li>

            </ul>
        </div>


    </nav> <!-- end of navigation -->


    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>


                </div>
                <?php if( !empty($user) ): ?>
                    <br /><p>Welcome <?= $VolunteerName; ?>
                    <!--                  <br /> you are logged in.</p>-->
                    <!--                 <a href="logout.php">Logout</a>-->
                <?php else: ?>
                    <br /><p>Not logged in.</p>
                <?php endif; ?>
                <ul class="nav navbar-top-links navbar-right">

                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper-prof border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <img src="img/profileheader.jpg" class="img-responsive">
            </div>

        </div>
        <div class="wrapper-prof wrapper-content-prof">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div>
                            <div class="ibox-content">
                                <div class="profile">
                                    <img src="img/profilepic.png" class="img-responsive col-xs-8">
                                </div>
                                <div class="col-xs-1">
                                    <div class="edit">
                                        <!-- Button trigger modal -->

                                        <a href="#" data-toggle="modal" data-target="#profilePicture"><i class="fa fa-pencil edit"></i></a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="profilePicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title pull-left" >Change Profile Picture</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body btmSpace">

                                                        <div class="fileinput fileinput-new pull-left moveDown" data-provides="fileinput">
                                                            <span class="btn btn-default btn-file"><input type="file"></span>
                                                            <span class="fileinput-filename"></span>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                        <button type="button" class="btn-edit-form">UPLOAD</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="ibox-content profile-content">
                                <!-- trigger modal pencil icon -->
                                <a href="#" data-toggle = "modal" data-target = "#myModal"><i class="fa fa-pencil edit pull-right moveDown"></i></a>

                                <!-- modal content aka FORM THAT POPS OPEN ON CLICK OF PENCIL -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title-2 no-margin" id="myModalLabel">Edit Profile Information</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form  class = "pop-up-form" action="/action_page.php">
                                                    <h2 class = "form-title"> PERSONAL INFORMATION </h2>
                                                    <label>Phone:</label> <input type = "text" name = "updateVolunteerPhoneNumber" size = "12" value = <?php echo $VolunteerPhoneNumber ?>><br>
                                                    <label>Email:</label> <input type = "email" name ="updateVolunteerEmail" value = <?php echo $VolunteerEmail ?>><br>
                                                    Personal Notes:<br><textarea rows="4" cols="50" name = "updateVolunteerNotes" value = <?php echo $volunteerNotes ?>> </textarea>
                                                    <hr class = "pop-up-form">
                                                    <h2 class = "form-title">EMERGENCY CONTACT INFO
                                                    </h2>

                                                    <div style="float:left;margin-right:20px;">
                                                        <label class = "label-top" for="name">First Name:</label>
                                                        <input class = "label-top" id="emergencyname" type="text" name="updateEmergencyContactFirstName" value=<?php echo $EmergencyContactFirstName ?>>
                                                    </div>
                                                    <div style="float:left;margin-right:20px;">
                                                        <label class = "label-top" for="name">Middle Initial:</label>
                                                        <input class = "label-top" id="name" type="text" name="updateEmergencyContactMiddleInitial" size="1" maxlength="1" value=<?php echo $EmergencyContactMI ?> >
                                                    </div>
                                                    <div style="float:left;margin-right:20px;">
                                                        <label class = "label-top" for="name">Last Name:</label>
                                                        <input class = "label-top" id="name" type="text" name="updateEmergencyContactLastName" value= <?php echo $EmergencyContactLastName ?>><br>
                                                    </div>
                                                    <div class = "label-top">
                                                        <label class = "modal-label">Phone:</label> <input type = "text" name = "updateEmergencyContactPhoneNumber" size = "12" value = <?php echo $EmergencyContactPhoneNumber ?>><br>
                                                    </div>
                                                    <div>
                                                        <label class = "modal-label">Relationship:</label> <input type = "text" name = "updateEmergencyContactRelationship" value = <?php echo $EmergencyContactRelationship ?>><br>
                                                    </div>
                                                    <div>
                                                        <hr class = "pop-up-form">
                                                    </div>

                                                    <h2 class = "form-title"> AVAILABILITY</h2>
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td class = "avail_space table-date-title"> SUNDAY </td>
                                                            <td class = "avail_space" >
                                                                <input type="checkbox" name="sun_avail_morn" value="sun_avail_morn"> Morning</td>
                                                            <td class = "avail_space">   <input type="checkbox" name="sun_avail_aft" value="sun_avail_aft"> Afternoon  </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="sun_avail_eve" value="sun_avail_eve"> Evening  </td>
                                                        </tr>

                                                        <tr>
                                                            <td class = "avail_space table-date-title"> MONDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="mon_avail_morn" value="mon_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="mon_avail_aft" value="mon_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="mon_avail_eve" value="mon_avail_eve"> Evening</td> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class = "avail_space table-date-title"> TUESDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="tues_avail_morn" value="tues_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="tues_avail_aft" value="tues_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="tues_avail_eve" value="tues_avail_eve"> Evening</td> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class = "avail_space table-date-title"> WEDNESDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="wed_avail_morn" value="wed_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="wed_avail_aft" value="wed_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="wed_avail_eve" value="wed_avail_eve"> Evening</td> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class = "avail_space table-date-title"> THURSDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="thurs_avail_morn" value="thurs_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="thurs_avail_aft" value="thurs_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="thurs_avail_eve" value="thurs_avail_eve"> Evening</td> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class = "avail_space table-date-title"> FRIDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="fri_avail_morn" value="fri_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="fri_avail_aft" value="fri_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="fri_avail_eve" value="fri_avail_eve"> Evening</td> </td>
                                                        </tr>


                                                        <tr>
                                                            <td class = "avail_space table-date-title"> SATURDAY </td>
                                                            <td class = "avail_space">  <input type="checkbox" name="sat_avail_morn" value="sat_avail_morn"> Morning</td> </td>
                                                            <td class = "avail_space"> <input type="checkbox" name="sat_avail_aft" value="sat_avail_aft"> Afternoon</td> </td>
                                                            <td class = "avail_space"><input type="checkbox" name="sat_avail_eve" value="sat_avail_eve"> Evening</td> </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>


                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                <button type="button" name = "UpdateProfile" class="btn-edit-form">SAVE CHANGES</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- continue profile content -->
                                <h2><?php echo $VolunteerName ?></h2>
                                <h4>Volunteer</h4>
                                <p><?php echo $VolunteerPhoneNumber ?><br/>
                                    <em><?php echo $VolunteerEmail ?></em></p>
                                <hr/>

                                <h4>Emergency Contact</h4>

                                <p class="emergency"><?php echo $EmergencyContactName ?><br/>
                                    <?php echo $EmergencyContactPhoneNumber ?><br/>
                                    <em><?php echo $EmergencyContactRelationship ?></em></p>
                                <p>
                                    <?php echo $volunteerNotes ?>
                                <hr>
                                <h4>Availability</h4>
                                <div class="col-sm-4">
                                    <table class = "ibox-content">
                                        <tbody >
                                        <tr>
                                            <td class = "avail_space table-date-title"> SUN. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsSunday)) {
                                                $sundayShift = $row['AvailableShift']; ?>
                                            <td class = "avail_space"> <?php echo $sundayShift ?> <?php }?></td>

                                        </tr>

                                        <tr>
                                            <td class = "avail_space table-date-title"> MON. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsMonday)) {
                                                $mondayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space"> <?php echo $mondayShift ?> <?php }?></td>

                                        </tr>

                                        <tr>
                                            <td class = "avail_space table-date-title"> TUES. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsTuesday)) {
                                                $tuesdayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space"> <?php echo $tuesdayShift ?> <?php }?></td> </td>

                                        </tr>

                                        <tr>
                                            <td class = "avail_space table-date-title"> WED. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsWednesday)) {
                                                $wednesdayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space"> <?php echo $wednesdayShift ?> <?php }?></td> </td>

                                        </tr>

                                        <tr>
                                            <td class = "avail_space table-date-title"> THURS. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsThursday)) {
                                                $thursdayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space">  <?php echo $thursdayShift ?> <?php }?></td> </td>

                                        </tr>

                                        <tr>
                                            <td class = "avail_space table-date-title"> FRI. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsFriday)) {
                                                $fridayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space"> <?php echo $fridayShift ?> <?php }?></td> </td>

                                        </tr>


                                        <tr>
                                            <td class = "avail_space table-date-title"> SAT. </td>
                                            <?php
                                            while($row = mysqli_fetch_array($resultsSaturday)) {
                                                $saturdayShift = $row['AvailableShift']; ?>

                                            <td class = "avail_space"> <?php echo $saturdayShift ?> <?php }?></td> </td>

                                        </tr>

                                        </tbody>
                                    </table>

                                </div>


                                <div class="user-button">
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <div class=grayback>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                    </div>
                    <div class="counters">
                        <div class="col-md-6">
                            <div class="hours">
                                <h3>YOU HAVE WORKED</h3>
                                <h1><?php echo $volunteerYTDHours ?></h1>
                                <h3>HOURS</h3>
                            </div>
                        </div>
                    </div>
                    <div class="counters">
                        <div class="col-md-6">
                            <div class="miles">
                                <h3>YOU HAVE DRIVEN</h3>
                                <h1><?php echo $volunteerYTDMiles ?></h1>
                                <h3>MILES</h3>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="docspadding">
                            <div class="col-md-12">
                                <div class="feed-activity-list">
                                    <div class="col-md-8">
                                        <div class="col-md-2">
                                            <h1>2</h1>
                                        </div><!-- end of col-md-2-->

                                        <div class="col-md-6">
                                            <h3>Teams</h3>
                                        </div>

                                    </div><!-- end of col-md-8-->

                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo"><i class="fa fa-angle-down"></i></button>
                                    </div>
                                    <div class="col-md-5">
                                    </div>

                                    <div id="demo" class="collapse">
                                        <div class="col-md-12">
                                            <h4>Outreach</h4>
                                            <p class="emergency">Raina Krasner<br/>
                                                <em>Rkrasner@wildlifecenter.org</em></p>

                                            <h4>Veterinary</h4>
                                            <p class="emergency">Leigh-Ann Horne<br/>
                                                <em>Lhorne@wildlifecenter.org</em></p>
                                        </div>
                                    </div><!-- end of id = demo collapse -->
                                </div>
                            </div><!-- end of row -->

                            <div class="col-md-12">
                                <div class="feed-activity-list">
                                    <div class="col-md-8">
                                        <div class="col-md-3">
                                            <h1>10</h1>
                                        </div>

                                        <div class="col-md-6">
                                            <h3>Certifications</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info2" data-toggle="collapse" data-target="#demo2"><i class="fa fa-angle-down"></i></button>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                    <div id="demo2" class="collapse">
                                        <div class="col-md-12">
                                            <h4>Outreach</h4>
                                            <p class="emergency">Raina Krasner<br/>
                                                <em>Rkrasner@wildlifecenter.org</em></p>

                                            <h4>Veterinary</h4>
                                            <p class="emergency">Leigh-Ann Horne<br/>
                                                <em>Lhorne@wildlifecenter.org</em></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="docs">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="docspadding">
                                        <img src="img/doc.jpg" class="img-responsive">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

</div>





<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity -->
<script src="js/demo/peity-demo.js"></script>

</body>

</html>