
<?php

    /*
	Updated
	Author: Drew Johnson
	Date: 4/11/2017
*/
	
	error_reporting(-1);
	ini_set('display_errors', 'On');
	set_error_handler("var_dump");
	//var_dump($email);
	
	if (isset($_POST['button_pressed'])) 
	{
	
		//$email = $_POST['email'];
		//$to = 'johnsoaw1022@gmail.com, mandelja1@gmail.com'; //uncomment this line for demo?
		$to = $_POST['email'];
		$subject = 'Become A Volunteer';
		$message = 'Hello, thank you for your interest in volunteering at the Wildlife Center of Virginia. Please follow the link to create an account. http://54.186.42.239/createaccount.php';
		$headers = 'From: vawildlifecenter@gmail.com';

		mail($to, $subject, $message, $headers);
		
		//echo 'Email sent';
		
	}
	
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | Email Application</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="emailapp">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content-forgotpassword">

                    <h1>Interested in Volunteering?</h1>
                    <p>
                        Thank you for your interest in The Wildlife Center of Virginia. Enter your email below to have an application sent to your email address. 
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" action="" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email address" required="">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Send Application</button>
								<input type="hidden" name="button_pressed" value="1"/>
                            </form>
                        </div>
                    </div>
                 <div class="return-to-login">
                <p>Return to Login</p>
            </div>
                </div>
         </div>
        </div>
    </div>

</body>

</html>
