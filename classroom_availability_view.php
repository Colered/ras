<?php include('header.php');
$obj = new Classroom_Availability();
$result = $obj->viewClassAvail();
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
            <div class="h_title">Classroom Avalability View<a href="classroom_availability.php" class="gird-addnew" title="Add New Class Room Avalability">Add new</a></div>
            <table id="datatables">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Room</th>
                        <th >Schedule Name</th>
                        <th >Time Interval</th>
                        <th >Days</th>
                        <th >Timeslots</th>
                        <th >Rules</th>
                        <th >Exception</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($data = $result->fetch_assoc()){ ?>
				<tr>
					<td><?php echo $data['id']; ?></td>
					<td><?php echo $data['room_name']; ?></td>
					<td><?php echo $data['rule_name']; ?></td>
					<td><?php echo $data['id']; ?></td>
					<td><?php echo $data['id']; ?></td>
					<td><?php echo $data['id']; ?></td>
					<td><?php echo $data['id']; ?></td>
					<td class="align-center">1</td>
					<td class="align-center" id="<?php echo $data['room_id'] ?>">
						<a href="classroom_availability.php?edit=<?php echo base64_encode($data['room_id'])?>" class="table-icon edit" title="Edit"></a>
						<a href="#" class="table-icon delete" onClick="deleteClassroomAvailability(<?php echo $data['room_id'] ?>)"></a>
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

