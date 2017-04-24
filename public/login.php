<?php

    session_start();

    require 'functions.php';
    require 'database.php';
    require 'databasePDO.php';

    //if this is set we know that the user is logged in
    if(isset($_SESSION['AccountID'])){
        $currentAccountID = $_SESSION['AccountID'];
        if (isAdmin($currentAccountID)) {
            $message = 'This is an Admin';
            header("Location: /admin_dashboard.php");
        }
        else if (isVolunteer($currentAccountID)) {
            $message = 'This is an active volunteer';
            //full access to volunteer dashboard
            header("Location: /volunteer_dashboard.php");
        }
        else if (isApplicant($currentAccountID)) {
            $message = 'This is person is waiting approval';
            //Brings to volunteer_dashboard but it says pending
            header("Location: /volunteer_dashboard.php");
        }
        else {
            $message = 'This person has not submitted an app/profile';
            //Brings to volunteer_dashboard but it says pending
            header("Location: /volunteer_dashboard.php");
        }
    }


    //This gets the AccountID of the person who logged in based on their email and password and assigns it to a _SESSION variable
    if(!empty($_POST['email']) && !empty($_POST['password'])):

        $records = $connPDO->prepare('SELECT AccountID,Email,Password FROM Account WHERE Email = :email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $message = '';

        if(count($results) > 0 && password_verify($_POST['password'], $results['Password'])){

            //stored server side so when ever we move form page to page user stays logged in
            $_SESSION['AccountID'] = $results['AccountID'];

            //re-direct user to appropriate page
            if(isset($_SESSION['AccountID'])){

                $currentAccountID = $_SESSION['AccountID'];
                if (isAdmin($currentAccountID)) {
                    $message = 'This is an Admin';
                    header("Location: /admin_dashboard.php");
                }
                else if (isVolunteer($currentAccountID)) {
                    $message = 'This is an active volunteer';
                    //full access to volunteer dashboard
                    header("Location: /volunteer_dashboard.php");
                }
                else if (isApplicant($currentAccountID)) {
                    $message = 'This is person is waiting approval';
                    //Brings to volunteer_dashboard but it says pending
                    header("Location: /applicant_dashboard.php");
                }
                else {
                    $message = 'This person has not submitted an app/profile';
                    //Brings to volunteer_dashboard but it says pending
                    header("Location: /applicant_dashboard.php");
                }
            }
    }
    else if(password_verify($_POST['password'], $results['Password'])){
        $message = 'The password was incorrect';

    }
    else{
        $message = 'This user does not exist.';
    }

    endif;

?>


<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sign In</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

</head>

<body class = "login-page">
 <div class = "row"> 
  <div class = "col-sm-12">

  </div>
 </div><!-- end of row --> 
    <div class = "row ">
      <div class = "col-sm-6 col-sm-offset-3 login-background">

          <?php if(!empty($message)): ?>
              <p><?= $message ?></p>
          <?php endif; ?>

          <form class = "" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

              <div class = "row">

                      <img src="img/habitat_logo.png" class = "logo_form img-fluid">

              </div>


              <div class = "row">
                  <div class = "col-sm-3 col-sm-offset-1">
          <h3 id = "login-title">SIGN IN</h3>
                  </div>
              </div><!-- end of sign in -->

              <div class = "row">
                  <div class = "col-sm-2 col-sm-offset-1">
              <label class = "login-form"> Email:</label>
                  </div><!-- end of email input -->

                  <div class = "col-sm-3 col-sm-offset-1">
              <input input type="text" name="email"  size = "30" placeholder="email" > </input>
                  </div>
              </div><!-- end of email input -->


              <div class = "row">
                  <div class = "col-sm-2 col-sm-offset-1">
            <label class = "login-form moveDown"> Password: </label>
                  </div><!-- end of label -->

                  <div class = "col-sm-3 col-sm-offset-1">
                      <input type="password" name="password" size = "30" placeholder="password"> </input>
                  </div><!-- end of password input -->
              </div><!-- end of password field -->
            <div class = "row">
                <div class = "col-sm-3 col-sm-offset-1">
              <input type="submit" value ="Sign In" class="btn-edit-form moveDown"></input>
                </div>
            </div><!-- end of button -->

              <div class ="row">
            <div class = "ugh-move-please">
            <a href="forgot_password.php" class = "form-links moveDown" id = "forgot"> Forgot Your Password? </a><span>|</span><a href="email_CreateAnAccount.php" class = "form-links moveDown"> Become A Volunteer </a>
            </div>
              </div>

          <div class = "row">
              <p class = "logo_form"> WILDLIFE CENTER OF VIRGINIA</p>

          </div>

          </form>



</body>
</html>
