<?php 
include('header.php');
require_once('config.php');
global $db; 
$obj=new Subjects();
$result=$obj->viewSubject();
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
            <div class="h_title">Subjects View <a href="subjects.php" class="gird-addnew" title="Add New Subject"> Add New</a></div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Subject Name</th>
                        <th >Subject Code </th>
                        <th >Choose Area</th>
                        <th >Choose Program</th>
                        <th >Session No.</th>
                        <th >Case No. </th>
                        <th >Technical Notes </th>
                        <th >Classroom Type</th>
						<th >Classroom</th>
                        <th >Add Date</th>
						<th >Update Date</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['id'] ?></td>
                        <td class="align-center"><?php echo $data['subject_name'] ?></td>
                        <td class="align-center"><?php echo $data['subject_code'] ?></td>
                        <td class="align-center">
						<?php 
							$area_query="select area_name from area where id='".$data['area_id']."'";
							$area_result= mysqli_query($db, $area_query);
							$area_data = mysqli_fetch_assoc($area_result);
							echo $area_data['area_name'];
						?>
						</td>
						<td class="align-center">
						<?php 
							$program_query="select program_name from program where id='".$data['program_id']."'";
							$program_result= mysqli_query($db, $program_query);
							$program_data = mysqli_fetch_assoc($program_result);
							echo $program_data['program_name'];
						?>
						</td>
						<td class="align-center"><?php echo $data['session_no.'] ?></td>
						<td class="align-center"><?php echo $data['case_no.'] ?></td>
						<td class="align-center"><?php echo $data['technical_notes'] ?></td>
						<td class="align-center">
						<?php 
							$room_query="select room_type_id,room_name from  room where id='".$data['room_id']."'";
							$room_result= mysqli_query($db, $room_query);
							$room_data = mysqli_fetch_assoc($room_result);
							$room_type_query="select room_type from room_type where id='".$room_data['room_type_id']."'";
							$room__type_result= mysqli_query($db, $room_type_query);
							$room_type_data = mysqli_fetch_assoc($room__type_result);
							echo $room_type_data['room_type'];
							
						?>
						</td>
						<td class="align-center"><?php echo $room_data['room_name'] ?></td>
						<td class="align-center"><?php echo $data['date_add'] ?></td>
						<td class="align-center"><?php echo $data['date_update'] ?></td>
                        <td class="align-center" id="<?php echo $data['id'] ?>">
                            <a href="subjects.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteArea(<?php echo $data['id'] ?>)"></a>
                        </td>
                    </tr>
					<?php }?>
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

