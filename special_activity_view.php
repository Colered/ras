<?php
include('header.php');
$user = getPermissions('special_activity');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$obj=new SpecialActivity();
$objT = new Teacher();
$result=$obj->getSpecialActivityDetailView();
include_once('datatable_js.php');
?>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content">
    <div id="main">
	<?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
        <div class="full_w">
            <div class="h_title">Special Activity View
			<?php if($user['add_role'] != '0'){?>
			<a href="special_activity.php" class="gird-addnew" title="Add New Special Activity"> Add New</a>
			<?php } ?>
			</div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Special Activity Name</th>
						<th >Activity Type</th>
                        <th >Associated Activities </th>
                        <th >Program</th>
						<th >Area</th>
						<th >Classroom</th>
                    	<th >Subject</th>
                        <th >Teacher</th>
						<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
								<th width="75" >Action</th>
						<?php } ?>                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
					$i=1;
					while ($data = $result->fetch_assoc()){ 
					?>
					<tr>
                        <td><?php echo $i;?></td>
						<td><?php echo $data['special_activity_name'];?></td>
						<td>
						<?php 
							if($data['reserved_flag']=="3"){echo "Recess Activity";}
						    if($data['reserved_flag']=="4"){echo "Group Activity";}
						    if($data['reserved_flag']=="5"){echo "AdHoc Activity";}
						?>
						</td>
						<?php
						    $actHtml=''; $count=0;
							$act_name_query_result=$obj->getSpecialActivityByActName($data['special_activity_name']);
							if($data['reserved_flag']!=5){
								$actHtml.='<table id="sesssionTable"  border="1" ><thead><tr><th >Activty</th><th >Date</th><th >Timeslot</th><th width="75">Action</th></tr></thead><tbody>';
							}else{
								$actHtml.='<table id="sesssionTable"  border="1" ><thead><tr><th >Activty</th><th >Date</th><th >Timeslot</th><th >Ad-Hoc Start time</th><th >Ad-Hoc End time</th><th width="75">Action</th></tr></thead><tbody>';
							}
							while($act_name_data_result = mysqli_fetch_assoc($act_name_query_result)){
									$ts_array = explode(",",$act_name_data_result['timeslot_id']);
									$min_ts_id = $ts_array[0];
									$max_ts_id = $ts_array[count($ts_array)-1];
									$timeslot = $objT->getTimeslotById($min_ts_id,$max_ts_id);
									$count++;
									if($data['reserved_flag']!=5){
										$actHtml.='<tr>
															<td>'.$act_name_data_result['name'].'</td>
															<td>'.$act_name_data_result['act_date'].'</td>
															<td>'.$timeslot.'</td>
															<td id="'.$act_name_data_result['id'].'">
																<a href="special_activity.php?edit='.base64_encode($act_name_data_result['id']).'?>" class="table-icon edit" title="Edit Activity"></a>
																<a class="table-icon delete" onClick="deleteSpecialActivityListing('.$act_name_data_result['id'].')"></a></td>
												  </tr> ';
									}else{
										$startDate = (isset($act_name_data_result['adhoc_start_date']) && $act_name_data_result['adhoc_start_date'] != '0000-00-00')? $act_name_data_result['adhoc_start_date']:'';
										$endDate = ($act_name_data_result['adhoc_end_date'] != '0000-00-00')? $act_name_data_result['adhoc_start_date']:'';
										$actHtml.='<tr>
															<td>'.$act_name_data_result['name'].'</td>
															<td>'.$act_name_data_result['act_date'].'</td>
															<td>'.$timeslot.'</td>
															<td>'.$startDate.'</td>
															<td>'.$endDate.'</td>
															<td id="'.$act_name_data_result['id'].'" width="30">
																<a href="special_activity.php?edit='.base64_encode($act_name_data_result['id']).'?>" class="table-icon edit" title="Edit Activity"></a>
																<a class="table-icon delete" onClick="deleteSpecialActivityListing('.$act_name_data_result['id'].')"></a>
															</td>
												  </tr> ';
									}
							}
		   					$actHtml.='</tbody></table>';
							if($count>0){
							?>
						<td class="align-center" width="375">
						 	<img id="actNameImg<?php echo $i;?>" src="images/plus_icon.png" alt="Smiley face" class="actNameImgCls" onclick="getActName(<?php echo $i?>);">
						  	<div id="divActName<?php echo $i;?>" class="actNameCls"><?php echo $actHtml?></div>
						</td>
						<?php }else{ ?>
						<td class="align-center" width="200">N/A</td>
						<?php } ?>
						<td><?php if($data['program_year_id']==0){echo 'N/A';}else{echo $data['program_name'];}?></td>
						<td><?php if($data['area_name']==""){echo 'N/A';}else{echo $data['area_name'];}?></td>
						<td><?php if($data['room_id']==0){echo 'N/A';}else{echo $data['room_name'];}?></td>
						<td><?php if($data['subject_id']==0){echo 'N/A';}else{echo $data['subject_name'];}?></td>
						<td><?php if($data['teacher_id']==0){echo 'N/A';}else{echo $data['teacher_name'];}?></td>
						<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
							<td id="<?php echo trim($data['special_activity_name']) ?>">
								<?php if($user['edit'] != '0'){?>
									<a href="special_activity.php?gp_Edit=<?php echo base64_encode($data['special_activity_name'])?>" class="table-icon edit" title="Edit Activity Group"></a>
								<?php } ?>
								<?php if($user['delete_role'] != '0'){?>
									<a class="table-icon delete" onClick="deleteSpecialActivity('<?php echo trim($data['special_activity_name']) ?>')"></a>
								<?php } ?>
							</td>
						<?php } ?>
                    </tr>
					<?php $i++;}?>
                </tbody>
            </table>
			 <?php if(isset($_SESSION['error_msg'])){ ?>
				<div><span class="red"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
