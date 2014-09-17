<?php
include('header.php');
$objP = new Programs();
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
				<div class="h_title">Group View<a href="program_group.php" class="gird-addnew" title="Add New Group">Add new</a></div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th >ID</th>
							<th >Program</th>
							<th >Group Name</th>
							<th >Action</th>
						</tr>
					</thead>
					<tbody>
			         <?php
						$result = $objP->getAssociateProgramGroups();
						while($row = $result->fetch_assoc()){
                     ?>
						<tr>
							<td class="align-center"><?php echo $row['program_year_id'];?></td>
							<td><?php echo $objP->getProgramYearName($row['program_year_id']);?></td>
							<td>
							 <?php
								$pgresult = $objP->getAllGroupByProgId($row['program_year_id']);
								while($pgrow = $pgresult->fetch_assoc()){
								  	echo '<div>'.$pgrow['name'].'<div>';
								}
                     		 ?>
							</td>
							<td class="align-center" id="<?php echo $row['program_year_id']; ?>">
								<a href="program_group.php?edit=<?php echo base64_encode($row['program_year_id']);?>" class="table-icon edit" title="Edit"></a>
								<a href="#" class="table-icon delete" title="Delete" onClick="del_associated_prog_group('<?php echo $row['program_year_id'];?>')"></a>
							</td>
						</tr>
				    <?php } ?>

					</tbody>
				</table>
				<?php if(isset($_SESSION['error_msg'])){ ?>
						<div><span class="red"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
<?php include('footer.php');?>

