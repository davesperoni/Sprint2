<?php

/*
Last updated by Jenny Mandel
4/19/2017 at 12:15pm
added validation
need to add - check if email already exists in database 
*/

session_start();

require("Classes/Account.php");
require 'databasePDO.php';
require 'database.php';
$message = ' ';

//declare variables
$emailErr = "";
$confirmEmailErr = "";
$passwordErr = "";
$confirmPasswordErr = "";
$email = "";
$confirmEmail = "";
$password = "";
$confirmPassword = "";

//if this is set we know that the user is logged in
if(isset($_SESSION['AccountID'])){
    header("Location: /logout.php");
}
else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Validate Email
        if (empty($_POST["email"])) {
            $emailErr = "Required field";
        } else if (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = test_input($_POST["email"]);
        }

        //Validate Email Confirmation
        if (empty($_POST["confirmEmail"])) {
            $confirmEmailErr = "Required field";
        } else if (strtolower($_POST["confirmEmail"]) != strtolower($_POST["email"])) {
            $confirmEmailErr = "Emails do not match.";
        } else if (!filter_var(test_input($_POST["confirmEmail"]), FILTER_VALIDATE_EMAIL)) {
            $confirmEmailErr = "Invalid email format";
        } else {
            $confirmEmail = test_input($_POST["confirmEmail"]);
        }

        //Validate Password
        if (empty($_POST["password"])) {
            $passwordErr = "Required field";
        } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST["password"])) {
            $passwordErr = "Password must be between 8-20 characters in length and must contain at least one uppercase letter, one lowercase letter, and one number.";
        } else {
            $password = test_input($_POST["password"]);
        }

        //Validate Password Confirmation
        if (empty($_POST["confirmPassword"])) {
            $confirmPasswordErr = "Required field";
        } else if ($_POST["confirmPassword"] != $_POST["password"]) {
            $confirmPasswordErr = "Passwords do not match.";
        } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST["confirmPassword"])) {
            $confirmPasswordErr = "Password must be between 8-20 characters in length and must contain one uppercase letter, one lowercase letter, and one number.";
        } else {
            $confirmPassword = test_input($_POST["confirmPassword"]);
        }
        //Once fields have been validated, create an account
        if (!empty($email && $confirmEmail && $password && $confirmPassword)) {
            if (($_POST['email']) === 'admin@admin' && ($_POST['password'] === 'wild')) {
                header("Location: /createAdminAccount.php");
            }
            else {
                // Enter the new user in the database
                $sql = "INSERT INTO Account (Email, Password, LastUpdatedBy, LastUpdated) 
                    VALUES (:email, :password, :updatedBy, CURRENT_TIMESTAMP)";

                $stmt = $connPDO->prepare($sql);

                //var_dump($confirmEmail, $confirmPassword);

                $newAccount = new Account($confirmEmail, $confirmPassword);
                $email = $newAccount->getEmail();
                $password = $newAccount->getPassword();
                $updatedBy = $newAccount->getLastUpdatedBy();
                $lastUpdated = $newAccount->getLastUpdated();

                $stmt->bindParam(':email', $email);
                //take out hash to turn off notice
                $var = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $var);

                //$stmt->bindParam(':isAdmin', $isAdmin);


                $stmt->bindParam(':updatedBy', $updatedBy);
                //  $stmt->bindParam(':LastUpdatedBy', $updatedBy);
                //$stmt->bindParam(':LastUpdated', $lastUpdated);

                //$updatedBy = "System";
                //$lastUpdated = "2017-01-01";

                if ($stmt->execute()) {
                    $message = 'Successfully created new user';

                    //Send a confirmation email to the current user
                    error_reporting(-1);
                    ini_set('display_errors', 'On');
                    set_error_handler("var_dump");

                    $to = $email;
                    $subject = 'Wildlife Center of Virginia Account Confirmation';
                    $emailMessage = "Hello," . "\n\n Thank you for your interest in volunteering at the Wildlife Center of Virginia. "
                        . "You have successfully created your account and you are now able to log in at http://54.186.42.239/login.php "
                        . "\n\nThe first time you fill out an application, you will be prompted to fill out your profile information and emergency contact information. "
                        . "Once your profile is complete, you will be able to submit applications to our various volunteer departments."
                        . "\n\nIf you did not create an account with the Wildlife Center of Virginia using this email address, "
                        . "please contact our team at vawildlifecenter@gmail.com ";
                    $headers = 'From: vawildlifecenter@gmail.com';

                    mail($to, $subject, $emailMessage, $headers);

                    header("Location: /login.php");
                } else {
                    $message = 'Issue creating account';
                }

            }
        }
    }
}

?>

<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create An Account</title>

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
						<div class="smallerheader"><h1>Create An Account</h1></div>
                            
<div class="col-sm-12">
  <form role="form" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <!--   <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" placeholder="Enter first name" class="form-control"></div></div>
          <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" placeholder="Enter first name" class="form-control"></div></div>
        <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" placeholder="Enter last name" class="form-control"></div></div> -->

      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Email</label><span class="error"> * <?php echo $emailErr;?></span> <input type="email" placeholder="Enter email" class="form-control" name = "email" value="<?php echo $email;?>"></div></div>
                 
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Confirm Email</label><span class="error"> * <?php echo $confirmEmailErr;?></span> <input type="email" placeholder="Confirm email" class="form-control" name = "confirmEmail" value="<?php echo $confirmEmail;?>"></div></div>
                    
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Password</label><span class="error"> * <?php echo $passwordErr;?></span> <input type="password" placeholder="Enter password" class="form-control" name = "password" value="<?php echo $password;?>"></div></div>
                 
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Confirm Password</label><span class="error"> * <?php echo $confirmPasswordErr;?></span> <input type="password" placeholder="Confirm password" class="form-control" name = "confirmPassword" value="<?php echo $confirmPassword;?>"></div></div>
                                    
      <div class="col-md-6 col-md-offset-2">
          <br>
          <button class="btn btn-sm btn-primary pull-right" type="submit"><strong>Create Account</strong></button></div>
    </form>
</div>
         </div>
   <center> <?php if(!empty($message)): ?>
         <p><?= $message ?></p>
     <?php endif; ?>
   </center>

 </div>
   </div>

</body>
</html>
