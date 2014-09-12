<?php 	
include('header.php'); 
$obj = new Teacher();
$result = $obj->viewTeachAvail();
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
            <div class="h_title">Teacher Avalability View<a href="teacher_availability.php" class="gird-addnew" title="Add New Teacher Avalability">Add new</a></div>
            <table>
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Teacher</th>
                        <th >Rules</th>
                        <th >Exception</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php while ($data = $result->fetch_assoc()){ ?>
				<tr>
					<td class="align-center"><?php echo $data['id']; ?></td>
					<td class="align-center"><?php echo $data['teacher_name']; ?></td>
					<td class="align-center"><?php echo $data['rule_name']; ?></td>
					<td class="align-center"><?php echo $data['id']; ?></td>
					<td class="align-center" id="<?php echo $data['teacher_id'] ?>">
                            <a href="teacher_availability.php?tid=<?php echo base64_encode($data['teacher_id']); ?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteTeachAvail(<?php echo $data['teacher_id']; ?>)"></a>
                    </td>
				</tr>
				<?php }?>
                    
            </table>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

