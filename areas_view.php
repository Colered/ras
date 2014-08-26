<?php 	
include('header.php'); 
$obj = new Areas();
$result = $obj->viewArea();
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
		<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; $_SESSION['succ_msg']="";} ?>
		</div>
        <div class="full_w">
            <div class="h_title">Areas View<a href="areas.php" class="gird-addnew" title="Add New Area">Add New</a></div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Area Name</th>
                        <th >Area Code </th>
                        <th >Area Color</th>
						<th >Add Date</th>
						<th >Update Date</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['id'] ?></td>
                        <td><?php echo $data['area_name'] ?></td>
                        <td><?php echo $data['area_code'] ?></td>
                        <td><div style="width:50px; height:20px; background-color:<?php echo $data['area_color'] ?>"> </div></td>
						<td><?php echo $data['date_add'] ?></td>
						<td><?php echo $data['date_update'] ?></td>
                        <td class="align-center" id="<?php echo $data['id'] ?>">
                            <a href="areas.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteArea(<?php echo $data['id'] ?>)"></a>
                        </td>
                    </tr>
				<?php }?>
                </tbody>
            </table>
			<?php if(isset($_SESSION['error_msg'])) ?>
				<div><span class="red"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>