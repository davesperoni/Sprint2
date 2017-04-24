<?php
//session_start();
require 'database.php';
require 'databasePDO.php';


function rejectApplicant($AID, $privatenotes) {

    global $conn;
    global $connPDO;

    $query = "SELECT ac.AccountID AS 'AccountID', p.PersonID FROM Person p
  JOIN Application app ON p.PersonID = app.PersonID
  JOIN Account ac ON p.AccountID = ac.AccountID WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $AccountID = $row['AccountID'];
    }
        $newquery = "SELECT PersonID FROM Person JOIN Account on Person.AccountID = Account.AccountID 
        WHERE Account.AccountID = $AccountID";

        $sql2 = mysqli_query($conn, $newquery);
        confirm_query($sql2);
        if (!$sql2) {
            die("Database query failed");
        }

        while($row = mysqli_fetch_array($sql2)) {
            $PID = $row['PersonID'];
        }


    $query = "UPDATE Application ";
    $query .= "SET ApplicationStatus = 'Rejected' ";
    $query .= "WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);
    confirm_query($sql);
    if (!$sql) {
        die("Database query failed");
    }

    $status = 'inactive';
    $sql3 = "INSERT INTO Volunteer (PersonID, VolunteerStatus, Notes) VALUES (:PID, :VolStat, :notes)";
    $stmt = $connPDO->prepare($sql3);

    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);
    $stmt->bindParam(':notes', $privatenotes);

    if ($stmt->execute()) {
        //  echo ' good ';
    } else {
        echo ' error in functions 2';
    }

}

/* OLD CODE FOR ACCEPTING AN APPLICANT
function acceptApplicant($AID) {

//changes application status to accepted in application
//changes isVolunteer to y

    global $conn;
    global $connPDO;

    $query = "UPDATE Application ";
    $query .= "SET ApplicationStatus = 'Accepted' ";
    $query .= "WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);
    confirm_query($sql);
    if (!$sql) {
        die("Database query failed");
    }
	
    //Part below adds person who was just accepted into the volunteer TABLE
    //1 ) get person id
    //2) add that personID

    global $conn;
    $query = "SELECT ac.AccountID AS 'AccountID', p.PersonID FROM Person p
  JOIN Application app ON p.PersonID = app.PersonID
  JOIN Account ac ON p.AccountID = ac.AccountID WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $AccountID = $row['AccountID'];
		
        $newquery = "SELECT PersonID FROM Person JOIN Account on Person.AccountID = Account.AccountID 
        WHERE Account.AccountID = $AccountID";

        $sql2 = mysqli_query($conn, $newquery);
        confirm_query($sql2);
        if (!$sql2) {
            die("Database query failed");
        }

        while($row = mysqli_fetch_array($sql2)) {
            $PID = $row['PersonID'];
        }
    }

    $status = 'active';

    $sql3 = "INSERT INTO Volunteer (PersonID, VolunteerStatus) VALUES (:PID, :VolStat)";

    $stmt = $connPDO->prepare($sql3);

    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);

    if ($stmt->execute()) {
      //  echo ' good ';
    } else {
            echo ' error in functions ';
    }

    $query = "SELECT v.VolunteerID AS 'VID', app.DepartmentID AS 'DID' FROM Volunteer v
     JOIN Person P ON v.PersonID = P.PersonID
     JOIN Application app ON app.PersonID = P.PersonID
     WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $VID = $row['VID'];
        $DID = $row['DID'];

    }

    $sql4 = "INSERT INTO VolunteerDepartment (VolunteerID, DepartmentID, Notes, LastUpdatedBy, LastUpdated) VALUES (:VID, :DepID, 'none', 'System', CURRENT_TIMESTAMP)";
    $stmtDep = $connPDO->prepare($sql4);

    $stmtDep->bindParam(':VID', $VID);
    $stmtDep->bindParam(':DepID', $DID);

    if ($stmtDep->execute()) {
        //  echo ' good ';
    } else {
        echo ' error in functions department ';
    }


/*    //if department is VolunteerDepartmentAnimalCare = 1
    $sqlDepartment = "INSERT INTO VolunteerDepartmentAnimalCare (PersonID, VolunteerStatus) VALUES (:PID, :VolStat)";
    $stmt = $connPDO->prepare($sqlDepartment);
    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);


    //if department is VolunteerDepartmentOutreach = 2
    $sqlDepartment = "INSERT INTO VolunteerDepartmentOutreach (PersonID, VolunteerStatus) VALUES (:PID, :VolStat)";
    $stmt = $connPDO->prepare($sqlDepartment);
    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);


    //if department is VolunteerDepartmentTransport = 3
    $sqlDepartment = "INSERT INTO VolunteerDepartmentTransport (PersonID, VolunteerStatus) VALUES (:PID, :VolStat)";
    $stmt = $connPDO->prepare($sqlDepartment);
    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);


    //if department is VolunteerDepartmentTreatment = 4
    $sqlDepartment = "INSERT INTO VolunteerDepartmentTreatment (PersonID, VolunteerStatus) VALUES (:PID, :VolStat)";
    $stmt = $connPDO->prepare($sqlDepartment);
    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);
*/

/*
    if ($stmt->execute()) {
        //  echo ' good ';
    } else {
        echo ' error in functions ';
    }
*/

    //mysqli_close($conn);
/*
    nowVolunteer($AID);
}
*/

function acceptApplicant($AID, $privatenotes) {
//changes application status to accepted in application
//changes isVolunteer to y

    global $conn;
    global $connPDO;

    $query = "UPDATE Application ";
    $query .= "SET ApplicationStatus = 'Accepted' ";
    $query .= "WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);
    confirm_query($sql);
    if (!$sql) {
        die("Database query failed");
    }

    //Part below adds person who was just accepted into the volunteer TABLE
    //1 ) get person id
    //2) add that personID

    //global $conn;
    $query = "SELECT ac.AccountID AS 'AccountID', p.PersonID FROM Person p
  JOIN Application app ON p.PersonID = app.PersonID
  JOIN Account ac ON p.AccountID = ac.AccountID WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $AccountID = $row['AccountID'];

        $newquery = "SELECT PersonID FROM Person JOIN Account on Person.AccountID = Account.AccountID 
        WHERE Account.AccountID = $AccountID";

        $sql2 = mysqli_query($conn, $newquery);
        confirm_query($sql2);
        if (!$sql2) {
            die("Database query failed");
        }

        while($row = mysqli_fetch_array($sql2)) {
            $PID = $row['PersonID'];
        }
    }

    $status = 'Active';
	//$YTDHours = '0';
	//$YTDMiles = '0';
    $sql3 = "INSERT INTO Volunteer (PersonID, VolunteerStatus, Notes) VALUES (:PID, :VolStat, :notes)";
    $stmt = $connPDO->prepare($sql3);

    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);
    $stmt->bindParam(':notes', $privatenotes);
	//$stmt->bindParam(':YTDHours', $YTDHours);
	//$stmt->bindParam(':YTDMiles', $YTDMiles);

    if ($stmt->execute()) {
      //  echo ' good ';
    } else {
            echo ' error in functions 1';
    }

    $query = "SELECT v.VolunteerID AS 'VID', app.DepartmentID AS 'DID' FROM Volunteer v
     JOIN Person P ON v.PersonID = P.PersonID
     JOIN Application app ON app.PersonID = P.PersonID
     WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $VID = $row['VID'];
        $DID = $row['DID'];

    }

    $sql4 = "INSERT INTO VolunteerDepartment (VolunteerID, DepartmentID, Notes, LastUpdatedBy, LastUpdated) VALUES (:VID, :DepID, :notes, 'System', CURRENT_TIMESTAMP)";
    $stmtDep = $connPDO->prepare($sql4);

    $stmtDep->bindParam(':VID', $VID);
    $stmtDep->bindParam(':DepID', $DID);
    $stmtDep->bindParam(':notes', $privatenotes);

    if ($stmtDep->execute()) {
        //  echo ' good ';
    } else {
        echo ' error in functions department insert into volunteerdepartment ';

        var_dump($VID);
        var_dump($DID);
        var_dump($privatenotes);

    }

    if($DID == 1){
        $sqlDepartment = "INSERT INTO VolunteerDepartmentAnimalCare (VolunteerID, DepartmentID, LastUpdatedBy, OneShiftMinimumPerWeek, LastUpdated) VALUES (:VID, :DID, 'System', 'no',CURRENT_TIMESTAMP)";
        $stmt2 = $connPDO->prepare($sqlDepartment);
        $stmt2->bindParam(':VID', $VID);
        $stmt2->bindParam(':DID', $DID);

        if ($stmt2->execute()) {
            //  echo ' good ';
        } else {
            echo ' error in functions department ';
            var_dump($stmt);
        }
    }

    if($DID == 2){
        $sqlDepartment = "INSERT INTO VolunteerDepartmentOutreach (VolunteerID, DepartmentID, LastUpdatedBy, LastUpdated) VALUES (:VID, :DID, 'System', CURRENT_TIMESTAMP)";
        $stmt2 = $connPDO->prepare($sqlDepartment);
        $stmt2->bindParam(':VID', $VID);
        $stmt2->bindParam(':DID', $DID);

        if ($stmt2->execute()) {
            //  echo ' good ';
        } else {
            echo ' error in functions department ';
            var_dump($stmt);
        }
    }

    if($DID == 3){
        $sqlDepartment = "INSERT INTO VolunteerDepartmentTransport (VolunteerID, DepartmentID, LastUpdatedBy, LastUpdated) VALUES (:VID, :DID, 'System', CURRENT_TIMESTAMP)";
        $stmt2 = $connPDO->prepare($sqlDepartment);
        $stmt2->bindParam(':VID', $VID);
        $stmt2->bindParam(':DID', $DID);

        if ($stmt2->execute()) {
            //  echo ' good ';
        } else {
            echo ' error in functions department ';
            var_dump($stmt);
        }
    }

    if($DID == 4){
        $sqlDepartment = "INSERT INTO VolunteerDepartmentTreatment (VolunteerID, DepartmentID, LastUpdatedBy, LastUpdated) VALUES (:VID, :DID, 'System', CURRENT_TIMESTAMP)";
        $stmt2 = $connPDO->prepare($sqlDepartment);
        $stmt2->bindParam(':VID', $VID);
        $stmt2->bindParam(':DID', $DID);

        if ($stmt2->execute()) {
            //  echo ' good ';
        } else {
           /*  echo ' error in functions department ';
            var_dump($stmt); */
        }
    }

    //make account 'isVolunteer'
    nowVolunteer($AID);
}

function nowVolunteer($AID) {
//changes isVolunteer to y

    global $conn;
    $query = "SELECT ac.AccountID AS 'AccountID', ac.Email, p.PersonID FROM Person p
	JOIN Application app ON p.PersonID = app.PersonID
	JOIN Account ac ON p.AccountID = ac.AccountID WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $AccountID = $row['AccountID'];
		$email = $row['Email'];

        $query = "UPDATE Account ";
        $query .= "SET isVolunteer= 'y' ";
        $query .= "WHERE AccountID = $AccountID";

        $admin_set = mysqli_query($conn, $query);

        confirm_query($admin_set);

       // echo 'Person is now a volunteer.';
		
		//Send an email to the applicant notifying them that their application has been approved.
		$to = $email;
		$subject = 'Wildlife Center of Virginia - Application Status Notification';
		$emailMessage = "Hello,"
		. "\n\nYour application has been approved! To view your volunteer account and sign up for volunteer shifts, log in at http://54.186.42.239/login.php "
		. ". \n\nIf you have any questions regarding your account, please contact our team at vawildlifecenter@gmail.com ";
		$headers = 'From: vawildlifecenter@gmail.com';

		mail($to, $subject, $emailMessage, $headers);

        //header("Location: /pending_apps.php");
       // mysqli_close($conn);
   }

    mysqli_close($conn);
}

    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed.");
        }
    }

//Returns true or false based on isAdmin in db
function isAdmin($currentAccountID)
{
    global $conn;

    $query = "SELECT isAdmin ";
    $query .= "FROM Account ";
    $query .= "WHERE AccountID = $currentAccountID";

    $admin_set = mysqli_query($conn, $query);
    confirm_query($admin_set);
    if (!$admin_set) {
        die("Database query failed");
    }
        $users = $admin_set->fetch_all(MYSQLI_ASSOC);

        foreach ($users as $user) {
            if($user['isAdmin'] === 'y'){
                return true;
            }
            else{
                return false;
            }
        }
    mysqli_close($conn);

}


//Returns true or false based on volunteer in db
function isVolunteer($currentAccountID)
{
    global $conn;

    $query = "SELECT isVolunteer ";
    $query .= "FROM Account ";
    $query .= "WHERE AccountID = $currentAccountID";

    $admin_set = mysqli_query($conn, $query);
    confirm_query($admin_set);
    if (!$admin_set) {
        die("Database query failed");
    }
    $users = $admin_set->fetch_all(MYSQLI_ASSOC);

    foreach ($users as $user) {
        if($user['isVolunteer'] === 'y'){
            return true;
        }
        else{
            return false;
        }
    }
    mysqli_close($conn);

}


//Returns true or false based on volunteer in db
function isApplicant($currentAccountID)
{
    global $conn;

    $query = "SELECT isApplicant ";
    $query .= "FROM Account ";
    $query .= "WHERE AccountID = $currentAccountID";

    $admin_set = mysqli_query($conn, $query);
    confirm_query($admin_set);
    if (!$admin_set) {
        die("Database query failed");
    }
    $users = $admin_set->fetch_all(MYSQLI_ASSOC);

    foreach ($users as $user) {
        if($user['isApplicant'] === 'y'){
            return true;
        }
        else{
            return false;
        }
    }
    mysqli_close($conn);

}

function applicantNowPending($currentAccountID)
{
    global $conn;

    $query = "UPDATE Account ";
    $query .= "SET isApplicant= 'y' ";
    $query .= "WHERE AccountID = $currentAccountID";

    $admin_set = mysqli_query($conn, $query);
    confirm_query($admin_set);

    echo 'Person is now an applicant.';

    mysqli_close($conn);
	
/*
        //Send a confirmation email to the applicant
        error_reporting(-1);
        ini_set('display_errors', 'On');
        set_error_handler("var_dump");

        //Get the email address associated with the user's account
        $sql = "SELECT Email from Account WHERE AccountID = :AccountID;";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindParam(':AccountID', $currentAccountID);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($results) > 0)
        {
            $account = $results;
        }
        $ApplicantEmail= $account['Email'];
        $to = $ApplicantEmail;
        $subject = 'Wildlife Center of Virginia - Application Confirmation';
        $message = "Hello," . "\n\nThank you for your interest in volunteering at the Wildlife Center of Virginia. Your application has been submitted successfully and is now pending review. Once your application has been reviewed, you will receive another email containing your new application status. You can also check your status by logging in at http://54.186.42.239/login.php";
        $headers = 'From: vawildlifecenter@gmail.com';

        mail($to, $subject, $message, $headers);
*/

}

?>