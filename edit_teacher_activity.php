<?php
include('header.php');
$objT = new Teacher();
$objP = new Programs();
$objS = new Subjects();
$objB = new Buildings();
$objTS = new Timeslot();

$activity_id = base64_decode($_GET['edit']);
$program_year_id = base64_decode($_GET['pyid']);
$subject_id = base64_decode($_GET['sid']);
$sessionid = base64_decode($_GET['sessId']);
$teacher_id = base64_decode($_GET['tid']);

$program_name = $objP->getProgramYearName($program_year_id);
$subject_name = $objT->getFielldVal('subject','subject_name','id',$subject_id);
$sessionName = $objT->getFielldVal('subject_session','session_name','id',$sessionid);
$teacher_name = $objT->getFielldVal('teacher','teacher_name','id',$teacher_id);


?>

<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher Activity</div>
			<form name="frmTactivity" id="frmTactivity" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="edit_teacher_activity" />
			  <?php if(isset($_GET['edit'])){?>
					<input type="hidden" name="form_edit_id" value="<?php echo $_GET['edit'];?>" />
			  <?php } ?>
                <div class="custtable_left">
                  <?php if($program_name<>""){?>
						<div class="custtd_left">
							<h2>Program:</h2>
						</div>
						<div class="txtfield">
						   <?php echo $program_name;?>
						</div>
                   <?php } ?>
                    <div class="clear"></div>
						<?php if($subject_name<>""){?>
						<div class="custtd_left">
							<h2>Subject</h2>
						</div>
						<div class="txtfield">
						  <?php echo $subject_name;?>
						</div>
                    <?php } ?>
                    <div class="clear"></div>
                    <?php if($sessionName<>""){?>
						<div class="custtd_left">
							<h2>Session:</h2>
						</div>
						<div class="txtfield">
						   <?php echo $sessionName;?>
						</div>
					<?php } ?>
                    <div class="clear"></div>
                    <?php if($teacher_name<>""){?>
						<div class="custtd_left">
							<h2>Teacher:</h2>
						</div>
						<div class="txtfield" style="float:left">
							<?php echo $teacher_name;?>
						</div>
                    <?php } ?>
                    <div class="clear"></div>
					<div id="activityReset" style="display:none;padding-left:10px;"><input class="buttonsub" type="button" value="Reset" name="btnTeacherActReset" id="btnTeacherActReset" onclick="reset_reserved_flag();"></div>
                    <div id="activityAddMore" style="padding-left:100px;">
					<input type="hidden" name="program_year_id" value="<?php echo $program_year_id;?>" />
					<input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />
					<input type="hidden" name="sessionid" value="<?php echo $sessionid;?>" />
					<input type="hidden" name="teacher_id" value="<?php echo $teacher_id;?>" />

                    <?php
						//room dropdown
						$room_dropDwn = $objB->getRoomsDropDwn();
						//timeslot dropdown
						$tslot_dropDwn = $objTS->getTimeSlotDropDwn();
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr>';
						echo '<th>Reserved</th>';
						echo '<th>Room</th>';
						echo '<th>Timeslot</th>';
						echo '</tr>';
						$slqTA="SELECT * FROM teacher_activity WHERE program_year_id = '".$program_year_id."' AND subject_id='".$subject_id."' AND teacher_id='".$teacher_id."'";
						$relT = mysqli_query($db, $slqTA);
						while($data= mysqli_fetch_array($relT)){
						    $reserved_flag_checked = ($data['reserved_flag']==1) ? "checked" : '';
						    echo '<input type="hidden" name="activitiesArr[]" value="'.$data['id'].'" />';
							echo '<tr>';
							echo '<td align="center"><input type="radio" name="reserved_flag" value="'.$data['id'].'" '.$reserved_flag_checked.'></td>';
							echo '<td><select name="room_id_'.$data['id'].'" id="room_id_'.$data['id'].'">';
							echo '<option value="0">--Room--</option>';
							echo $room_dropDwn;
							echo '</select>';
							echo '<script type="text/javascript">jQuery("#room_id_'.$data['id'].'").val("'.$data['room_id'].'")</script>';
							echo '</td>';
							echo '<td><select name="tslot_id_'.$data['id'].'" id="tslot_id_'.$data['id'].'">';
							echo '<option value="0">--Time Slot--</option>';
							echo $tslot_dropDwn;
							echo '</select><span class="error">&nbsp;'.$_SESSION['act_'.$data['id']].'</span>';
							echo '<script type="text/javascript">jQuery("#tslot_id_'.$data['id'].'").val("'.$data['timeslot_id'].'")</script>';
							echo '</td>';
							echo '</tr>';
                            unset($_SESSION['act_'.$data['id']]);
						}
            			echo '</table>';
                    ?>
                    </div>
                    <div><br /><br /><br /><br /></div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="Edit Activity">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'teacher_activity_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

