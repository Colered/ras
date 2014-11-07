<?php
include('header.php');
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

</script>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content">
    <div id="main">
    <?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; $_SESSION['succ_msg']="";} ?>
        <div class="full_w">
            <div class="h_title">Teacher Report <a href="teacher_activity.php" class="gird-addnew" title="Add New Activity">Add new</a>
			<select id="teacher" name="teacher" class="filteration"> 
				<option value="" selected="selected">--Select--</option>
				<?php 
				$result_techName = $objT->getTeachers();
				if($result_techName->num_rows){
				while ($row_techName =$result_techName->fetch_assoc()){?>
					<option value="<?php echo $row_techName['teacher_name'];?>"><?php echo $row_techName['teacher_name'];?></option>
				<?php } 
				}
			 	?>
			</select><label class="filteration">Teacher:</label>
			<select id="teacher" name="teacher" class="filteration"> 
			 <option value="" selected="selected">--Select--</option>
			 <?php 
				$result_prgm=$objP->getProgramListData();
				if($result_prgm->num_rows){
				while ($row_prgm =$result_prgm->fetch_assoc()){?>
					<option value="<?php echo $row_prgm['program_name'];?>"><?php echo $row_prgm['program_name'];?></option>
				<?php } 
				}
			 ?>
			</select><label class="filteration">Program:</label>
			<select id="teacher" name="teacher" class="filteration"> 
				<option value="" selected="selected">--Select--</option>
				<?php 
				$result_area=$objA->detailArea();
				if($result_area->num_rows){
				while ($row_area =$result_area->fetch_assoc()){?>
					<option value="<?php echo $row_prgm['area_name'];?>"><?php echo $row_area['area_name'];?></option>
				<?php } 
				}
			 ?>
			
			</select><label class="filteration">Area:</label>
			<select id="teacher" name="teacher" class="filteration"> 
				<option value="" selected="selected">--Select--</option>
				<?php 
					$result_teach_type = $objT->getTeachers();
					if($result_teach_type->num_rows){
					while ($row_teach_type = $result_teach_type->fetch_assoc()){?>
						<option value="<?php echo $row_teach_type['teacher_type'];?>"><?php echo $row_teach_type['teacher_type'];?></option>
					<?php } 
					}
			 	?>
			</select><label class="filteration">Type of profesor:</label>
			<select id="teacher" name="teacher" class="filteration"> 
				<option value="" selected="selected">--Select--</option>
			    <option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select><label class="filteration">Cyclo:</label>
		</div>
            <table id="datatables" class="display">
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
					$result = $objT->getTeachers();
					if($result->num_rows){
						while($row = $result->fetch_assoc())
						{?>
						<tr>
							<td class="align-center"><?php echo $row['id'];?></td>
							<td><?php echo $row['date_add'];?></td>
							<td><?php echo $row['teacher_name'];?></td>
							<td><?php echo $row['teacher_type'];?></td>
							<td><?php echo "XYZ";?></td>
							<td><?php echo "XYZ";?></td>
							<td><?php echo "XYZ";?></td>
							<td><?php echo "XYZ";?></td>
							<td><?php echo $row['payrate'];?></td>
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

