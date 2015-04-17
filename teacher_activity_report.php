<?php
include('header.php');
$user = getPermissions('export_session_activity');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$result = '';
$teachers_result = '';
$objTime = new Timetable();
$result = $objTime->getTeachersActivityInRange();

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
					foreach($_POST as $value)
					{
					  echo '<input type="hidden" name="postdata[]" value="'. $value. '">';
					}
					?>
				<button onclick="document.getElementById('#export-form').submit();" class="btn-export" ><span class="btn-export-text">Export</span></button>					
			</form>
				<button onclick="printDiv('printing-div')" class="btn-export" ><span class="btn-export-text" >Print</span></button>
		</div>
		<div id="printing-div">
            <table id="datatables" class="display printable">
                <thead>
                    <tr>
                        <th>ID</th>
						<th>Date</th>
						<th>Timeslot</th>
						<th>Program</th>
						<th>Module</th>
						<th>Cycle</th>
						<th>Area</th>
						<th>Subject</th>
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
								<td><?php echo $row['unit'];?></td>
								<td><?php echo $cycle_id;?></td>
								<td><?php echo $row['area_name'];?></td>
								<td><?php echo $row['subject_name'];?></td>
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

