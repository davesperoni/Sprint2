<?php
session_start();
include("Classes/Application.php"); ?>
<?php include("Classes/Application_TreatmentTeam.php"); ?>


<?php
require 'databasePDO.php';
require 'functions.php';

/**
 * Created by PhpStorm.
 * User: ShanikaWije, mandelja, eddiebreyes
 * Date: 4/1/2017
 * Time: 7:22PM
 */

if (isset($_POST['SubmitPersonApplicationForm']))
{
    //maybe replace this with code that points to a completely different page where it shows app pending
    header("Location: /applicant_dashboard.php");

    //Changes current account to 'applied' so that it can show 'application pending' rather than 'apply'
    $currentUser = $_SESSION['AccountID'];
    applicantNowPending($currentUser);
    echo 'applicant is now pending';

    //Database connection
    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";
    $conn = new mysqli($server, $username, $password, $database);

    //Test Connection
    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //Set the application departmentID
    $ApplicationDepartmentID = 4;

    mysqli_close($conn);
    ?>



    <?php
    $currentUser = $_SESSION['AccountID'];

    $sql = "SELECT PersonID from Person WHERE AccountID = :AccountID;";
    $stmt = $connPDO->prepare($sql);
    $stmt->bindParam(':AccountID', $currentUser);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0)
    {
        $person = $results;
    }
    $ApplicationPersonID = $person['PersonID'];

    // var_dump($results) ;

    //Set status & checkbox variable values
    $ApplicationStatus = "Pending";
    $ApplicationCarpentrySkills = "no";
    $ApplicationAdminAssistant = "no";
    $ApplicationFrontDeskTrained = "no";

    //Assign variables values based on checkbox selections
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

    //Open connection to the database
    $conn = new mysqli($server, $username, $password, $database);

    //Create a new application
    $newApplication = new Application($ApplicationPersonID, $ApplicationStatus,
        $ApplicationDepartmentID, $ApplicationCarpentrySkills,
        $ApplicationFrontDeskTrained, $ApplicationAdminAssistant);

    $ApplicationPersonID = $newApplication->getApplicationPersonID();
    $ApplicationStatus = $newApplication->getApplicationStatus();
    $ApplicationDepartmentID = $newApplication->getApplicationDepartmentID();
    $ApplicationCarpentrySkills = $newApplication->getApplicationCarpentrySkills();
    $ApplicationFrontDeskTrained = $newApplication->getApplicationFrontDeskTrained();
    $ApplicationAdminAssistant = $newApplication->getApplicationAdminAssistant();
    $ApplicationLastUpdatedBy = $newApplication->getApplicationLastUpdatedBy();
    $ApplicationLastUpdated = $newApplication->getApplicationLastUpdated();

    //Insert the application into the database
    $sqlApplication = "INSERT INTO Application (PersonID, DepartmentID, ApplicationStatus, CarpentrySkills, FrontDeskTrained, AdminAssistant, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_prepare($conn, $sqlApplication);
    $stmt->bind_param("iisssss", $ApplicationPersonID, $ApplicationDepartmentID, $ApplicationStatus,
        $ApplicationCarpentrySkills, $ApplicationFrontDeskTrained, $ApplicationAdminAssistant,
        $ApplicationLastUpdatedBy);

    //Execute the insert statement
    if($stmt)
    {
        $stmt->execute();
    }

    //Show confirmation messages
    echo "Application added to database!";
    $ApplicationID = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $ApplicationID;

    //===Treatment Team Application===
    //Assign values to variables
    $ApplicantHandleSmallMammals = 'no';
    $ApplicantHandleLargeMammals = 'no';
    $ApplicantHandleRVS = 'no';
    $ApplicantHandleEagles = 'no';
    $ApplicantHandleSmallRaptors = 'no';
    $ApplicantHandleLargeRaptors = 'no';
    $ApplicantHandleReptiles = 'no';
    $ApplicantDescribeAnimalTraining = '';
    $ApplicantTrainingVet = 'no';
    $ApplicantTrainingTech = 'no';
    $ApplicantDescribeMedicalTraining = $_POST['DescribeMedicalTraining'];
    $ApplicantPatientMedicate = 'no';
    $ApplicantPatientBandage = 'no';
    $ApplicantPatientWoundCare = 'no';
    $ApplicantPatientDiagnostics = 'no';
    $ApplicantPatientAnesthesia = 'no';
    $ApplicantDescribePatientSkills = '';
    $ApplicantBestWorkEnvironment = $_POST['BestWorkEnvironment'];
    $ApplicantBestLearningMethod = '';
    $ApplicantEuthanasiaExperience = $_POST['EuthanasiaExperience'];
    $ApplicantMessyRequirements = $_POST['MessyRequirements'];

    //Create the application object
    $newTreatmentTeamApplication = new Application_TreatmentTeam($ApplicantHandleSmallMammals, $ApplicantHandleLargeMammals, $ApplicantHandleRVS,
        $ApplicantHandleEagles, $ApplicantHandleSmallRaptors, $ApplicantHandleLargeRaptors,
        $ApplicantHandleReptiles, $ApplicantDescribeAnimalTraining, $ApplicantTrainingVet,
        $ApplicantTrainingTech, $ApplicantDescribeMedicalTraining, $ApplicantPatientMedicate,
        $ApplicantPatientBandage, $ApplicantPatientWoundCare, $ApplicantPatientDiagnostics,
        $ApplicantPatientAnesthesia, $ApplicantDescribePatientSkills, $ApplicantBestWorkEnvironment,
        $ApplicantBestLearningMethod, $ApplicantEuthanasiaExperience, $ApplicantMessyRequirements);

    //Assign values to variables with object getters
    $ApplicantHandleSmallMammals = $newTreatmentTeamApplication->getApplicantHandleSmallMammals();
    $ApplicantHandleLargeMammals = $newTreatmentTeamApplication->getApplicantHandleLargeMammals();
    $ApplicantHandleRVS = $newTreatmentTeamApplication->getApplicantHandleRVS();
    $ApplicantHandleEagles = $newTreatmentTeamApplication->getApplicantHandleEagles();
    $ApplicantHandleSmallRaptors = $newTreatmentTeamApplication->getApplicantHandleSmallRaptors();
    $ApplicantHandleLargeRaptors = $newTreatmentTeamApplication->getApplicantHandleLargeRaptors();
    $ApplicantHandleReptiles = $newTreatmentTeamApplication->getApplicantHandleReptiles();
    $ApplicantDescribeAnimalTraining = $newTreatmentTeamApplication->getApplicantDescribeAnimalTraining();
    $ApplicantTrainingVet = $newTreatmentTeamApplication->getApplicantTrainingVet();
    $ApplicantTrainingTech = $newTreatmentTeamApplication->getApplicantTrainingTech();
    $ApplicantDescribeMedicalTraining = $newTreatmentTeamApplication->getApplicantDescribeMedicalTraining();
    $ApplicantPatientMedicate = $newTreatmentTeamApplication->getApplicantPatientMedicate();
    $ApplicantPatientBandage = $newTreatmentTeamApplication->getApplicantPatientBandage();
    $ApplicantPatientWoundCare = $newTreatmentTeamApplication->getApplicantPatientWoundCare();
    $ApplicantPatientDiagnostics = $newTreatmentTeamApplication->getApplicantPatientDiagnostics();
    $ApplicantPatientAnesthesia = $newTreatmentTeamApplication->getApplicantPatientAnesthesia();
    $ApplicantDescribePatientSkills = $newTreatmentTeamApplication->getApplicantDescribePatientSkills();
    $ApplicantBestWorkEnvironment = $newTreatmentTeamApplication->getApplicantBestWorkEnvironment();
    $ApplicantBestLearningMethod = $newTreatmentTeamApplication->getApplicantBestLearningMethod();
    $ApplicantEuthanasiaExperience = $newTreatmentTeamApplication->getApplicantEuthanasiaExperience();
    $ApplicantMessyRequirements = $newTreatmentTeamApplication->getApplicantMessyRequirements();
    $ApplicationLastUpdatedBy = $newTreatmentTeamApplication->getApplicantLastUpdatedBy();
    $ApplicationLastUpdated = $newTreatmentTeamApplication->getApplicantLastUpdated();

    //Insert statement
    $sqlTreatmentTeamApplication = "INSERT INTO ApplicationTreatmentTeam(ApplicationID,HandleSmallMammals,HandleLargeMammals,HandleRVS,HandleEagles,HandleSmallRaptors,HandleLargeRaptors,HandleReptiles,DescribeAnimalTraining,TrainingVet,TrainingTech,DescribeMedicalTraining,PatientMedicate,PatientBandage,PatientWoundCare,PatientDiagnostics,PatientAnesthesia,DescribePatientSkills,BestWorkEnvironment,BestLearningMethod,EuthanasiaExperience,MessyRequirements,LastUpdatedBy,LastUpdated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP);";

    $stmt = mysqli_prepare($conn, $sqlTreatmentTeamApplication);
    $stmt->bind_param("issssssssssssssssssssss", $ApplicationID,
        $ApplicantHandleSmallMammals, $ApplicantHandleLargeMammals, $ApplicantHandleRVS,
        $ApplicantHandleEagles, $ApplicantHandleSmallRaptors, $ApplicantHandleLargeRaptors,
        $ApplicantHandleReptiles, $ApplicantDescribeAnimalTraining, $ApplicantTrainingVet,
        $ApplicantTrainingTech, $ApplicantDescribeMedicalTraining, $ApplicantPatientMedicate,
        $ApplicantPatientBandage, $ApplicantPatientWoundCare, $ApplicantPatientDiagnostics,
        $ApplicantPatientAnesthesia, $ApplicantDescribePatientSkills, $ApplicantBestWorkEnvironment,
        $ApplicantBestLearningMethod, $ApplicantEuthanasiaExperience, $ApplicantMessyRequirements,
        $ApplicationLastUpdatedBy);

    //Execute insert statement
    if($stmt)
    {
        $stmt->execute();
    }

    echo "Treatment Team Application added to database";

}
?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply To The Treatment Team</title>


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
            <div class="smallerheader"><h1>Apply To The Treatment Team</h1>
                <p class="smallheader">Thank you for your interest in The Wildlife Center of Virginia. We gave four volunteer teams that work at our organization– outreach, animal care, vet treatment, and transport and rescue. To read more about each team please visit our our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>

            <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm_TreatmentTeam" method="post" action="PersonApplicationForm_TreatmentTeam.php">
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

                    <div class="col-md-6 col-md-offset-3"><label>Which team are you interested in applying for?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                <option value="PersonApplicationForm_TreatmentTeam.php">Treatment</option>
                                <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                <option value="PersonApplicationForm_Transport.php">Transport</option>
                            </select>
                        </div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Please describe any previous medical or veterinary training you have completed.</label> <textarea name="DescribeMedicalTraining" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>The case load at the Center can be unpredictable and vary greatly depending on the time of year.  Please describe the work environment that you work best in including how you best retain information that is taught to you.</label> <textarea name="BestWorkEnvironment" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>The Center admits many trauma cases from all over the state.  In order for a patient to be released back into the wild it must be able to successfully survive on its own in the wild free of chronic pain or debilitation.  Due to this fact, the Center does humanely euthanize patients that do not meet this standard.  Do you have personal experience with euthanasia and how does it affect you?</label> <textarea name="EuthanasiaExperience" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Taking care of animals is a messy job that requires all team members to clean out dirty crates, chop rats or mice for feeding to patients, and collect fecal samples for analysis for example.  Is this something that you foresee struggling with?</label> <textarea name="MessyRequirements" rows="4" class="form-control"></textarea></div></div>

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

