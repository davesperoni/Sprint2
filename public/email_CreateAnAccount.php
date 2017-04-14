<?php
/**
 * Created by Jenny Mandel
 * Date: 4/14/2017
 * Time: 5:57 PM
 *
 * When a volunteer clicks "create an account" on the login page,
 * they're brought to the "Interested in Volunteering?" page.
 * This is the "Interested In Volunteering?" page.
 */

    error_reporting(-1);
    ini_set('display_errors', 'On');
    set_error_handler("var_dump");
    //var_dump($email);

    if (isset($_POST['send_email']))
    {
        header("Location: /email_CreateAnAccount_Confirmation.php");
        //$email = $_POST['email'];
        $to = $_POST['email'];
        $subject = 'Become A Volunteer';
        $message = 'Hello,' . '/n Thank you for your interest in volunteering at the Wildlife Center of Virginia. Please follow the link below to create an account. http://54.186.42.239/createaccount.php';
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

    <title>Wildlife Center of Virginia | Become A Volunteer</title>

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
                    Thank you for your interest in volunteering at the Wildlife Center of Virginia. Please enter your email to receive instructions on how to create an account.
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form" action="" method="post">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email address" required="">
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Send Email</button>
                            <input type="hidden" name="send_email" value="1"/>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>

</html>