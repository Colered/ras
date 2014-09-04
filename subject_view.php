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
                        <th >Area</th>
                        <th >Program</th>
                        <th >Case Number</th>
                        <th >Technical Notes </th>
                        <th >Session Name</th>
						<th >Order Number</th>
						<th >Description</th>
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
							$area_query="select area_name,area_code from area where id='".$data['area_id']."'";
							$area_result= mysqli_query($db, $area_query);
							$area_data = mysqli_fetch_assoc($area_result);
							$area_detail=$area_data['area_code'].'#'.$area_data['area_name'];
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
						<td class="align-center"><?php echo $data['case_number'] ?></td>
						<td class="align-center"><?php echo $data['technical_notes'] ?></td>
						<td class="align-center">
						<?php 
							$subj_session_query="select session_name, order_number,description from subject_session where subject_id='".$data['id']."'";
							$subj_session_result= mysqli_query($db, $subj_session_query);
							$subj_session_data = mysqli_fetch_assoc($subj_session_result);
						    echo $subj_session_data['session_name'];
						?>
						</td>
						<td class="align-center"><?php echo $subj_session_data['order_number'] ?></td>
						<td class="align-center"><?php echo $subj_session_data['description'] ?></td>
						<td class="align-center"><?php echo $data['date_add'] ?></td>
						<td class="align-center"><?php echo $data['date_update'] ?></td>
                        <td class="align-center" id="<?php echo $data['id'] ?>">
                            <a href="subjects.php?edit=<?php echo base64_encode($data['id'].'#'.$area_detail.'#'.$program_data['program_name'])?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteSubject(<?php echo $data['id'] ?>)"></a>
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

