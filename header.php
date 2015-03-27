<?php
require_once('config.php');
if($_SERVER['REQUEST_URI']=='/ras/forgot.php' || $_SERVER['REQUEST_URI']=='/forgot.php'){
		//Do Nothing
}elseif(!isset($_SESSION['user_id'])){
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
		<script src="js/jquery.validate.js"></script>
		<script src="js/common.js"></script>
		<script type="text/javascript" src="js/jquery.tablednd.0.7.min.js"></script>
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
						<li class="upp"><a href="timetable_dashboard.php">Dashboard</a></li>
                        <li class="upp"><a href="">Timetable</a>
						   <ul>
						   		<li>&#8250; <a href="timetable_dashboard.php">List</a></li>
								<?php $user = getPermissions('timetable_dashboard');
									  if($user['add_role'] != '0'){?>								
										<li>&#8250; <a href="generate_timetable.php">Generate</a></li>
								<?php } ?>

                                <?php $user = getPermissions('timetable_view.php');
									  if($user['view'] != '0'){?>	
										<li>&#8250; <a href="timetable_view.php">Table View</a></li>
								<?php } ?>
								<?php $user = getPermissions('month.php');
									  if($user['view'] != '0'){?>	
										<li>&#8250; <a href="month.php">Calendar View</a></li>
								<?php } ?>                                
                           </ul>
						</li>						
						<?php $user = getPermissions('view');
							  if($user['view'] != '0'){?>	
								<li class="upp"><a href="">View</a>
									<ul>
										<?php $user = getPermissions('program_cycles_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="program_cycles_view.php">Program Cycles</a></li>
										<?php } ?>
										<?php $user = getPermissions('classroom_availability_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="classroom_availability_view.php">Classrooms Availabilty</a></li>
										<?php } ?>
										<?php $user = getPermissions('teacher_availability_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
										<?php } ?>
										<?php $user = getPermissions('teacher_activity_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_activity_view.php">Activities</a></li>
										<?php } ?>
										<?php $user = getPermissions('special_activity_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="special_activity_view.php">Special Activities</a></li>
										<?php } ?>
										<?php $user = getPermissions('timetable_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="timetable_view.php">Timetable</a></li>
										<?php } ?>
										<?php $user = getPermissions('month.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="month.php">Calendar</a></li>
										<?php } ?>                             
								   </ul>
								</li>								
						<?php } ?>
						<?php $user = getPermissions('resources');
							  if($user['view'] != '0'){?>	
								<li class="upp"><a href="">Resources</a>
									<ul>
										<?php $user = getPermissions('locations');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="locations_view.php">Locations</a></li>
										<?php } ?>
										<?php $user = getPermissions('buildings');
											  if($user['view'] != '0'){?>	
												 <li>&#8250; <a href="buildings_view.php">Buildings</a></li>
										<?php } ?>
										<?php $user = getPermissions('rooms');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="rooms_view.php">Classrooms</a></li>
										<?php } ?>
										<?php $user = getPermissions('classroom_availability');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="classroom_availability_view.php">Classrooms Availabilty</a></li>
										<?php } ?>
										<?php $user = getPermissions('programs');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="programs_view.php">Programs</a></li>
										<?php } ?>
										<?php $user = getPermissions('program_cycles');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="program_cycles_view.php">Program Cycles</a></li>
										<?php } ?>
										<?php $user = getPermissions('areas');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="areas_view.php">Areas</a></li>
										<?php } ?>
										<?php $user = getPermissions('subjects');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="subject_view.php">Subjects</a></li>
										<?php } ?>
										<?php $user = getPermissions('timeslots');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="timeslots.php">Timeslots</a></li>
										<?php } ?>
										<?php $user = getPermissions('teachers');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_view.php">Teachers</a></li>
										<?php } ?>
										<?php $user = getPermissions('teacher_availability');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
										<?php } ?>
										<?php $user = getPermissions('holidays');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="holidays_view.php">Manage Holidays</a></li>
										<?php } ?>
										<?php $user = getPermissions('teacher_activity');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_activity_view.php">Activity List</a></li>
										<?php } ?>
										<?php $user = getPermissions('special_activity');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="special_activity_view.php">Special Activities</a></li>
										<?php } ?>
										<?php $user = getPermissions('user_management_view.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="user_view.php">User Management</a></li>					  
										<?php } ?>
									</ul>
								</li>
						<?php } ?>
						<?php $user = getPermissions('data upload');
							  if($user['view'] != '0'){?>	
								<li class="upp"><a href="">Data Upload</a>
									<ul>
										<?php $user = getPermissions('session_upload.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="session_upload.php">Session Data</a></li>
										<?php } ?>								
									</ul>
								</li>
						<?php } ?>
						<?php $user = getPermissions('reports');
							  if($user['view'] != '0'){?>	
								<li class="upp"><a href="">Reports</a>
									<ul>
										<?php $user = getPermissions('teacher_rate_report.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_rate_report.php">Rate and Pay Totals</a></li>
										<?php } ?>
										<?php $user = getPermissions('teacher_report.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="teacher_report.php">Timetable Activities</a></li>
										<?php } ?>
										<?php $user = getPermissions('weekly_report.php');
											  if($user['view'] != '0'){?>	
												<li>&#8250; <a href="weekly_report.php">Calender Weekly Report</a></li>
										<?php } ?>
									</ul>
								</li>	
						<?php } ?>
						<?php $user = getPermissions('help.php');
							  if($user['view'] != '0'){?>	
								<li class="upp right"  style="float:right"><a href="help.php"><img src="images/help.png" class="help-img"/></a></li>	
						<?php } ?>										
						<li class="upp right"  style="float:right"><a href="logout.php">Logout</a></li>
						<?php $user = getPermissions('change_password.php');
							  if($user['view'] != '0'){?>	
								<li class="upp right"  style="float:right"><a href="change_password.php">Change Password</a></li>
						<?php } ?>
						
                    </ul>
					<?php } ?>
                </div>
            </div>
<?php
function getPermissions($filename='')
{
	if($filename != '')
		$path = $filename;
	else{
		$script_name = $_SERVER['SCRIPT_NAME'];
		$pathinfo = explode("ras/",$script_name);
		$path = $pathinfo['1'];
	}
	$obj = new Users();
	$user = $obj->getUser($_SESSION['user_id'],$path);
	return $user;
}
?>
