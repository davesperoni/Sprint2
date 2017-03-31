<?php
session_start();

include("Classes/Application.php"); ?>
<?php include("Classes/Application_Outreach.php"); ?>

<?php
require 'databasePDO.php';
require 'functions.php';

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 3/24/2017
 * Time: 12:34 PM
 */

if (isset($_POST['SubmitPersonApplicationForm'])) {

    //maybe replace this with code that points to a completly different page where it shows app pending
     header("Location: /applicant_dashboard.php");

    //Changes current account to 'applied' so that it can show 'application pending' rather than 'apply'
    $currentUser = $_SESSION['AccountID'];
    applicantNowPending($currentUser);
    echo 'applicant is now pending';

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

$ApplicationDepartmentID = $_POST['team'];
if ($ApplicationDepartmentID === "outreach")
{
    $ApplicationDepartmentID = 1;
}
else if ($ApplicationDepartmentID === "Animal Care")
    {
        $ApplicationDepartmentID = 2;
    }
else if ($ApplicationDepartmentID === "Vet Team")
{
    $ApplicationDepartmentID = 3;
}
else if ($ApplicationDepartmentID === "Transport Team")
{
    $ApplicationDepartmentID = 4;
}
    mysqli_close($conn);
?>



<?php
    $currentUser = $_SESSION['AccountID'];

    $sql = "SELECT PersonID from Person WHERE AccountID = :AccountID;";
    $stmt = $connPDO->prepare($sql);
    $stmt->bindParam(':AccountID', $currentUser);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0){

        $person = $results;
    }
    $ApplicationPersonID = $person['PersonID'];




    // var_dump($results) ;


    $ApplicationStatus = "Pending";

$ApplicationCarpentrySkills = "no";
$ApplicationAdminAssistant = "no";
$ApplicationFrontDeskTrained = "no";

    if(!empty($_POST['skills']))
    {
        foreach($_POST['skills'] as $skills)
        {
            if ($skills === "Carpentry Skills")
            {
                $ApplicationCarpentrySkills = "yes";
            }
            else if ($skills === "Front Desk Trained")
            {
                $ApplicationFrontDeskTrained = "yes";
            }
            else if ($skills === "Administrative Assistant")
            {
                $ApplicationAdminAssistant = "yes";
            }
        }
    }


$newApplication = new Application($ApplicationPersonID, $ApplicationStatus, $ApplicationDepartmentID, $ApplicationCarpentrySkills, $ApplicationFrontDeskTrained, $ApplicationAdminAssistant);

$ApplicationPersonID = $newApplication->getApplicationPersonID();
$ApplicationStatus = $newApplication->getApplicationStatus();
$ApplicationDepartmentID = $newApplication->getApplicationDepartmentID();
$ApplicationCarpentrySkills = $newApplication->getApplicationCarpentrySkills();
$ApplicationFrontDeskTrained = $newApplication->getApplicationFrontDeskTrained();
$ApplicationAdminAssistant = $newApplication->getApplicationAdminAssistant();
$ApplicationLastUpdatedBy = $newApplication->getApplicationLastUpdatedBy();
$ApplicationLastUpdated = $newApplication->getApplicationLastUpdated();

$sqlApplication = "INSERT INTO Application (PersonID, DepartmentID, ApplicationStatus, CarpentrySkills, FrontDeskTrained, AdminAssistant, LastUpdatedBy, LastUpdated) VALUES ('$ApplicationPersonID', '$ApplicationDepartmentID', '$ApplicationStatus', '$ApplicationCarpentrySkills', '$ApplicationFrontDeskTrained','$ApplicationAdminAssistant', '$ApplicationLastUpdatedBy', $ApplicationLastUpdated)";

    $stmt = mysqli_prepare($conn, $sqlApplication);

    if($stmt) {
        $stmt->execute();
    }
    echo "Application added to database!";

    $ApplicationID = $conn->insert_id;

    echo "New record created successfully. Last inserted ID is: " . $ApplicationID;

    if ($ApplicationDepartmentID === 1)
    {
        $ApplicationExplainInterest = $_POST['ExplainInterest'];
        $ApplicationPassionateIssue = $_POST['PassionateIssue'];
        $ApplicationPublicSpeakingExperience = $_POST['PublicSpeakingExperience'];
        $ApplicationAnimalRightsGroups = $_POST['AnimalRightsGroups'];
        $ApplicationYourContribution = $_POST['YourContribution'];

        $newOutreachApplication = new Application_Outreach($ApplicationExplainInterest, $ApplicationPassionateIssue, $ApplicationPublicSpeakingExperience, $ApplicationAnimalRightsGroups, $ApplicationYourContribution);

        $ApplicationExplainInterest = $newOutreachApplication->getApplicantExplainInterest();
        $ApplicationPassionateIssue = $newOutreachApplication->getApplicantPassionateIssue();
        $ApplicationPublicSpeakingExperience = $newOutreachApplication->getApplicantPublicSpeakingExperience();
        $ApplicationAnimalRightsGroups = $newOutreachApplication->getApplicantAnimalRightsGroups();
        $ApplicationYourContribution = $newOutreachApplication->getApplicantYourContribution();
        $ApplicationOutreachLastUpdatedBy = $newOutreachApplication->getApplicantLastUpdatedBy();
        $ApplicationOutreachLastUpdated = $newOutreachApplication->getApplicantLastUpdated();

        $sqlOutreachApplication = "INSERT INTO ApplicationOutreach (ApplicationID, ExplainInterest, PassionateIssue, PublicSpeakingExperience, AnimalRightsGroups, YourContribution, LastUpdatedBy, LastUpdated) VALUES ('$ApplicationID', '$ApplicationExplainInterest', '$ApplicationPassionateIssue','$ApplicationPublicSpeakingExperience', '$ApplicationAnimalRightsGroups', '$ApplicationYourContribution', '$ApplicationOutreachLastUpdatedBy', $ApplicationOutreachLastUpdated)";

        $stmt = mysqli_prepare($conn, $sqlOutreachApplication);

        if($stmt) {
            $stmt->execute();


        }
        echo "Outreach Application added to database";
    }
}
?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply for A Team</title>


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
            <div class="smallerheader"><h1>Apply For A Team</h1>
                <p class="smallheader">Thank you for your interest in The Wildlife Center of Virginia. We gave four volunteer teams that work at our organization– outreach, animal care, vet treatment, and transport and rescue. To read more about each team please visit our our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>

            <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm" method="post" action="PersonApplicationForm.php">

                    <div class = "col-md-6 col-md-offset-3">

                        <label>Please check if you have the following skills: </label>
                    </div><!--end of label-->
                    <div class = "col-md-6 col-md-offset-3">
                        <fieldset>
                            <label><input type = "checkbox" name = "skills[]" value = "Carpentry Skills">Carpentry Skills</label>
                            <label><input type = "checkbox" name = "skills[]" value = "Administrative Assistant">Administrative Assistant</label>
                            <label><input type = "checkbox" name = "skills[]" value = "Front Desk Trained">Front Desk Trained </label>
                        </fieldset>
                    </div><!-- end of skills checkboxes -->


                    <div class="col-md-6 col-md-offset-3 moveDown"><label>Which team are you interested in applying for?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="team">
                                <option value="outreach">Outreach</option>
                                <option value="animal">Animal Care</option>
                                <option value="vet">Vet Team</option>
                                <option value="transport">Transport Team</option>
                            </select>
                        </div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Why are you interested in volunteering as an outreach docent?</label> <textarea name="ExplainInterest" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>What's an environmental or wildlife issue you feel passionately about, and why?</label> <textarea name="PassionateIssue" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Do you have prior experience speaking to the public? Please describe.</label> <textarea name="PublicSpeakingExperience" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Do you belong to any animal rights groups (PETA, The Humane Society, etc.)? If so, which ones?</label> <textarea name="AnimalRightsGroups" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>What do you think you'd bring to the outreach volunteer team?</label> <textarea name="YourContribution" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button class="btn btn-sm btn-primary pull-right" name="SubmitPersonApplicationForm" type="submit"><strong>Submit</strong></button>              </div>

                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
