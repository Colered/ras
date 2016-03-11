<?php
include('header.php');
$user = getPermissions('rooms');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$obj = new Classroom();
$result = $obj->viewRoom();
include_once('datatable_js.php');
?>
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
				<div class="h_title">Classrooms View
				<?php if($user['add_role'] != '0'){?>
				<a href="rooms.php" class="gird-addnew" title="Add New Classroom">Add new</a>
				<?php } ?>
				</div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Room Type</th>
							<th>Building</th>
							<!--<th>Priority Order</th>-->
							<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
								<th>Action</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['listId'] ?></td>
                        <td><?php echo $data['room_name'] ?></td>
                        <td><?php echo $data['room_type'] ?></td>
						<td><?php echo $data['building_name'] ?></td>
						<?php /*?><td><?php echo $data['order_priority'] ?></td><?php */?>
						<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
							<td class="align-center" id="<?php echo $data['listId'] ?>">
							<?php if($user['edit'] != '0'){?>
								<a href="rooms.php?edit=<?php echo base64_encode($data['listId']) ?>" class="table-icon edit" title="Edit"></a>
							<?php } ?>
							<?php if($user['delete_role'] != '0'){?>
								<a href="#" class="table-icon delete" onClick="deleteRoom(<?php echo $data['listId'] ?>)"></a>
							<?php } ?>
							</td>
						<?php } ?>
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

