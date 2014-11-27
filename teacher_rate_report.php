<?php
include('header.php');
$result = '';
$teachers_result = '';
if(isset($_POST['btnGenrtReport']) && $_POST['btnGenrtReport'] != '')
{
	if($_POST['fromTmDuratn'] != "" || $_POST['toTmDuratn'] != "")
	{
		$objTime = new Timetable();
		$teacher_id = isset($_POST['teacher'])?$_POST['teacher']:'';
		$program_id = isset($_POST['program'])?$_POST['program']:'';
		$area_id = isset($_POST['area'])?$_POST['area']:'';
		$profesor_id = isset($_POST['profesor'])?$_POST['profesor']:'';
		$cycle_id = isset($_POST['cycle'])?$_POST['cycle']:'';
		$result = $objTime->getTeachersInRange($_POST['fromTmDuratn'],$_POST['toTmDuratn'],$teacher_id,$program_id,$area_id,$profesor_id,$cycle_id);
		$teachers_result = $objTime->getTeacherId($_POST['fromTmDuratn'],$_POST['toTmDuratn'],$teacher_id,$program_id,$area_id,$profesor_id,$cycle_id);
		
		
	}else{		
		$message="Please enter all required fields";
		$_SESSION['error_msg'] = $message;
		header('Location: teacher_rate_report.php');			
	}
}
$fromTmDuratn = isset($_POST['fromTmDuratn'])?$_POST['fromTmDuratn']:'';
$toTmDuratn = isset($_POST['toTmDuratn'])?$_POST['toTmDuratn']:'';
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
	$('#teacher_rate_report').submit();
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
		<div class="h_title non-printable">
			<div class="filter-teache-report1">
			 	Teacher's Rate Report
			 </div>
		</div>
		<?php if(isset($_POST['btnGenrtReport'])){?>
		<div>
			<form action="excel_export_example.php" method="post" id="export-form">
					<?php
					foreach($_POST as $value)
					{
					  echo '<input type="hidden" name="postdata[]" value="'. $value. '">';
					}
					?>
					<button onclick="document.getElementById('#export-form').submit();" class="btn-export"><span class="btn-export-text">Export</span></button>					
			</form>
				<button onclick="printDiv('printing-div')" class="btn-export"><span class="btn-export-text">Print</span></button>
		</div>
		<?php } ?>		
		<form id="teacher_rate_report" name="teacher_rate_report" method="post" action="teacher_rate_report.php" novalidate="novalidate">
		<input type="hidden" value="Generate Report" name="btnGenrtReport"/>
			 <div class="filter-teache-report" style="padding-top:20px;" ><strong> Time Interval: </strong>
				From: <input type="text" size="12" id="fromTmDuratn" name="fromTmDuratn" value="<?php echo $fromTmDuratn;?>"/>
				To: <input type="text" size="12" id="toTmDuratn" name="toTmDuratn" value="<?php echo $toTmDuratn;?>"/>
			</div>
			<div class="txtfield">
				<input style="margin-top: 15px;" class="buttonsub" type="submit" value="Generate Report" name="btnGenrtReport">
			</div>
		
            <div class="clear"></div>
            <div class="non-printable">
			<?php if(isset($_POST['btnGenrtReport'])){?>
			 <div class="filter-teache-report">
			  <strong>Teacher:</strong>
			  	<select id="teacher" name="teacher" class="select-filter" onchange="submitFunction();"> 
					<option value="" selected="selected">--Select--</option>
					<?php 
					$result_techName = $objT->getTeachers();
					if($result_techName->num_rows){
					while ($row_techName =$result_techName->fetch_assoc()){
						if($row_techName['id'] == $_POST['teacher'])
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
				<select id="program" name="program" class="select-filter" onchange="submitFunction();"> 
				 <option value="" selected="selected">--Select--</option>
				 <?php 
					$result_prgm=$objP->getProgramListYearWise();
					if($result_prgm->num_rows){
					while ($row_prgm =$result_prgm->fetch_assoc()){
						if($row_prgm['id'] == $_POST['program'])
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}?>
						<option <?php echo $selected;?> value="<?php echo $row_prgm['id'];?>"><?php echo $row_prgm['name'];?></option>
					<?php } 
					}
				 ?>
				</select>
				
			</div>
			<div class="filter-teache-report">	
				<strong>Area:</strong>
				<select id="area" name="area" class="select-filter" onchange="submitFunction();"> 
					<option value="" selected="selected">--Select--</option>
					<?php 
					$result_area=$objA->detailArea();
					if($result_area->num_rows){
					while ($row_area =$result_area->fetch_assoc()){
						if($row_area['id'] == $_POST['area'])
						{
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}?>
						<option <?php echo $selected;?> value="<?php echo $row_area['id'];?>"><?php echo $row_area['area_name'];?></option>
					<?php } 
					}
				 ?>
				
				</select>
				
			</div>
			<div class="filter-teache-report" style="display:none;">	
				<strong>Type of profesor:</strong>
				<select id="profesor" name="profesor" class="select-filter"> 
					<option value="" selected="selected">--Select--</option>
					<?php 
						$result_teach_type = $objT->getTeachers();
						if($result_teach_type->num_rows){
						while ($row_teach_type = $result_teach_type->fetch_assoc()){?>
							<option value="<?php echo $row_teach_type['teacher_type'];?>"><?php echo $row_teach_type['teacher_type'];?></option>
						<?php } 
						}
					?>
				</select>
			</div>
			<div class="filter-teache-report" style="display:none;">
				<strong>Cycle:</strong>
				<select id="cycle" name="cycle" class="select-filter"> 
					<option value="" selected="selected">--Select--</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</div>			
			<?php } ?>
		</div>
		</form>
			<div id="printing-div">
            <table id="datatables" class="display printable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Teacher</th>
                        <th>Teacher Type </th>
                        <th>Program</th>
                        <th>Company</th>
                        <th>Module</th>
                        <th>Sessions</th>
                        <th>Amount to pay $</th>
                        
                    </tr>
                </thead>
                <tbody>
				<?php	
						if($result)
						{
							while($row = $result->fetch_assoc())
							{?>
							<tr>
								<td class="align-center"><?php echo $row['id'];?></td>	
								<td><?php echo $row['date'];?></td>
								<td><?php echo $row['teacher_name'];?></td>
								<td><?php echo $row['teacher_type'];?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['company'];?></td>
								<td><?php echo $row['unit'];?></td>
								<td><?php echo $row['session_name'];?></td>
								<td><?php echo $row['payrate'];?></td>
							</tr>
						<?php } 
						}?>			
			   </tbody>				
            </table>
			<table>
			<?php 
			if($teachers_result)
			{
				$total = '';$sum = '';
				while($row = $teachers_result->fetch_assoc())
				{
					$total += $row['payrate']*$row['session_id'];
					$sum += $row['session_id'];
				}
				if($total == '')
					$total = '0';
				if($sum == '')
					$sum = '0';
				?>
				<tr>
				<td style="float:left;width:178px;background-color: #1c478e;color:#fff;">Total</td>
				<td style="width:80px;background-color: #1c478e;color:#fff;"><?php echo $sum;?></td>
				<td colspan="6" style="width:0px;background-color: #1c478e;color:#fff;">Rs. <?php echo $total;?></td>
				</tr>
			<?php }
			?>		
			</table>
			</div>
			<?php if(isset($_SESSION['error_msg'])){ ?>
					<div><span class="red center"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

