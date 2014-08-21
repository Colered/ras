<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>RAS Admin</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
		<link rel="stylesheet" type="text/css" media="all" href="js/jsDatePick_ltr.css" />
        <script type="text/javascript" src="js/1.7.2.jquery.min.js"></script>
		<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
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
                    <ul>
                        <li class="upp"><a href="dashboard.php">Dashboard</a></li>
                        <li class="upp"><a href="">Resources</a>	
                            <ul>
                                <li>&#8250; <a href="programs_view.php">Programs</a></li>
                                <li>&#8250; <a href="teacher_view.php">Teachers</a></li>
                                <li>&#8250; <a href="subject_view.php">Subjects</a></li>
                                <li>&#8250; <a href="timeslots.php">Timeslots</a></li>
                                <li>&#8250; <a href="teacher_activity_view.php">Teacher Activity</a></li>
                                <li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
                                <li>&#8250; <a href="buildings_view.php">Building</a></li>
                                <li>&#8250; <a href="rooms_view.php">Classrooms</a></li>
                                <li>&#8250; <a href="areas_view.php">Areas</a></li>
                                <li>&#8250; <a href="roles_management_view.php">Role Management</a></li>
                                <li>&#8250; <a href="user_management_view.php">User Management</a></li>
								<li>&#8250; <a href="generate_timetable.php">Generate Timetable</a></li>
                            </ul> 
                        </li>
                        <li class="upp"><a href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
	<div id="content">

		<div id="main">
			
			<div class="full_w">
				<div class="h_title">View</div>
				<form action="" method="post">
				<div class="custtable_left">
                            <div class="custtd_left">
                                <h2>
                                    Name<span class="redstar">*</span></h2>
                            </div>
                           
							<div class="clear"></div>
						   <div class="txtfield">
                           </div>
						   
                            
                        </div>	
				</form>
			</div>
			<div class="clear"></div>
			
		</div>
		<div class="clear"></div>
	</div>
<?php include('footer.php');?>

