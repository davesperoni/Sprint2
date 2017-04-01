<?php
require 'database.php';

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