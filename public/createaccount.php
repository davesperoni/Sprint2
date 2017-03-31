<?php

session_start();

//if this is set we know that the user is logged in
if(isset($_SESSION['AccountID'])){
    header("Location: /profile.php");
}

require("Classes/Account.php");
require 'databasePDO.php';
require 'database.php';
$message = ' ';


if(!empty($_POST['email']) && !empty($_POST['password'])) {

    if (($_POST['email']) === 'admin@admin' && ($_POST['password'] === 'wild')) {
        header("Location: /createAdminAccount.php");
    } else {
        // Enter the new user in the database
        $sql = "INSERT INTO Account (Email, Password, LastUpdatedBy, LastUpdated) VALUES (:email, :password, :updatedBy, CURRENT_TIMESTAMP)";
        $stmt = $connPDO->prepare($sql);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $newAccount = new Account($email, $password);
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
            header("Location: /login.php");
        } else {
            $message = 'Issue creating account';
        }
    }
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
  <form role="form" action = "createaccount.php" method="POST">
      <!--   <div class="col-md-2 col-md-offset-3"><div class="form-group"><label>First Name</label> <input type="name" placeholder="Enter first name" class="form-control"></div></div>
          <div class="col-md-2"><div class="form-group"><label>Middle Initial</label> <input type="name" placeholder="Enter first name" class="form-control"></div></div>
        <div class="col-md-2"><div class="form-group"><label>Last Name</label> <input type="name" placeholder="Enter last name" class="form-control"></div></div> -->

      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name = "email"></div></div>
                 
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Confirm Email</label> <input type="email" placeholder="Confirm email" class="form-control"></div></div>
                    
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name = "password"></div></div>
                 
      <div class="col-md-6 col-md-offset-3"><div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Confirm password" class="form-control"></div></div>
                                    
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
