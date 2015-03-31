<?php
require_once('config.php');
if($_SERVER['REQUEST_URI']=='/ras/forgot.php' || $_SERVER['REQUEST_URI']=='/forgot.php'){
		//Do Nothing
}elseif(!isset($_SESSION['user_id'])){
		header('Location: index.php');
}
$user_profiles = getPermissions('calendar_view');
if($user_profiles['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>RAS Admin</title>
        <!--<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />-->
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
								<?php $user_profiles = getPermissions('generate_timetable');
									  if($user_profiles['view'] != '0'){?>								
										<li>&#8250; <a href="generate_timetable.php">Generate</a></li>
								<?php } ?>
                                <?php $user_profiles = getPermissions('timetable_view');
									  if($user_profiles['view'] != '0'){?>	
										<li>&#8250; <a href="timetable_view.php">Table View</a></li>
								<?php } ?>
								<?php $user_profiles = getPermissions('calendar_view');
									  if($user_profiles['view'] != '0'){?>	
										<li>&#8250; <a href="month.php">Calendar View</a></li>
								<?php } ?>                                
                           </ul>
						</li>
						<?php $user_profiles1 = getPermissions('program_cycles');$user_profiles2 = getPermissions('classroom_availability');$user_profiles3 = getPermissions('teacher_availability');$user_profiles4 = getPermissions('teacher_activity');$user_profiles5 = getPermissions('special_activity');$user_profiles6 = getPermissions('timetable_view');$user_profiles7 = getPermissions('calendar_view');
						if($user_profiles1['view'] != '0' || $user_profiles2['view'] != '0' || $user_profiles3['view'] != '0' || $user_profiles4['view'] != '0' || $user_profiles5['view'] != '0' || $user_profiles6['view'] != '0' || $user_profiles7['view'] != '0'){?>
							<li class="upp"><a href="">View</a>
								<ul>
									<?php if($user_profiles1['view'] != '0'){?>	
											<li>&#8250; <a href="program_cycles_view.php">Program Cycles</a></li>
									<?php } ?>
									<?php if($user_profiles2['view'] != '0'){?>	
											<li>&#8250; <a href="classroom_availability_view.php">Classrooms Availabilty</a></li>
									<?php } ?>
									<?php if($user_profiles3['view'] != '0'){?>	
											<li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
									<?php } ?>
									<?php if($user_profiles4['view'] != '0'){?>	
											<li>&#8250; <a href="teacher_activity_view.php">Activities</a></li>
									<?php } ?>
									<?php if($user_profiles5['view'] != '0'){?>	
											<li>&#8250; <a href="special_activity_view.php">Special Activities</a></li>
									<?php } ?>
									<?php if($user_profiles6['view'] != '0'){?>	
											<li>&#8250; <a href="timetable_view.php">Timetable</a></li>
									<?php } ?>
									<?php if($user_profiles7['view'] != '0'){?>	
											<li>&#8250; <a href="month.php">Calendar</a></li>
									<?php } ?>                             
							   </ul>
							</li>
						<?php } ?>
						<?php $user_profiles1 = getPermissions('locations');$user_profiles2 = getPermissions('buildings');$user_profiles3 = getPermissions('rooms');$user_profiles4 = getPermissions('classroom_availability');$user_profiles5 = getPermissions('programs');$user_profiles6 = getPermissions('program_cycles');$user_profiles7 = getPermissions('areas');$user_profiles8 = getPermissions('subjects');$user_profiles9 = getPermissions('timeslots');$user_profiles10 = getPermissions('teachers');$user_profiles11 = getPermissions('teacher_availability');$user_profiles12 = getPermissions('holidays');$user_profiles13 = getPermissions('teacher_activity');$user_profiles14 = getPermissions('special_activity');$user_profiles15 = getPermissions('users');$user_profiles16 = getPermissions('roles');
						if($user_profiles1['view'] != '0' || $user_profiles2['view'] != '0' || $user_profiles3['view'] != '0' || $user_profiles4['view'] != '0' || $user_profiles5['view'] != '0' || $user_profiles6['view'] != '0' || $user_profiles7['view'] != '0' || $user_profiles8['view'] != '0' || $user_profiles9['view'] != '0' || $user_profiles10['view'] != '0' || $user_profiles11['view'] != '0' || $user_profiles12['view'] != '0' || $user_profiles13['view'] != '0' || $user_profiles14['view'] != '0' || $user_profiles15['view'] != '0' || $user_profiles16['view'] != '0'){?>
							<li class="upp"><a href="#">Resources</a>
								<ul>
									<?php if($user_profiles1['view'] != '0'){?>	
											<li>&#8250; <a href="locations_view.php">Locations</a></li>
									<?php } ?>
									<?php if($user_profiles2['view'] != '0'){?>	
											 <li>&#8250; <a href="buildings_view.php">Buildings</a></li>
									<?php } ?>
									<?php if($user_profiles3['view'] != '0'){?>	
											<li>&#8250; <a href="rooms_view.php">Classrooms</a></li>
									<?php } ?>
									<?php if($user_profiles4['view'] != '0'){?>	
											<li>&#8250; <a href="classroom_availability_view.php">Classrooms Availabilty</a></li>
									<?php } ?>
									<?php if($user_profiles5['view'] != '0'){?>	
											<li>&#8250; <a href="programs_view.php">Programs</a></li>
									<?php } ?>
									<?php if($user_profiles6['view'] != '0'){?>	
											<li>&#8250; <a href="program_cycles_view.php">Program Cycles</a></li>
									<?php } ?>
									<?php if($user_profiles7['view'] != '0'){?>	
											<li>&#8250; <a href="areas_view.php">Areas</a></li>
									<?php } ?>
									<?php if($user_profiles8['view'] != '0'){?>	
											<li>&#8250; <a href="subject_view.php">Subjects</a></li>
									<?php } ?>
									<?php if($user_profiles9['view'] != '0'){?>	
											<li>&#8250; <a href="timeslots.php">Timeslots</a></li>
									<?php } ?>
									<?php if($user_profiles10['view'] != '0'){?>	
											<li>&#8250; <a href="teacher_view.php">Teachers</a></li>
									<?php } ?>
									<?php if($user_profiles11['view'] != '0'){?>	
											<li>&#8250; <a href="teacher_availability_view.php">Teacher Availabilty</a></li>
									<?php } ?>
									<?php if($user_profiles12['view'] != '0'){?>	
											<li>&#8250; <a href="holidays_view.php">Manage Holidays</a></li>
									<?php } ?>
									<?php if($user_profiles13['view'] != '0'){?>	
											<li>&#8250; <a href="teacher_activity_view.php">Activity List</a></li>
									<?php } ?>
									<?php if($user_profiles14['view'] != '0'){?>	
											<li>&#8250; <a href="special_activity_view.php">Special Activities</a></li>
									<?php } ?>
									<?php if($user_profiles15['view'] != '0'){?>	
											<li>&#8250; <a href="user_view.php">User Management</a></li>
									<?php } ?>
									<?php if($user_profiles16['view'] != '0'){?>	
											<li>&#8250; <a href="role.php">Role Management</a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
						<?php $user_profiles = getPermissions('session_upload');
							  if($user_profiles['view'] != '0'){?>	
								<li class="upp"><a href="">Data Upload</a>
									<ul>							
										<li>&#8250; <a href="session_upload.php">Session Data</a></li>								
									</ul>
								</li>
						<?php } ?>
						<?php $user_profiles1 = getPermissions('teacher_rate_report');
							  $user_profiles2 = getPermissions('teacher_report');
							  $user_profiles3 = getPermissions('weekly_report');
							  if($user_profiles1['view'] != '0' || $user_profiles2['view'] != '0' || $user_profiles3['view'] != '0')
							  {?>
								<li class="upp"><a href="">Reports</a>
									<ul>
									<?php if($user_profiles1['view'] != '0'){?>
										<li>&#8250; <a href="teacher_rate_report.php">Rate and Pay Totals</a></li>
									<?php } ?>
									<?php if($user_profiles2['view'] != '0'){?>
										<li>&#8250; <a href="teacher_report.php">Timetable Activities</a></li>
									<?php } ?>
									<?php if($user_profiles3['view'] != '0'){?>
										<li>&#8250; <a href="weekly_report.php">Calender Weekly Report</a></li>
									<?php } ?>
									</ul>
								</li>
						<?php } ?>
						<?php $user_profiles = getPermissions('help');
							  if($user_profiles['view'] != '0'){?>	
								<li class="upp right"  style="float:right"><a href="help.php"><img src="images/help.png" class="help-img"/></a></li>
						<?php } ?>
						<li class="upp right"  style="float:right"><a href="logout.php">Logout</a></li>
						<?php $user_profiles = getPermissions('change_password');
							  if($user_profiles['view'] != '0'){?>	
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
	$obj = new Users();
	$user_details = $obj->getUser($_SESSION['user_id'],$path);
	return $user_details;
}
?>
