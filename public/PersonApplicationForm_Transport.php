<?php
    session_start();
    include("Classes/Application.php");
    include("Classes/Application_Transport.php");
?>

<?php
    require 'databasePDO.php';
    require 'functions.php';

    /**
     * Created by PhpStorm.
     * User: mandelja
     * Date: 4/1/2017
     * Time: 6:25PM
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
        $ApplicationDepartmentID = 3;

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


    //===Transport Team Application===
    //Assign values to variables
    $ApplicantCaptureAndRestraint = $_POST['CaptureAndRestraint'];
    if ($ApplicantCaptureAndRestraint === "Yes, I am willing to help capture animals.")
    {
        $ApplicantCaptureAndRestraint = 'Yes';
    }
    else
    {
        $ApplicantCaptureAndRestraint = 'No';
    }
    $ApplicantMilesWillingToTravel = $_POST['MilesWillingToTravel'];
    $ApplicantSpeciesLimitations = '';

    //Create the application object
    $newTransportTeamApplication = new Application_Transport($ApplicantCaptureAndRestraint,
        $ApplicantMilesWillingToTravel, $ApplicantSpeciesLimitations);

    //Assign values to variables with object getters
    $ApplicantCaptureAndRestraint = $newTransportTeamApplication->getApplicantCaptureAndRestraint();
    $ApplicantMilesWillingToTravel = $newTransportTeamApplication->getApplicantMilesWillingToTravel();
    $ApplicantSpeciesLimitations = $newTransportTeamApplication->getApplicantSpeciesLimitations();
    $ApplicationLastUpdatedBy = $newTransportTeamApplication->getApplicantLastUpdatedBy();
    $ApplicationLastUpdated = $newTransportTeamApplication->getApplicantLastUpdated();

    $sqlTransportTeamApplication = "INSERT INTO ApplicationTransport(ApplicationID,CaptureAndRestraint,MilesWillingToTravel,SpeciesLimitations,LastUpdatedBy,LastUpdated)VALUES (?,?,?,?,?,CURRENT_TIMESTAMP);";

    $stmt = mysqli_prepare($conn, $sqlTransportTeamApplication);
    $stmt->bind_param("isiss", $ApplicationID, $ApplicantCaptureAndRestraint, $ApplicantMilesWillingToTravel,
        $ApplicantSpeciesLimitations, $ApplicationLastUpdatedBy);

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
        if($stmt)
        {
            $stmt->execute();
            echo "Animal Care Application added to database";
            applicantNowPending($currentUser);
            echo 'applicant is now pending';

            //Send a confirmation email to the current user
            error_reporting(-1);
            ini_set('display_errors', 'On');
            set_error_handler("var_dump");

            $to = $ApplicantEmail;
            $subject = 'Wildlife Center of Virginia - Application Confirmation';
            $message = "Hello," . "\n\nThank you for your interest in volunteering at the Wildlife Center of Virginia. Your Transport Volunteer application has been submitted successfully and is now pending review. Once your application has been reviewed, you will receive another email containing your new application status. You can also check your status by logging in at http://54.186.42.239/login.php";
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

    <title>Apply To The Transport Team</title>


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
            <div class="col-md-6 col-md-offset-3">
                <div class="smallerheader"><h1>Apply To The Transport Team</h1>
                    <p class="smallerheader">Thank you for your interest in The Wildlife Center of Virginia. We have four volunteer teams that work at our organization– Outreach, Animal Care, Veterinary Treatment, and Transport & Rescue. To read more about each team, please visit our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>
            </div>

            <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm_Transport" method="post" action="PersonApplicationForm_Transport.php">

                    <div class="col-md-6 col-md-offset-3"><label>Which team are you interested in applying for?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                <option value="PersonApplicationForm_Transport.php">Transport</option>
                                <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                <option value="PersonApplicationForm_Treatment.php">Treatment</option>
                            </select>
                        </div></div>
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

                    <div class="col-md-6 col-md-offset-3"><div class="form-group"><label><br/>How far are you willing to travel for transport (i.e., 30-45 miles from your location, to a specific location, etc)?</label> <textarea name="MilesWillingToTravel" rows="4" class="form-control"></textarea></div></div>

                    <div class="col-md-6 col-md-offset-3">
                        <p>Sometimes rescuers need assistance with capturing and containing a wild animal in need.  For those who are interested in capturing injured animals:
                        <ul>
                            <li>Know that we do not ask transporters to attempt risky captures of dangerous animals. Also, as a volunteer, you can always say “no” if you are uncomfortable with a situation.</li>
                            <li>If you are considering attempting a capture/rescue, we are available by phone to give advice on the best way to go about attempting a rescue safely.</li>
                            <li>We can advise you on any particularly helpful items or equipment to take with you.</li>
                            <li>We have humane live traps available to assist you, if needed.</li>
                        </ul>
                        Several times throughout the year, we offer a wildlife rehabilitation training class called Wildlife Capture, Restraint, Handling, and Transport. This class is taught both online and in-person at locations throughout Virginia. This class is free to our registered volunteer transporters and is an excellent way to build skills and confidence for capturing animals. We will email you when this class is available.
                        </p>
                    </div>

                    <div class="col-md-6 col-md-offset-3"><label>With that in mind, would you be willing to assist with capturing animals, if needed?</label></div>
                    <div class="col-md-6 col-md-offset-3"><div class="form-group">
                            <select name="CaptureAndRestraint">
                                <option value="Yes">Yes, I am willing to help capture animals.</option>
                                <option value="No">No, I'd prefer to strictly transport.</option>
                            </select>
                        </div></div>

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

