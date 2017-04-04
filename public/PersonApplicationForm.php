<?php
session_start();

include("Classes/Application.php"); ?>
<?php include("Classes/Application_AnimalCare.php"); ?>
<?php include("Classes/Application_Outreach.php"); ?>
<?php include("Classes/Application_Transport.php"); ?>
<?php include("Classes/Application_TreatmentTeam.php"); ?>

<?php
require 'databasePDO.php';
require 'functions.php';

/**
 * Created by PhpStorm.
 * User: ShanikaWije, mandelja, eddiebreyes
 * Date: 3/31/2017
 * Time: 10:17PM
 */

$server = "127.0.0.1";
$username = "homestead";
$password = "secret";
$database = "wildlifeDB";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error)
{
    die("Error: Connection failed!\n" . $conn->connect_error);
}
else
{
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

mysqli_close($conn);

?>



<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply To A Team</title>


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
            <div class="smallerheader"><h1>Apply To A Team</h1>
                <p class="smallheader">Thank you for your interest in The Wildlife Center of Virginia. We have four volunteer teams that work at our organization– outreach, animal care, vet treatment, and transport and rescue. To read more about each team please visit our our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>

            <!-- <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm" method="post" action="PersonApplicationForm.php">
                    <div class = "col-md-6 col-md-offset-3">

                        <label>Please check if you have the following skills: </label>
                    </div> <!--end of label -->

                  <!--  <div class = "col-md-6 col-md-offset-3">
                        <fieldset>
                            <label><input type = "checkbox" name = "skills[]" value = "Carpentry Skills">Carpentry Skills</label>
                            <label><input type = "checkbox" name = "skills[]" value = "Administrative Assistant">Administrative Assistant</label>
                            <label><input type = "checkbox" name = "skills[]" value = "Front Desk Trained">Front Desk Trained </label>
                        </fieldset>
                    </div> -->

                     <!--end of skills checkboxes -->

                    <div class="col-md-6 col-md-offset-3 moveDown"><label>Which team are you interested in applying for?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                <option value="PersonApplicationForm.php"></option>
                                <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                <option value="PersonApplicationForm_Transport.php">Transport</option>
                                <option value="PersonApplicationForm_TreatmentTeam.php">Treatment</option>
                            </select>
                        </div></div>
<!--
                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Why are you interested in volunteering as an outreach docent?</label> <textarea name="ExplainInterest" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>What's an environmental or wildlife issue you feel passionately about, and why?</label> <textarea name="PassionateIssue" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Do you have prior experience speaking to the public? Please describe.</label> <textarea name="PublicSpeakingExperience" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Do you belong to any animal rights groups (PETA, The Humane Society, etc.)? If so, which ones?</label> <textarea name="AnimalRightsGroups" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>What do you think you'd bring to the outreach volunteer team?</label> <textarea name="YourContribution" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button class="btn btn-sm btn-primary pull-right" name="SubmitPersonApplicationForm" type="submit"><strong>Submit</strong></button>
                    </div>
-->
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
