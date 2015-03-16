<?php
include('header.php');
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
$activity_filter_val = (isset($_POST['activity_color_filter']) && $_POST['activity_color_filter']!="")?$_POST['activity_color_filter']:'';
?>
<script src="js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	oTable = $('#datatables').dataTable({
	    "aaSorting":[[0, "asc"]],
		"bJQueryUI" : true,
		"sPaginationType" : "full_numbers",
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
            <div class="h_title">Special Activities View <a href="special_activity.php" class="gird-addnew" title="Add New Activity">Add new</a></div>
			<?php /*?><?php
			if($result_time && $row_id['date_upd'] != $row_act_id['date_update'])
			{
				$readonly = 'class="buttonsub"';				
			}else{				
				$readonly = 'class="buttonsub" disabled="disabled" style="background-color:#CCCCCC; background-image:none"';
			}?><?php */?>
			<div style="float:right">
				<div class = "activity-color-filteration" > 
					<form id="act_view_filter" name="act_view_filter" method="post" action="special_activity_view.php" novalidate="novalidate">	
						<strong>Activity Filter  </strong>
						<select id="activity_color_filter" name="activity_color_filter" class="select-filter" onchange="activityFilter();" style="width:110px;" > 
							<option value="" selected="selected">--Select--</option>
							<option value="3" <?php if($activity_filter_val == '3'){?> selected="selected" <?php }?>>Recess Activities</option>
							<option value="4" <?php if($activity_filter_val == '4'){?> selected="selected" <?php }?>>Group Meetings</option>
							<option value="5" <?php if($activity_filter_val == '5'){?> selected="selected" <?php }?>>Adhoc Activities</option>
						</select>
					</form>
				</div>
				<!--<div class="btnAcceptAllocation"> <input  type="button" <?php // echo $readonly; ?> value="Accept Allocation" name="btnacceptallo" id="btnacceptallo" onclick="acceptAllocationFun();"/></div>-->
			</div>
            <table id="datatables" class="display tblActivity">
                <thead>
                    <tr>
					    <!--<th><input type="checkbox" id="ckbCheckAllActivity" value="Select all" title="Select All"/></th>-->
                        <th>ID</th>
                        <th>Activity</th>
						<th>Activity Type</th>
                        <th>Program</th>
                        <th>Subject</th>
                        <th>Session</th>
                        <th>Teacher</th>
                        <th>Class Room</th>
                        <th>Date</th>
                        <th>Timeslot</th>
                        <th>PreAllocated</th>
                        <th>Allocation Status</th>
						<th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					$result = $objT->getTeachersSpecialActFilterView($activity_filter_val);
					$result_sess = $objT->getSessionFromTT();
					$session_array = array();
					if($result->num_rows){
						while($row = $result->fetch_assoc())
						{   
							$class='';
							$ts_array = explode(",",$row['timeslot_id']);
							$min_ts_id = $ts_array[0];
							$max_ts_id = $ts_array[count($ts_array)-1];
							if($row['act_date'] != '0000-00-00' && $row['act_date'] < $row_table['start_date'] || $row['act_date'] > $row_table['end_date'])
							{	
								$trBColor1 = ' style="background-color:#66CCFF; color:#FFFFFF;"';
								$tdColor = ' style="color:#FFFFFF;"';
								$class ="out-of-range";
							 }else{
								if(!empty($result_sess) && (!in_array($row['session_id'],$session_array) || $row['session_id'] != '') && (!in_array($row['session_id'],$result_sess) || $row['session_id'] != ''))
								{
								 	$trBColor1 = ' style="background-color:#FF0000; color:#FFFFFF;"';
								 	$tdColor = ' style="color:#FFFFFF;"';
								 	$session_array[] = $row['session_id'];
									$class = "unallocated-activity";
								}else{
								 	$trBColor1 = '';
								 	$tdColor = '';
									$class = 'floating-activity';
									}
							 }
							$email = (trim($row['email'])<>"") ? '('.$row['email'].')':'';
							$teacher_name = $row['teacher_name'].$email;
							if($row['reserved_flag']==1)
							   $res_flag = "Yes";
							else
							  $res_flag = "No";
							  $trBColor=($row['reserved_act_id']<>"") ? ' style="background-color:#90EE90;"':'';
							  $class_allocated=($row['reserved_act_id']<>"") ? 'allocated-activity':'';
						?>
						
						<tr<?php echo $trBColor;echo $trBColor1;?> class=<?php if($trBColor == ''){echo $class;}else{echo $class_allocated ;}?>>
							<?php /*?><td <?php echo $tdColor;?> class="align-center"><?php echo ($row['reserved_act_id']<>"" && $row['reserved_flag']!= "1")?'<input type="checkbox" value="'.$row['id'].'" name="activity_allocation[]" class="activityCkb allCKbCls" /></td>':'<input type="checkbox" value="'.$row['id'].'" name="activity_allocation[]" disabled="disabled" class=" ckbDisabled allCKbCls" />'?></td><?php */?>
							<td <?php echo $tdColor;?> class="align-center"><?php echo $row['id'];?></td>
							<td<?php echo $tdColor;?>><?php echo $row['name'];?></td>
							<td<?php echo $tdColor;?>>
							<?php
							 if($row['reserved_flag']==3)
							 	echo "Recess Activities";
							 else if($row['reserved_flag']==4)
							 	echo "Group Meetings";
							 else if($row['reserved_flag']==5)
							 	echo "Adhoc Activities";
							 ?></td>
							<td<?php echo $tdColor;?>><?php echo $row['program_name'];?></td>
							<td<?php echo $tdColor;?>><?php if($row['subject_id']==0){echo "N/A";}else{echo $row['subject_name'];}?></td>
							<td<?php echo $tdColor;?>><?php if($row['session_id']==0){echo "N/A";}else{echo $row['session_name'];}?></td>
							<td<?php echo $tdColor;?>><?php echo $teacher_name;?></td>
							<td<?php echo $tdColor;?>><font color="">
								<?php
									if(($row['reserved_act_id']<>"")){
								 		echo '<font class="unreservedAlloctedAct">'. $objB->getRoomFullName($row['reserverd_room_id']).'</font>';
									}else{
										if($row['room_id']==0){
											echo "N/A";
										}else{
											echo $objB->getRoomFullName($row['room_id']) ;
										}
									}
								 ?>
							</td>
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
							<td class="align-center"<?php echo $tdColor;?>><?php echo ($row['reserved_act_id']<>"" )? 'Allocated':'Floating';?></td>
							<td class="align-center"<?php echo $tdColor;?>><?php echo $row['reason'];?></td>
							<td class="align-center" id="<?php echo $row['id'] ?>">
								<?php /*?><a href="edit_teacher_activity.php?edit=<?php echo base64_encode($row['id']);?>&pyid=<?php echo base64_encode($row['program_year_id']);?>&cycle_id=<?php echo base64_encode($row['cycle_id']);?>&sid=<?php echo base64_encode($row['subject_id']);?>&sessId=<?php echo base64_encode($row['session_id']);?>" class="table-icon edit" title="Edit"></a><?php */?>
								<a href="special_activity.php?edit=<?php echo base64_encode($row['id'])?>" class="table-icon edit" title="Edit"></a>
								<a href="#" class="table-icon delete" onClick="deleteSpecialActivity('<?php echo $row['id'] ?>')"></a>
							</td>
						</tr>
					<?php } ?>
				<?php } ?>
				</tbody>
            </table>
			<?php if(isset($_SESSION['error_msg'])){ ?>
					<div><span class="red center"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

