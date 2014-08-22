<?php
require_once('config.php');
if(!isset($_SESSION['user_id'])){
	header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>RAS Admin</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="js/jquery-ui.css">
        <script src="js/jquery-1.10.2.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/common.js"></script>
		<script type="text/javascript">
            $(function() {
                $(".box .h_title").not(this).next("ul").hide("normal");
                $(".box .h_title").not(this).next("#home").show("normal");
                $(".box").children(".h_title").click(function() {
                    $(this).next("ul").slideToggle();
                });
            });
        </script>
	  </head>
    <body>
        <div class="wrap">
            <div id="header">
                <div id="top">
                    <div class="left">
                        <a href="index.php"><img src="images/logo.png"  border="0" class="logo-img"/></a>
                    </div>
                    <div class="right">
                        <div class="align-right">
                        </div>
                    </div>
                </div>
                <div id="nav">
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ ?>
					<ul>
                        <li class="upp"><a href="">Resources</a>
                            <ul>
                                <li>&#8250; <a href="programs_view.php">Programs</a></li>
								<li>&#8250; <a href="group_view.php">Programs Group</a></li>
                                <li>&#8250; <a href="teacher_view.php">Teachers</a></li>
                                <li>&#8250; <a href="subject_view.php">Subjects</a></li>
                                <li>&#8250; <a href="timeslots.php">Timeslots</a></li>
                                <li>&#8250; <a href="teacher_activity_view.php">Teacher Activity</a></li>
                                <li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
                                <li>&#8250; <a href="buildings_view.php">Building</a></li>
                                <li>&#8250; <a href="rooms_view.php">Classrooms</a></li>
								<li>&#8250; <a href="classroom_availability_view.php">Classrooms Availabilty</a></li>
								<li>&#8250; <a href="areas_view.php">Areas</a></li>
                                <li>&#8250; <a href="roles_management_view.php">Role Management</a></li>
                                <li>&#8250; <a href="user_management_view.php">User Management</a></li>
								<li>&#8250; <a href="timetable.php">Timetable Management</a></li>
                            </ul>
                        </li>
						<li class="upp right"><a href="logout.php/">Logout</a></li>
                    </ul>
					<?php } ?>
                </div>
            </div>
