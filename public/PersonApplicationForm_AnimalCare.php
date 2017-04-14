<?php
session_start();
include("Classes/Application.php"); ?>
<?php include("Classes/Application_AnimalCare.php"); ?>


<?php
require 'databasePDO.php';
require 'functions.php';

/**
 * Created by PhpStorm.
 * User: ShanikaWije, mandelja, eddiebreyes
 * Date: 4/1/2017
 * Time: 2:25PM
 */

if (isset($_POST['SubmitPersonApplicationForm']))
{
    //maybe replace this with code that points to a completely different page where it shows app pending
    header("Location: /applicant_dashboard.php");

    //Changes current account to 'applied' so that it can show 'application pending' rather than 'apply'
    $currentUser = $_SESSION['AccountID'];

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
    $ApplicationDepartmentID = 1;

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

    //Set variable values
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


    //===Animal Care Application===
    //Set these variables to 'no' since applicants cannot have experience with these until they've volunteered
    $ApplicantReptileRoom = 'no';
    $ApplicantReptileRoomSoakDay = 'no';
    $ApplicantSnakeFeeding = 'no';
    $ApplicantICU = 'no';
    $ApplicantICUExpanded = 'no';
    $ApplicantAviary = 'no';
    $ApplicantMammals = 'no';
    $ApplicantPUE = 'no';
    $ApplicantPUEWeighDay = 'no';
    $ApplicantFawns = 'no';
    $ApplicantFormula = 'no';
    $ApplicantMeals = 'no';
    $ApplicantRaptorFeed = 'no';
    $ApplicantISO = 'no';

    //Retrieve other variable values from the application
    $ApplicantPreviousExperience = $_POST['PreviousExperience'];
    $ApplicantDeadAnimalHandling = $_POST['DeadAnimalHandling'];
    $ApplicantLivePreyOpinion = $_POST['LivePreyOpinion'];
    $ApplicantOutdoorWork = $_POST['OutdoorWork'];
    $ApplicantAnimalRightsGroups = $_POST['AnimalRightsGroups'];
    $ApplicantGoals = $_POST['Goals'];
    $ApplicantPassionateIssue = $_POST['PassionateIssue'];

    //Create the application object
    $newAnimalCareApplication = new Application_AnimalCare($ApplicantReptileRoom, $ApplicantReptileRoomSoakDay,
        $ApplicantSnakeFeeding,$ApplicantICU, $ApplicantICUExpanded, $ApplicantAviary, $ApplicantMammals,
        $ApplicantPUE, $ApplicantPUEWeighDay, $ApplicantFawns,$ApplicantFormula, $ApplicantMeals,
        $ApplicantRaptorFeed, $ApplicantISO, $ApplicantPreviousExperience, $ApplicantDeadAnimalHandling,
        $ApplicantLivePreyOpinion, $ApplicantOutdoorWork, $ApplicantAnimalRightsGroups, $ApplicantGoals,
        $ApplicantPassionateIssue);

    //Assign values to variables with object getters
    $ApplicantReptileRoom = $newAnimalCareApplication->getApplicantReptileRoom();
    $ApplicantReptileRoomSoakDay = $newAnimalCareApplication->getApplicantReptileRoomSoakDay();
    $ApplicantSnakeFeeding = $newAnimalCareApplication->getApplicantSnakeFeeding();
    $ApplicantICU = $newAnimalCareApplication->getApplicantICU();
    $ApplicantICUExpanded = $newAnimalCareApplication->getApplicantICUExpanded();
    $ApplicantAviary = $newAnimalCareApplication->getApplicantAviary();
    $ApplicantMammals = $newAnimalCareApplication->getApplicantMammals();
    $ApplicantPUE = $newAnimalCareApplication->getApplicantPUE();
    $ApplicantPUEWeighDay = $newAnimalCareApplication->getApplicantPUEWeighDay();
    $ApplicantFawns = $newAnimalCareApplication->getApplicantFawns();
    $ApplicantFormula = $newAnimalCareApplication->getApplicantFormula();
    $ApplicantMeals = $newAnimalCareApplication->getApplicantMeals();
    $ApplicantRaptorFeed = $newAnimalCareApplication->getApplicantRaptorFeed();
    $ApplicantISO = $newAnimalCareApplication->getApplicantISO();
    $ApplicantPreviousExperience = $newAnimalCareApplication->getApplicantPreviousExperience();
    $ApplicantDeadAnimalHandling = $newAnimalCareApplication->getApplicantDeadAnimalHandling();
    $ApplicantLivePreyOpinion = $newAnimalCareApplication->getApplicantLivePreyOpinion();
    $ApplicantOutdoorWork = $newAnimalCareApplication->getApplicantOutdoorWork();
    $ApplicantAnimalRightsGroups = $newAnimalCareApplication->getApplicantAnimalRightsGroups();
    $ApplicantGoals = $newAnimalCareApplication->getApplicantGoals();
    $ApplicantPassionateIssue = $newAnimalCareApplication->getApplicantPassionateIssue();
    $ApplicationLastUpdatedBy = $newAnimalCareApplication->getApplicantLastUpdatedBy();
    $ApplicationLastUpdated = $newAnimalCareApplication->getApplicantLastUpdated();

    $sqlAnimalCareApplication = "INSERT INTO ApplicationAnimalCare(ApplicationID,ReptileRoom,ReptileRoomSoakDay,SnakeFeeding,ICU,ICUExpanded,Aviary,Mammals,PUE,PUEWeighDay,Fawns,Formula,Meals,RaptorFeed,ISO,PreviousExperience,DeadAnimalHandling,LivePreyOpinion,OutdoorWork,AnimalRightsGroups,Goals,PassionateIssue,LastUpdatedBy,LastUpdated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

    $stmt = mysqli_prepare($conn, $sqlAnimalCareApplication);
    $stmt->bind_param("issssssssssssssssssssss", $ApplicationID,
        $ApplicantReptileRoom, $ApplicantReptileRoomSoakDay,
        $ApplicantSnakeFeeding,$ApplicantICU, $ApplicantICUExpanded, $ApplicantAviary, $ApplicantMammals,
        $ApplicantPUE, $ApplicantPUEWeighDay, $ApplicantFawns,$ApplicantFormula, $ApplicantMeals,
        $ApplicantRaptorFeed, $ApplicantISO, $ApplicantPreviousExperience, $ApplicantDeadAnimalHandling,
        $ApplicantLivePreyOpinion, $ApplicantOutdoorWork, $ApplicantAnimalRightsGroups, $ApplicantGoals,
        $ApplicantPassionateIssue, $ApplicationLastUpdatedBy);

    if($stmt)
    {
        $stmt->execute();
        applicantNowPending($currentUser);
        echo 'applicant is now pending';
    }

    echo "Animal Care Application added to database";

}
?>


<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply To The Animal Care Team</title>


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
            <div class="col-md-6 col-md-offset-3" >
                <div class="smallerheader"><h1>Apply To The Animal Care Team</h1>
                    <p class="smallerheader">Thank you for your interest in The Wildlife Center of Virginia. We have four volunteer teams that work at our organization– Outreach, Animal Care, Veterinary Treatment, and Transport & Rescue. To read more about each team, please visit our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>
            </div>

            <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm_AnimalCare" method="post" action="PersonApplicationForm_AnimalCare.php">

                    <div class="col-md-6 col-md-offset-3"><label>Which team are you interested in applying for?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                <option value="PersonApplicationForm_Transport.php">Transport</option>
                                <option value="PersonApplicationForm_Treatment.php">Treatment</option>
                            </select>
                        </div>
                    </div>

                    <div class = "col-md-6 col-md-offset-3">
                        <label>Please check if you have the following skills: </label>
                    </div><!--end of label-->

                    <div class = "row">
                        <div class = "col-md-6 col-md-offset-3">
                            <fieldset>
                                <label><input type = "checkbox" name = "skills[]" value = "Carpentry Skills">Carpentry Skills</label>
                                <label><input type = "checkbox" name = "skills[]" value = "Administrative Assistant">Administrative Assistant</label>
                                <label><input type = "checkbox" name = "skills[]" value = "Front Desk Trained">Front Desk Trained </label>

                            </fieldset>

                        </div><!-- end of skills checkboxes -->
                        <br>
                    </div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label><br>Please briefly describe your relevant hands-on experience with animals, if any. What did you enjoy about the experience? What did you dislike?</label> <textarea name="PreviousExperience" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Carnivorous patients are sometimes unable to eat food items whole due to their injuries; you may be required to cut and divide dead rodents, chicks, and fishes into smaller portions. Are you comfortable handling dead animals for this purpose?</label> <textarea name="DeadAnimalHandling" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Prior to release from the Wildlife Center, many predatory birds are presented with live mice in order to evaluate their ability to capture prey in a controlled and measurable environment. What is your opinion on using live-prey for this purpose?</label> <textarea name="LivePreyOpinion" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Wildlife rehabilitation requires daily outdoor work -- year-round and regardless of weather conditions. Are you able to work outside during all seasons? If not, what are your limitations?</label> <textarea name="OutdoorWork" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Do you belong to any animal rights groups (PETA, The Humane Society, etc.)? If so, which ones?</label> <textarea name="AnimalRightsGroups" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>What do you hope to learn or accomplish by volunteering at the Wildlife Center of Virginia?</label> <textarea name="Goals" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Please describe an environmental or wildlife-based issue you feel passionately about, and why.</label> <textarea name="PassionateIssue" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Is there anything else that you’d like us to know about yourself or your experience? </label> <textarea name="OtherNotes" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button class="btn btn-sm btn-primary pull-right" name="SubmitPersonApplicationForm" type="submit"><strong>Submit</strong></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>

