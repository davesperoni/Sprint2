<?php
/**
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 4/2/17
 * Time: 2:25 PM
 */

?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | User Profile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_pic.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Jane Doe</strong>
                             </span> <span class="text-muted text-xs block">Administrator<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li class = "active">
                    <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li>
                    <a href="#"><i class="fa fa-clipboard"></i> <span class="nav-label">Applications</span></a>
                </li>

            </ul>
        </div>
    </nav> <!-- end of navigation -->


    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">


                    <li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper-prof border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <img src="img/profileheader.jpg" class="img-responsive">
            </div>

        </div>
        <div class="wrapper-prof wrapper-content-prof">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div>
                            <div class="ibox-content">
                                <div class="profile">
                                    <img src="img/raina.png" class="img-responsive col-xs-8">
                                </div>
                                <div class="col-xs-1">
                                    <div class="edit">
                                        <!-- Button trigger modal -->

                                        <a href="#" data-toggle="modal" data-target="#profilePicture"><i class="fa fa-pencil edit"></i></a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="profilePicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title pull-left" >Change Profile Picture</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body btmSpace">

                                                        <div class="fileinput fileinput-new pull-left moveDown" data-provides="fileinput">
                                                            <span class="btn btn-default btn-file"><input type="file"></span>
                                                            <span class="fileinput-filename"></span>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                        <button type="button" class="btn-edit-form">UPLOAD</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- end of profile modal -->

                                    </div>
                                </div>
                            </div>



                            <div class="ibox-content profile-content">
                                <!-- trigger modal pencil icon -->
                                <a href="#" data-toggle = "modal" data-target = "#myModal"><i class="fa fa-pencil edit pull-right moveDown"></i></a>

                                <!-- modal content aka FORM THAT POPS OPEN ON CLICK OF PENCIL -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title-2 no-margin" id="myModalLabel">Edit Profile Information</h4>
                                                <!---------- ADD NEW CLASS NAME TO VIVIANN'S FILE -->
                                            </div>
                                            <div class="modal-body">
                                                <form  class = "pop-up-form" action="/action_page.php">
                                                    <h2 class = "form-title"> PERSONAL INFORMATION </h2>
                                                    <label>Phone:</label> <input type = "text" name = "phone" size = "12"><br>
                                                    <label>Email:</label> <input type = "text" name = "phone" size = "30"><br>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                <button type="button" class="btn-edit-form">SAVE CHANGES</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end modal -->

                                <!-- continue profile content -->
                                <h2>Raina Krasner</h2>
                                <h4>Outreach Coordinator</h4>
                                <p>(703) 123-4567<br/>
                                    <em>rkrasner@wildlifecenter.org</em></p>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <a href="#" data-toggle = "modal" data-target = "#bioModal"><i class="fa fa-pencil edit pull-right moveDown"></i></a>

                    <!-- modal content aka FORM THAT POPS OPEN ON CLICK OF PENCIL -->
                    <div class="modal fade" id="bioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title-2 no-margin" id="myModalLabel">Edit Bio Information</h4>
                                    <!---------- ADD NEW CLASS NAME TO VIVIANN'S FILE -->
                                </div>
                                <div class="modal-body">
                                    <form  class = "pop-up-form" action="/action_page.php">
                                  <textarea type= "text" name= "bio" rows="4" cols="70">
                                  </textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                    <button type="button" class="btn-edit-form">SAVE CHANGES</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- end modal -->
                    <div class="meetadmin">
                        <h3>Meet Raina</h3>
                        <p>Raina grew up in the city of Pittsburgh until her family relocated to the seaside-suburbs of Ocean County, New Jersey. At an early age, Raina developed a love for exploring the natural world, as well as a deep appreciation of and respect for wildlife. While pursuing a degree in art and liberal studies at Rutgers University, and eventually Stockton College, Raina took courses in wildlife studies to better develop her understanding of the natural world. During and after college, Raina spent several years working for large and small legal and education non-profit organizations, developing her business sense and client relations skills. After accepting a position as a naturalist at Cattus Island County Park in Toms River, New Jersey, Raina realized her true passion of caring for wildlife and teaching people about human-wildlife interactions. Following that passion, Raina relocated to Virginia in August 2012 to begin her career as an outreach coordinator at the Wildlife Center. As outreach coordinator, some of Raina’s responsibilities include scheduling and conducting public education programs, posting patient updates on the Wildlife Center website, and participating in the moderated discussions aligned with the “Critter Cam”.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>





<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity -->
<script src="js/demo/peity-demo.js"></script>

</body>

</html>
