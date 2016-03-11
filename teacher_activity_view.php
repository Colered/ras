<?php
include('header.php');
$user = getPermissions('teacher_activity');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$user1 = getPermissions('accept_allocation');
$objT = new Teacher();
$objB = new Buildings();
$objTime = new Timetable();
$result_time = $objTime->checkTimetable();
$row_time = $result_time->fetch_assoc();
$result_table = $objTime->getTimetablesData();
$row_table = $result_table->fetch_assoc();
$result_id = $objTime->getLowestActDetail();
$row_id = $result_id->fetch_assoc();
$result_act_id = $objTime->getLowestTeachAct($row_id['activity_id']);
$row_act_id = $result_act_id->fetch_assoc();
$objHoliday = new Holidays();
$result_holiday = $objHoliday->viewHoliday();
$holidays = $allProgramExc = array();
while($holidaysArr = $result_holiday->fetch_assoc()){
	$holidays[] = $holidaysArr['holiday_date'];
}
$objPrograms = new Programs();
$programExc = $objPrograms->getAllPgmExceptionData();
while($excepArr = $programExc->fetch_assoc()){
	$allProgramExc[][$excepArr['program_year_id']] = $excepArr['exception_date'];
}

$activity_filter_val = (isset($_POST['activity_color_filter']) && $_POST['activity_color_filter']!="")?$_POST['activity_color_filter']:'';
$addSpecialAct = isset($_POST['addSpecialAct'])?$_POST['addSpecialAct']:'';


?>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	oTable = $('#datatables').dataTable({
		"stateSave": true,
	    "aaSorting":[[1, "asc"]],
		"bJQueryUI" : true,
		"sPaginationType" : "full_numbers",
		"aLengthMenu": [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    	],
		"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ 0 ] }
			],
		"fnDrawCallback": function( settings ) {
				//managing the "Select all" checkbox
				// everytime the table is drawn, it checks if all the 
				//checkboxes are checked and if they are, then the select all
				// checkbox in the table header is selected
				var allChecked = true;
				$('#datatables tbody tr').each(function() {
				  $('.activityCkb').each(function() { 
						if (!$(this).is(':checked')) {
								allChecked = false;
							}
						});
					});
				var desbCkbCnt = $(".ckbDisabled").length;
				var allCkbCnt =$(".allCKbCls").length;
				if(desbCkbCnt==allCkbCnt){
					$('#ckbCheckAllActivity').prop('checked', false);
				}else{
					$('#ckbCheckAllActivity').prop('checked', allChecked);
				}
			},
	});
			
			
})
function activityFilter()
{
	$('#act_view_filter').submit();
}
</script>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content">
    <div id="main">
    <?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; $_SESSION['succ_msg']="";} ?>
        <div class="full_w">
            <div class="h_title">Activity View<!--<a href="teacher_activity.php" class="gird-addnew" title="Add New Activity">Add new</a>--></div>
			<?php
			if($result_time && $row_id['date_upd'] != $row_act_id['date_update'])
			{
				$readonly = 'class="buttonsub"';				
			}else{				
				$readonly = 'class="buttonsub" disabled="disabled" style="background-color:#CCCCCC; background-image:none"';
			}?>
			<div style="float:right">
				<!--<form action="postdata.php" name="acc_allo" id="acc_allo" method="post">
				<input type="hidden" value="acceptAllocation" name="form_action">
				<input  type="button" class="buttonsub"  disabled="disabled" value="Accept Allocation" name="btnacceptallo" id="btnacceptallo"/>
				</form>-->
				<div class = "activity-color-filteration" style="margin-right:420px;"> 
					<form id="act_view_filter" name="act_view_filter" method="post" action="teacher_activity_view.php" novalidate="novalidate">	
						<strong>Activity Filter  </strong>
						<select id="activity_color_filter" name="activity_color_filter" class="select-filter" onchange="activityFilter();" style="width:110px;" > 
							<option value="" selected="selected">--Select--</option>
							<option value="1" <?php if($activity_filter_val == '1'){?> selected="selected"}<?php }?>>Allocated</option>
							<option value="2" <?php if($activity_filter_val == '2'){?> selected="selected"}<?php }?>>Floating</option>
							<option value="3" <?php if($activity_filter_val == '3'){?> selected="selected"}<?php }?>>Out of range</option>
						</select>
						<input type="checkbox" name="addSpecialAct" <?php if(isset($_POST['addSpecialAct']) && $_POST['addSpecialAct']==1){ echo "checked"; } ?> value="1" onclick="activityFilter();" /> Include special activities (Recess and Group Meetings)
					</form>
				</div>
				<?php if($user1['view'] != '0'){?>
				<div class="btnAcceptAllocation" style="margin-left:10px; margin-right:10px;"> <input  type="button" <?php /*?><?php echo $readonly;?><?php */?> class="buttonsub" value="Accept Allocation" name="btnacceptallo" id="btnacceptallo" onclick="acceptAllocationFun();"/></div> 
				<?php } ?>
				<?php if($user1['view'] != '0'){?>
				<div class="btnAcceptAllocation"> <input  type="button" <?php /*?><?php echo $readonly;?><?php */?> class="buttonsub" value="Force-Swap 2 Activities" name="btnforceswap" id="btnforceswap" onclick="forceSwap2Act();"/></div>
				<?php } ?>
			</div>
            <table id="datatables" class="display tblActivity">
                <thead>
                    <tr>
					<?php if($user1['view'] != '0'){?>
					    <th><input type="checkbox" id="ckbCheckAllActivity" value="Select all" title="Select All"/></th>
					<?php } ?>
                        <th>ID</th>
                        <th>Activity</th>
                        <th>Program</th>
						<th>Special Activity Name</th>
                        <th>Subject</th>
                        <th>Session</th>
                        <th>Teacher</th>
                        <th>Class Room</th>
                        <th>Date</th>
                        <th>Timeslot</th>
                        <th>PreAllocated</th>
                        <th>Allocation Status</th>
						<th>Reason</th>
                        <?php if($user['delete_role'] != '0'){?>
								<th>Action</th>
						<?php } ?>
                    </tr>
                </thead>
                <tbody>
				<?php
					$result = $objT->getTeachersActFilterView($activity_filter_val, $addSpecialAct);
					$result_sess = $objT->getSessionFromTT();
					$result_acts = $objT->getActsFromTT();
					$session_array = array();
					$actIdWithAssignReason = $actUnallocatnReason = array();

					if($result->num_rows){
						while($row = $result->fetch_assoc())
						{ 
							$class='';
							$ts_array = explode(",",$row['timeslot_id']);
							$min_ts_id = $ts_array[0];
							$max_ts_id = $ts_array[count($ts_array)-1];
							if($row['act_date'] != '0000-00-00' && $row['act_date'] < $row_table['start_date'] || $row['act_date'] > $row_table['end_date'] || !in_array($row['program_year_id'],explode(",",$row_table['programs'])))
							{
								$trBColor1 = ' style="background-color:#66CCFF; color:#FFFFFF;"';
								$tdColor = ' style="color:#FFFFFF;"';
								$class ="out-of-range";
							 }else{
								if(!empty($result_sess) && !in_array($row['session_id'],$session_array) && !in_array($row['session_id'],$result_sess))
								{
								 	$trBColor1 = ' style="background-color:#FF0000; color:#FFFFFF;"';
								 	$tdColor = ' style="color:#FFFFFF;"';
								 	$session_array[] = $row['session_id'];
									$class = "unallocated-activity";
									//$row['reason'] = '';
								}else{
								 	$trBColor1 = '';
								 	$tdColor = '';
									$class = 'floating-activity';
									//$row['reason'] = '';
									}
							 }
							if($row['session_id'] == '0' && !in_array($row['id'],$result_acts))
							{
								$trBColor1 = ' style="background-color:#FF0000; color:#FFFFFF;"';
								$tdColor = ' style="color:#FFFFFF;"';
								$session_array[] = $row['session_id'];
								$class = "unallocated-activity";
							}
							$email = (trim($row['email'])<>"") ? '('.$row['email'].')':'';
							$teacher_str = $row['teacher_name'].$email;
							if($row['reason_flag'] == 'Teaching Session Jointly')
							{
								$teacher_array = explode(",",$row['teacher_id']);
								$teachers_names = array();
								foreach($teacher_array as $teacher_id)
								{
									$t_name = $objT->getTeacherByID($teacher_id);
									$teachers_names[] = $t_name;
								}
								$teacher_str = implode(" , ",$teachers_names);
							}							
							if($row['reserved_flag']==1)
							   $res_flag = "Yes";
							else
							  $res_flag = "No";
							  $trBColor=($row['reserved_act_id']<>"") ? ' style="background-color:#90EE90;"':'';
							  $class_allocated="";
							  if($row['reserved_act_id']<>"" && $row['reserved_act_id']<>"NULL"){
							  		$class_allocated='allocated-activity';
									$row['reason'] = '';
								}
						?>
						
						<tr<?php echo $trBColor;echo $trBColor1;?> class=<?php if($trBColor == ''){echo $class;}else{echo $class_allocated ;}?>>
						<?php if($user1['view'] != '0'){?>
					<?php /*?>		<td <?php echo $tdColor;?> class="align-center"><?php echo ($row['reserved_act_id']<>"" && $row['reserved_flag']!= "1")?'<input type="checkbox" value="'.$row['id'].'" name="activity_allocation[]" class="activityCkb allCKbCls" /></td>':'<input type="checkbox" value="'.$row['id'].'" name="activity_allocation[]" disabled="disabled" class=" ckbDisabled allCKbCls" />'?></td><?php */?>
							
							<td <?php echo $tdColor;?> class="align-center"><input type="checkbox" value="<?php echo $row['id']; ?>" name="activity_allocation[]" class="activityCkb allCKbCls" /></td>
						<?php } ?>
							<td <?php echo $tdColor;?> class="align-center"><?php echo $row['id'];?></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="subjects.php?edit=<?php echo base64_encode($row['subject_id']);?>" target="_blank"><?php echo $row['name'];?></a></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="program_cycles.php?edit=<?php echo base64_encode($row['program_year_id']);?>" target="_blank"><?php echo $row['program_name'];?></a></td>
							<td><?php echo $row['special_activity_name'];?></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="subjects.php?edit=<?php echo base64_encode($row['subject_id']);?>" target="_blank"><?php echo $row['subject_name'];?></a></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="subjects.php?edit=<?php echo base64_encode($row['subject_id']);?>" target="_blank"><?php echo $row['session_name'];?></a></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="teacher_availability.php?tid=<?php echo base64_encode($row['teacher_id']);?>" target="_blank"><?php echo $teacher_str;?></a></td>
							<td class="act_color"<?php echo $tdColor;?>><a href="classroom_availability.php?rid=<?php echo $row['room_id'];?>" target="_blank"><font color="">
								<?php
									if(($row['reserved_act_id']<>"" && $row['reserved_flag']!= "1")){
								 		echo '<font class="unreservedAlloctedAct">'. $objB->getRoomFullName($row['reserverd_room_id']).'</font>';
									}else{
										echo $objB->getRoomFullName($row['room_id']) ;
									}
								 ?>
							</a></td>
							<td<?php echo $tdColor;?>>
								<?php 
								if(($row['reserved_act_id']<>"" && $row['reserved_flag']!= "1")){
									if($row['date'] != "0000-00-00" && $row['date'] != null){
										$date = '<font class="unreservedAlloctedAct">'.date("Y-m-d",strtotime($row['date'])).'<font>';
									}else{
										$date = "";
									}
								}else{								
									if($row['act_date'] != "0000-00-00" && $row['act_date'] != null){
										$date = date("Y-m-d",strtotime($row['act_date']));
									}else{
										$date = "";
									}
								}	
								echo $date;
								?>
							</td>
							<td<?php echo $tdColor;?>>
								
								<?php 
								    if(($row['reserved_act_id']<>"" && $row['reserved_flag']!= "1")){
									 	echo '<font class="unreservedAlloctedAct">'.$row['timeslot'].'<font>';
									 }else{
										echo $objT->getTimeslotById($min_ts_id,$max_ts_id);
									 }
								?></td>
							<td class="align-center"<?php echo $tdColor;?>><?php echo $res_flag;?></td>
							<td class="align-center"<?php echo $tdColor;?>><?php echo ($row['reserved_act_id']<>"")? 'Allocated':'Floating';?></td>
							<td class="align-center"<?php echo $tdColor;?>><?php 
							//check if the date is an exception date or a holiday for program
							if($row['reserved_act_id']==""){
								if($row['reason']<>""){
									echo $row['reason'];
								}else if(($row['reason']=="") && (in_array($row['act_date'], $holidays))){ //check if its an holiday
									echo "It is a Holiday <br/>";
									$actIdWithAssignReason[] = $row['id'];
									$actUnallocatnReason[] = "It is a Holiday <br/>";
								}else{
									//check for an program exceptional date
									foreach($allProgramExc as $key=> $value)
									{
										foreach($value as $key=> $value){
											if(($key == $row['program_year_id']) && ($value == $row['act_date'])){
												echo "Program is not available as it is an exceptional date";
												$actIdWithAssignReason[] = $row['id'];
												$actUnallocatnReason[] = "Program is not available as it is an exceptional date";
											}
										}
									}
								}
								//check if any normal activity has been allocated before this recess allocation
								if(($row['reason']=="") && ($row['reserved_flag']== "3") && (($objPrograms->checkIfNormalActExistOnSelDay($row['program_year_id'], $row['act_date'], $min_ts_id, $max_ts_id )) ==0) && (!in_array($row['id'], $actIdWithAssignReason))){
										echo "No normal session/activity has been allocated bafore this recess activity on the selected day";
										$actIdWithAssignReason[] = $row['id'];
										$actUnallocatnReason[] = "No normal session/activity has been allocated bafore this recess activity on the selected day";
								}
								//check if program is available on the given date and time
								if(($row['reason']=="") && (!in_array($row['id'], $actIdWithAssignReason)) && ($row['program_year_id'] !="") && ($row['act_date'] !="" && $row['timeslot_id']!="")){
										$finalDate  = str_replace('-', '', $row['act_date']);
										$getProgramAvailability = $objPrograms->getAvailabilityOfProgram($row['program_year_id'], $finalDate, $row['timeslot_id']);
										if(count($getProgramAvailability)==0){
											echo "Program is not available on selected date and time";
											$actIdWithAssignReason[] = $row['id'];
											$actUnallocatnReason[] = "Program is not available on selected date and time";
										}
								}
							}
							?></td>
							<?php if($user['delete_role'] != '0'){?>
							<td class="align-center" id="<?php echo $row['id'] ?>">
								<?php /*<a href="edit_teacher_activity.php?edit=<?php echo base64_encode($row['id']);?>&pyid=<?php echo base64_encode($row['program_year_id']);?>&cycle_id=<?php echo base64_encode($row['cycle_id']);?>&sid=<?php echo base64_encode($row['subject_id']);?>&sessId=<?php echo base64_encode($row['session_id']);?>" class="table-icon edit" title="Edit"></a><?php */ ?>
								<a href="#" class="table-icon delete" onClick="deleteTeacherActivity('<?php echo $row['id'] ?>')"></a>
							</td>
							<?php } ?>
						</tr>
					<?php } ?>
				<?php } ?>
				</tbody>
            </table>
			<?php 
			// add all reasons to database
			if(count($actIdWithAssignReason)>0){
				$objTime->addBulkReasonforActivities($actIdWithAssignReason, $actUnallocatnReason);
			}
			if(isset($_SESSION['error_msg'])){ ?>
					<div><span class="red center"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

