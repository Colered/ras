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

$program_name = $objP->getProgramYearName($program_year_id);
$subject_name = $objT->getFielldVal('subject','subject_name','id',$subject_id);
$sessionName = $objT->getFielldVal('subject_session','session_name','id',$sessionid);

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
                    <div id="activityAddMore" style="padding:50px 0px 0px 100px;">
                    <div id="activityReset" style="padding-left:10px;"><input class="buttonsub" type="button" value="Reset" name="btnTeacherActReset" id="btnTeacherActReset" onclick="reset_reserved_flag();"></div>
					<input type="hidden" name="program_year_id" value="<?php echo $program_year_id;?>" />
					<input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />
					<input type="hidden" name="sessionid" value="<?php echo $sessionid;?>" />

                    <?php
						//room dropdown
						$room_dropDwn = $objB->getRoomsDropDwn();
						//timeslot dropdown
						$tslot_dropDwn = $objTS->getTimeSlotDropDwn();
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr>';
						echo '<th>Reserved</th>';
						echo '<th>Program</th>';
						echo '<th>Subject</th>';
						echo '<th>Session</th>';
						echo '<th>Teacher</th>';
						echo '<th>Room</th>';
						echo '<th>Timeslot</th>';
						echo '<th>Date</th>';
						echo '<th>&nbsp;</th>';
						echo '</tr>';
						$slqTA="SELECT * FROM teacher_activity WHERE program_year_id = '".$program_year_id."' AND subject_id='".$subject_id."' AND session_id='".$sessionid."'";
						$relT = mysqli_query($db, $slqTA);
						while($data= mysqli_fetch_array($relT)){
						    $reserved_flag_checked = ($data['reserved_flag']==1) ? "checked" : '';
							echo '<tr>';
							echo '<td align="center"><input type="hidden" name="activitiesArr[]" value="'.$data['id'].'">';
							echo '<input type="radio" name="reserved_flag" value="'.$data['id'].'" '.$reserved_flag_checked.' onclick="roomTslotValidate(\''.$data['id'].'\');"></td>';
							echo '<td>'.$objS->getFielldVal("program_years","name","id",$program_year_id).'</td>';
							echo '<td>'.$objS->getSubjectByID($data['subject_id']).'</td>';
							echo '<td>'.$objS->getSessionByID($data['session_id']).'</td>';
							echo '<td>'.$objT->getTeacherByID($data['teacher_id']).'<input type="hidden" name="reserved_teacher_id_'.$data['id'].'" value="'.$data['teacher_id'].'"></td>';

							echo '<td><select name="room_id_'.$data['id'].'" id="room_id_'.$data['id'].'" class="activity_row_chk" disabled>';
							echo '<option value="">--Room--</option>';
							echo $room_dropDwn;
							echo '</select><br><span id="room_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose room</span></td>';
							echo '<script type="text/javascript">jQuery("#room_id_'.$data['id'].'").val("'.$data['room_id'].'")</script>';

							echo '<td><select name="tslot_id_'.$data['id'].'" id="tslot_id_'.$data['id'].'" class="activity_row_chk" disabled>';
							echo '<option value="">--Time Slot--</option>';
							echo $tslot_dropDwn;
							echo '</select><br><span id="tslot_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose time slot</span></td>';
							echo '<script type="text/javascript">jQuery("#tslot_id_'.$data['id'].'").val("'.$data['timeslot_id'].'")</script>';

							echo '<td><input type="text" size="12" id="activityDateCal_'.$data['id'].'" class="activityDateCal" name="activityDateCal_'.$data['id'].'" value="'.$objT->formatDate($data['act_date']).'" readonly disabled/><br><span id="activityDate_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose date</span></td>';
							echo '<td><input class="buttonsub btnTeacherCheckAbail" type="button" value="Check Availability" name="btnTeacherCheckAbail_'.$data['id'].'" id="btnTeacherCheckAbail_'.$data['id'].'" onclick="checkActAvailability(\''.$program_year_id.'\',\''.$subject_id.'\',\''.$sessionid.'\',\''.$data['teacher_id'].'\',\''.$data['id'].'\');" style="display:none;"/>
							<br><span class="rfv_error" id="room_tslot_availability_avail_'.$data['id'].'" style="color:#ff0000;display:none;">Available</span><span class="rfv_error" id="room_tslot_availability_not_avail_'.$data['id'].'" style="color:#ff0000;display:none;">Not Available</span></td>';
							echo '</tr>';
                            unset($_SESSION['act_'.$data['id']]);
                            if($data['reserved_flag']==1){
                              	echo '<script type="text/javascript">roomTslotValidateEdit(\''.$data['id'].'\');</script>';
                            }
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

