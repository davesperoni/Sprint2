<?php
    session_start();

    include("Classes/Application.php"); ?>
    <?php include("Classes/Application_AnimalCare.php"); ?>
    <?php include("Classes/Application_Outreach.php"); ?>
    <?php include("Classes/Application_Transport.php"); ?>
    <?php include("Classes/Application_TreatmentTeam.php"); ?>

    <?php
    require 'databasePDO.php';
    require 'database.php';
    require 'functions.php';

    /**
     * Created by PhpStorm.
     * User: ShanikaWije, mandelja, eddiebreyes
     * Date: 4/4/2017
     * Time: 12:15PM
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

    $currentUser = $_SESSION['AccountID'];

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
            <div class="col-md-6 col-md-offset-3" >
                <div class="smallerheader"><h1>Apply To A Team</h1>
                    <p class="smallheader">Thank you for your interest in The Wildlife Center of Virginia. We have four volunteer teams that work at our organization– Outreach, Animal Care, Veterinary Treatment, and Transport & Rescue. To read more about each team, please visit our <a href="http://wildlifecenter.org/support-center/volunteer-opportunities">volunteer opportunities page.</a></p></div>
            </div>

            <div class="col-sm-12">
                <form role="form" name="PersonApplicationForm" method="post" action="PersonApplicationForm.php">
                    <div class = "col-md-6 col-md-offset-3">
                        <div class="col-md-6 col-md-offset-3 moveDown"><label>Which team are you interested in applying for?</label></div>
                        <div class="col-md-6 col-md-offset-3"><div class="form-group">
                                <select name="Team" onchange="location = this.options[this.selectedIndex].value;" style="text-decoration:none;">
                                    <option value="PersonApplicationForm.php"></option>
                                    <option value="PersonApplicationForm_AnimalCare.php">Animal Care</option>
                                    <option value="PersonApplicationForm_Outreach.php">Outreach</option>
                                    <option value="PersonApplicationForm_Transport.php">Transport</option>
                                    <option value="PersonApplicationForm_Treatment.php">Treatment</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
