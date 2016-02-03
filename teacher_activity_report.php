<?php
include('header.php');
$user = getPermissions('export_session_activity');
if($user['view'] != '1')
{
	  echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
      die;
}
$result = '';
$objTime = new Timetable();
//$addSpecialAct = $teacher_id = $program_id = $area_id = $profesor_id = $cycle_id = $module = array();
$addSpecialAct = isset($_POST['addSpecialAct'])?$_POST['addSpecialAct']:'';
$teacher_id = isset($_POST['teacher'])?$_POST['teacher']:array();
$program_id = isset($_POST['program'])?$_POST['program']:array();
$area_id = isset($_POST['area'])?$_POST['area']:array();
$profesor_id = isset($_POST['profesor'])?$_POST['profesor']:array();
$cycle_id = isset($_POST['cycle'])?$_POST['cycle']:array();
$module = isset($_POST['module'])?$_POST['module']:array();
$special_activity_category = isset($_POST['special_activity_category'])?$_POST['special_activity_category']:array();
//$result = $objTime->getTeachersInRange($teacher_id,$program_id,$area_id,$profesor_id,$cycle_id,$module,$addSpecialAct);	
$teachers_result = '';
$result = $objTime->getTeachersActivityInRange($teacher_id,$program_id,$area_id,$profesor_id,$cycle_id,$module,$addSpecialAct,$special_activity_category);
//$filename = $objTime->generateAllSessActReport();
$objT = new Teacher();
$objP = new Programs();
$objA = new Areas();
?>
<script src="js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#datatables').dataTable({
		"sPaginationType":"full_numbers",
		"aaSorting":[[0, "asc"]],
		"bJQueryUI":true
	});
})
function submitFunction()
{
	$('#teacher_activity_report').submit();
}
function resetFilter(){
	$("#teacher option[value]").removeAttr("selected");
	$("#program option[value]").removeAttr("selected");
	$("#area option[value]").removeAttr("selected");
	$("#profesor option[value]").removeAttr("selected");
	$("#cycle option[value]").removeAttr("selected");
	$("#module option[value]").removeAttr("selected");
	$("#special_activity_category option[value]").removeAttr("selected");
	$('#teacher_activity_report').submit();
}
</script>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content">
    <div id="main">
       <div class="full_w">
		<div class="h_title non-printable">
			<div class="filter-teache-report1">All Activities</div>
		</div>
		<div>
			<form action="excel_export_all_activities.php" method="post" id="export-form">
					<?php
					foreach($_POST as $key => $value)
					{
						$arrValue = implode(',',$value);
						if($key == "btnGenrtReport" || $key == "fromTmDuratn" || $key == "toTmDuratn"){
					  		echo '<input type="hidden" name="'.$key.'" value="'.$value. '">';
						}else{
					  		echo '<input type="hidden" name="'.$key.'" value="'.$arrValue. '">';
						}
					}
					?>
				<button onclick="document.getElementById('#export-form').submit();" class="btn-export" ><span class="btn-export-text">Export</span></button>					
			</form>
			<button onclick="printDiv('printing-div')" class="btn-export" ><span class="btn-export-text" >Print</span></button>
		<form id="teacher_activity_report" name="teacher_activity_report" method="post" action="teacher_activity_report.php" novalidate="novalidate">
            <div class="clear"></div>
            <div class="non-printable" style="margin-top:10px;">
			<?php //if(isset($_POST['btnGenrtReport'])){?>
			 <div class="filter-teache-report">
			  <strong>Teacher:</strong>
			  	<select id="teacher" name="teacher[]" class="select-filter" multiple="multiple" style="width:135px;" /*onchange="submitFunction();"*/> 
					<?php 
					$result_techName = $objT->getTeachers();
					if($result_techName->num_rows){
					while ($row_techName =$result_techName->fetch_assoc()){
						if(in_array($row_techName['id'], $teacher_id))
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}?>						
						<option <?php echo $selected;?> value="<?php echo $row_techName['id'];?>"><?php echo $row_techName['teacher_name'];?></option>
					<?php } 
					}
					?>
				</select>
				
			</div>
			
			<div class="filter-teache-report">
				<strong>Program:</strong>
				<select id="program" name="program[]" class="select-filter" multiple="multiple" /*onchange="submitFunction();"*/> 
				 <?php 
					$result_prgm=$objP->getProgramListYearWise();
					if($result_prgm->num_rows){
					while ($row_prgm =$result_prgm->fetch_assoc()){
						if(in_array($row_prgm['id'], $program_id))
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						?>
						<option <?php echo $selected;?> value="<?php echo $row_prgm['id'];?>"><?php echo $row_prgm['name'];?></option>
					<?php } 
					}
				 ?>
				</select>
				
			</div>
			<div class="filter-teache-report">	
				<strong>Area:</strong>
				<select id="area" name="area[]" class="select-filter" multiple="multiple" style="width:235px;" /*onchange="submitFunction();"*/> 
					<?php 
					$result_area=$objA->detailArea();
					if($result_area->num_rows){
					while ($row_area =$result_area->fetch_assoc()){
						if(in_array($row_area['id'], $area_id))
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						?>
						<option <?php echo $selected;?> value="<?php echo $row_area['id'];?>"><?php echo $row_area['area_name'];?></option>
					<?php } 
					}
				 ?>
				
				</select>
				
			</div>
			<div class="filter-teache-report">	
				<strong>Type of profesor:</strong>
				<select id="profesor" name="profesor[]" class="select-filter" multiple="multiple" /*onchange="submitFunction();"*/> 
					<?php 
					$result_type=$objT->getTeachersType();
					while ($row_type =$result_type->fetch_assoc()){
						if(in_array($row_type['id'], $profesor_id))
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}?>
						<option <?php echo $selected;?> value="<?php echo $row_type['id'];?>"><?php echo $row_type['teacher_type_name'];?></option>
					<?php 
					}
				 ?>				
				</select>
			</div>
			<div class="filter-teache-report">
				<strong>Cycle:</strong>
				<?php 
					$result_prgm=$objTime->getAllCycle();
					//print"<pre>";print_r($result_prgm);die;
					?>
				<select id="cycle" name="cycle[]" class="select-filter" multiple="multiple" style="width:40px;" /*onchange="submitFunction();"*/> 
					<?php
					if(in_array($result_prgm[0], $cycle_id))
					{
						$selected1 = 'selected="selected"';
					}else{
						$selected1 = '';
					}
					if(in_array($result_prgm[1], $cycle_id))
					{
						$selected2 = 'selected="selected"';
					}else{
						$selected2 = '';
					}
					if(in_array($result_prgm[2], $cycle_id))
					{
						$selected3 = 'selected="selected"';
					}else{
						$selected3 = '';
					}
					?>
					<option <?php echo $selected1;?> value="<?php echo $result_prgm[0]?>">1</option>
					<option <?php echo $selected2;?> value="<?php echo $result_prgm[1]?>">2</option>
					<option <?php echo $selected3;?> value="<?php echo $result_prgm[2]?>">3</option>
				</select>
			</div>
			<div class="filter-teache-report">	
				<strong>Activity Category:</strong>
				<select id="special_activity_category" name="special_activity_category[]" multiple="multiple" class="select-filter" >
					<option value="1" <?php if(in_array(1, $special_activity_category)){echo "selected=selected"; } ?> >Actividad</option>
					<option value="2" <?php if(in_array(2, $special_activity_category)){echo "selected=selected"; } ?> >Uso de Espacio</option>
					<option value="3" <?php if(in_array(3, $special_activity_category)){echo "selected=selected"; } ?> >Centro de investigaci&oacute;n</option>
					<option value="4" <?php if(in_array(4, $special_activity_category)){echo "selected=selected"; } ?> >Otros</option>
				</select>
				</div>
			<div class="filter-teache-report">	
				<strong>Module:</strong>
				<select id="module" name="module[]" multiple="multiple" class="select-filter" style="width:155px; margin-right:10px;" /*onchange="submitFunction();"*/> 
					<?php 
					$result_unit=$objP->getUnit();
					if($result_unit->num_rows){
					while ($row_unit =$result_unit->fetch_assoc()){
						if(in_array($row_unit['id'], $module))
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						?>
						<option <?php echo $selected;?> value="<?php echo $row_unit['id'];?>"><?php echo $row_unit['name'];?></option>
					<?php } 
					}
				 ?>
				
				</select>
				
			</div>
		<input class="buttonsub" type="button" onclick="submitFunction();" value="Apply Filters" />
		<input style="margin-top:5px;" class="buttonsub" type="button" onclick="resetFilter()" value="Reset Filters" />
		<div class="filter-teache-report" style="padding-top:20px; height:32px;" > 	
				<div style="float:left; margin-left:3px;">
				<input type="checkbox" name="addSpecialAct" <?php if(isset($_POST['addSpecialAct']) && $_POST['addSpecialAct']==1){ echo "checked"; } ?> value="1" onclick="submitFunction();" /> <strong>Include special activities (Recess and Group Meetings) </strong> </div>
			</div>
		<?php //} ?>
		</div>
		</form>
		</div>
		<div id="printing-div" class="teach-excel-report-tbl">
            <table id="datatables" class="display printable">
                <thead>
                    <tr>
                        <th>ID</th>
						<th>Date</th>
						<th>Timeslot</th>
						<th>Program</th>
						<th>Company</th>
						<th>Special Act. Name</th>
						<th>Activity Category</th>
						<th>Module</th>
						<th>Cycle</th>
						<th>Area</th>
						<th>Subject</th>
						<th>subject code</th>
						<th>Session</th>
                        <th>Teacher</th>
                        <th>Teacher Type </th>
						<th>Classroom</th>
                        <th>Case No</th>
						<th>Technical Notes</th>
						<th>Description</th>
                        
                    </tr>
                </thead>
                <tbody>
				<?php	
						if($result)
						{	$i=1;
							while($row = $result->fetch_assoc())
							{	
								$cycle_id = $objTime->getCycleDetailsId($row['program_id'],$row['cycle_id']);
								$tsobj = new Timeslot();
								$timeslotVal = $tsobj->getTSbyIDs('('.$row['timeslot_id'].')',$i);
								$timeslot_actual=isset($timeslotVal['0'])?$timeslotVal['0']:'';
								?>
							<tr>
								<td class="align-center"><?php echo $i;?></td>	
								<td><?php echo $row['act_date'];?></td>
								<td><?php echo $timeslot_actual;?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['company'];?></td>
								<td><?php echo $row['special_activity_name'];?></td>
								<td><?php if($row['special_activity_category']=="1"){echo "Actividad"; } 
									  else if($row['special_activity_category']=="2"){echo "Uso de Espacio"; } 
									  else if($row['special_activity_category']=="3"){echo "Centro de investigaci&oacute;n"; } 
									  else if($row['special_activity_category']=="4"){echo "Otros"; } 
								?></td>
								<td><?php echo $row['unit'];?></td>
								<td><?php echo $cycle_id;?></td>
								<td><?php echo $row['area_name'];?></td>
								<td><?php echo $row['subject_name'];?></td>
								<td><?php echo $row['subject_code'];?></td>
								<td><?php echo $row['session_name'];?></td>
								<td><?php echo $row['teacher_name'];?></td>
								<td><?php echo $row['teacher_type_name'];?></td>	
								<td><?php echo $row['room_name'];?></td>
								<td><?php echo $row['case_number'];?></td>
								<td><?php echo $row['technical_notes'];?></td>
								<td><?php echo $row['description'];?></td>
							</tr>
						<?php $i++; } 
						}?>			
			   </tbody>				
            </table>
		</div>
	   </div>
       <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

