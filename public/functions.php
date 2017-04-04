<?php
require 'database.php';
require 'databasePDO.php';



function acceptApplicant($AID) {

//changes application status to accepted in application
//changes isVolunteer to y

    global $conn;
    $query = "UPDATE Application ";
    $query .= "SET ApplicationStatus = 'Accepted' ";
    $query .= "WHERE ApplicationID = $AID";

    $sql = mysqli_query($conn, $query);
    confirm_query($sql);
    if (!$sql) {
        die("Database query failed");
    }
    //mysqli_close($conn);

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

        echo 'Person is now a volunteer.';

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