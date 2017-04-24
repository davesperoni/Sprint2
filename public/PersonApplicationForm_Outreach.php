<?php
session_start();
include("Classes/Application.php"); ?>
<?php include("Classes/Application_Outreach.php"); ?>


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
    $ApplicationDepartmentID = 2;

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

		//var_dump($sqlApplication);
    //Execute the insert statement
    if($stmt)
    {
        $stmt->execute();
		
		//var_dump("Application added to database!");
    }

    //Show confirmation messages
	
    $ApplicationID = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $ApplicationID;

    //Outreach Application
    $ApplicationExplainInterest = $_POST['ExplainInterest'];
    $ApplicationPassionateIssue = $_POST['PassionateIssue'];
    $ApplicationPublicSpeakingExperience = $_POST['PublicSpeakingExperience'];
    $ApplicationAnimalRightsGroups = $_POST['AnimalRightsGroups'];
    $ApplicationYourContribution = $_POST['YourContribution'];

    $newOutreachApplication = new Application_Outreach($ApplicationExplainInterest,
        $ApplicationPassionateIssue, $ApplicationPublicSpeakingExperience,
        $ApplicationAnimalRightsGroups, $ApplicationYourContribution);

    $ApplicationExplainInterest = $newOutreachApplication->getApplicantExplainInterest();
    $ApplicationPassionateIssue = $newOutreachApplication->getApplicantPassionateIssue();
    $ApplicationPublicSpeakingExperience = $newOutreachApplication->getApplicantPublicSpeakingExperience();
    $ApplicationAnimalRightsGroups = $newOutreachApplication->getApplicantAnimalRightsGroups();
    $ApplicationYourContribution = $newOutreachApplication->getApplicantYourContribution();
    $ApplicationOutreachLastUpdatedBy = $newOutreachApplication->getApplicantLastUpdatedBy();
    $ApplicationOutreachLastUpdated = $newOutreachApplication->getApplicantLastUpdated();

    $sqlOutreachApplication = "INSERT INTO ApplicationOutreach (ApplicationID, ExplainInterest, PassionateIssue, PublicSpeakingExperience, AnimalRightsGroups, YourContribution, LastUpdatedBy, LastUpdated) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

    $stmtOutreachApp = mysqli_prepare($conn, $sqlOutreachApplication);
    $stmtOutreachApp->bind_param("issssss", $ApplicationID, $ApplicationExplainInterest, $ApplicationPassionateIssue,
        $ApplicationPublicSpeakingExperience, $ApplicationAnimalRightsGroups, $ApplicationYourContribution,
        $ApplicationLastUpdatedBy);

	
	//Get the email address associated with the user's account
    $sql = "SELECT Email from Account WHERE AccountID = :AccountID;";
    $stmt = $connPDO->prepare($sql);
    $stmt->bindParam(':AccountID', $currentUser);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0)
    {
        $account = $results;
    }
    $ApplicantEmail= $account['Email'];
	
	//Execute the sql statement, change the account isApplicant value, and send an email confirmation
    if($stmtOutreachApp)
    {
        $stmtOutreachApp->execute();
		echo "Outreach Application added to database";
	    applicantNowPending($currentUser);
		echo 'applicant is now pending';
		
		//Send a confirmation email to the current user
        error_reporting(-1);
        ini_set('display_errors', 'On');
        set_error_handler("var_dump");

		if(!empty($ApplicantEmail))
		{		
			$to = $ApplicantEmail;
			$subject = 'Wildlife Center of Virginia - Application Confirmation';
			$message = "Hello," . "\n\nThank you for your interest in volunteering at the Wildlife Center of Virginia. Your Outreach Volunteer application has been submitted successfully and is now pending review. Once your application has been reviewed, you will receive another email containing your new application status. You can also check your status by logging in at http://54.186.42.239/login.php";
			$headers = 'From: vawildlifecenter@gmail.com';

			mail($to, $subject, $message, $headers);
		}
		
		//Send a confirmation email to the team lead
		$to = 'vawildlifecenter.outreach@gmail.com'; //change to $TeamLeadEmail later
        $subject = 'Notification - Application Confirmation';
        $message = "Hello," . "\n\nSomeone has submitted a volunteer application to the Outreach department. Please log in to your profile and go to the Pending Apps tab to view the application. You can log into your account here: http://54.186.42.239/login.php";
        $headers = 'From: vawildlifecenter@gmail.com';

        mail($to, $subject, $message, $headers);
		
    }

    


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

<body class="formback">
<div class = "col-md-10 col-md-offset-1">
    <div class = "grayform">
        <div class="ibox-content-form">
            <div class="formpadding">
                <div class="row">
                    <img class = "logo_form img-fluid" src = "img/habitat_logo.png" alt = "habitat logo">

                    <div class="smallerheader btmSpace"><h2>APPLY TO THE OUTREACH TEAM</h2>
                        Thank you for your interest in The Wildlife Center of Virginia. We have four volunteer teams that work at our organization– Outreach, Animal Care, Veterinary Treatment, and Transport & Rescue. To read more about each team, please visit our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a><br>
                    </div>


                    <div class="col-sm-12">
                        <form role="form" name="PersonApplicationForm_Outreach" method="post" action="PersonApplicationForm_Outreach.php">

                            <div class="col-md-6 col-md-offset-3"><label class = "centeredText btmSpace2">Which team are you interested in applying for?</label></div>
                            <div class="col-md-6 col-md-offset-3"><div class="form-group centeredText btmSpace2">
                                    <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                        <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                        <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                        <option value="PersonApplicationForm_Transport.php">Transport</option>
                                        <option value="PersonApplicationForm_Treatment.php">Treatment</option>
                                    </select>
                                </div>
                            </div>

                            <div class = "col-md-8 col-md-offset-2">
                                <label>Please check if you have the following skills: </label>
                            </div><!--end of label-->

                            <div class = "row">
                                <div class = "col-md-8 col-md-offset-2">
                                    <fieldset>
                                        <label><input type = "checkbox" name = "skills[]" value = "Carpentry Skills">Carpentry Skills</label>
                                        <label><input type = "checkbox" name = "skills[]" value = "Administrative Assistant">Administrative Assistant</label>
                                        <label><input type = "checkbox" name = "skills[]" value = "Front Desk Trained">Front Desk Experience </label>

                                    </fieldset>

                                </div><!-- end of skills checkboxes -->
                                <br>
                            </div>

                    <div class="col-md-8 col-md-offset-2"><div class="form-group"><label><br/>Why are you interested in volunteering as an outreach docent?</label> <textarea name="ExplainInterest" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-8 col-md-offset-2"><div class="form-group"><label>What's an environmental or wildlife issue you feel passionately about, and why?</label> <textarea name="PassionateIssue" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-8 col-md-offset-2"><div class="form-group"><label>Do you have prior experience speaking to the public? Please describe.</label> <textarea name="PublicSpeakingExperience" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-8 col-md-offset-2"><div class="form-group"><label>Do you belong to any animal rights groups (PETA, The Humane Society, etc.)? If so, which ones?</label> <textarea name="AnimalRightsGroups" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-8 col-md-offset-2"><div class="form-group"><label>What do you think you'd bring to the outreach volunteer team?</label> <textarea name="YourContribution" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-8 col-md-offset-2">
                        <br>
                        <button class="btn btn-sm btn-primary pull-right" name="SubmitPersonApplicationForm" type="submit"><strong>Submit</strong></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>


</body>
</html>
