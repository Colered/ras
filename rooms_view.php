<?php
include('header.php');
$obj = new Classroom();
$result = $obj->viewRoom();
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
			<div class="full_w green center">
				<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);} ?>
			</div>
			<div class="full_w">
				<div class="h_title">Classrooms View<a href="rooms.php" class="gird-addnew" title="Add New Classroom">Add new</a></div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Room Type</th>
							<th>Building</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['listId'] ?></td>
                        <td><?php echo $data['room_name'] ?></td>
                        <td><?php echo $data['room_type'] ?></td>
						<td><?php echo $data['building_name'] ?></td>
                        <td class="align-center" id="<?php echo $data['listId'] ?>">
                            <a href="rooms.php?edit=<?php echo base64_encode($data['listId']) ?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteRoom(<?php echo $data['listId'] ?>)"></a>
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
<?php include('footer.php');?>

