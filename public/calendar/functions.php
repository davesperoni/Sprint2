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
        echo ' error in functions ';
    }


}

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

    $status = 'active';
    $sql3 = "INSERT INTO Volunteer (PersonID, VolunteerStatus, Notes) VALUES (:PID, :VolStat, :notes)";
    $stmt = $connPDO->prepare($sql3);

    $stmt->bindParam(':PID', $PID);
    $stmt->bindParam(':VolStat', $status);
    $stmt->bindParam(':notes', $privatenotes);

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

    $sql4 = "INSERT INTO VolunteerDepartment (VolunteerID, DepartmentID, Notes, LastUpdatedBy, LastUpdated) VALUES (:VID, :DepID, :notes, 'System', CURRENT_TIMESTAMP)";
    $stmtDep = $connPDO->prepare($sql4);

    $stmtDep->bindParam(':VID', $VID);
    $stmtDep->bindParam(':DepID', $DID);
    $stmtDep->bindParam(':notes', $privatenotes);

    if ($stmtDep->execute()) {
        //  echo ' good ';
    } else {
        echo ' error in functions department insert into volunteerdpeartment';

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
            echo ' error in functions department ';
            var_dump($stmt);
        }
    }

    //make account 'isVolunteer'
    nowVolunteer($AID);
}

function nowVolunteer($AID) {
//changes isVolunteer to y

    global $conn;
    $query = "SELECT ac.AccountID AS 'AccountID', p.PersonID FROM Person p
  JOIN Application app ON p.PersonID = app.PersonID
  JOIN Account ac ON p.AccountID = ac.AccountID WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($sql)) {

        $AccountID = $row['AccountID'];

        $query = "UPDATE Account ";
        $query .= "SET isVolunteer= 'y' ";
        $query .= "WHERE AccountID = $AccountID";

        $admin_set = mysqli_query($conn, $query);

        confirm_query($admin_set);

       // echo 'Person is now a volunteer.';

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

}

?>