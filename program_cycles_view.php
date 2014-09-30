<?php include('header.php');
$objP = new Programs();
$pTypeArr = array('1'=>'One Year','2'=>'Two Year','3'=>'Three Year');
$pUnitArr = array('1'=>'Executive Education','2'=>'Master Programs','3'=>'Tailored Programs','4'=>'Activity');

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
				<div class="h_title">Program Cycles View<a href="program_cycles.php" class="gird-addnew" title="Add New Cycles">Add new</a></div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Program Name</th>
							<th>Cycle Info</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$result = $objP->getProgramListYearWise();
						while($row = $result->fetch_assoc()){
						$cycleInfo = $objP->getCyclesInfo($row['id']);

                     ?>
						<tr>
							<td class="align-center"><?php echo $row['id'];?></td>
							<td class="align-center"><?php echo $row['name'];?></td>
							<td width="500">
							<div style="text-align:center"><img id="sessionNameImg<?php echo $row['id'];?>" src="images/plus_icon.png" alt="Smiley face" class="sessionNameImg" onclick="showHideCycleInfo('<?php echo $row['id']?>');"></div>
						  	<div id="divSessionName<?php echo $row['id'];?>" class="subjectSession">
							<?php echo ($cycleInfo=='') ? '<span align="center">N/A</span>' : $cycleInfo;?>
							</div>
							</td>
							<td class="align-center" id="<?php echo $row['id'] ?>">
								<a href="program_cycles.php?edit=<?php echo base64_encode($row['id']);?>" class="table-icon edit" title="Edit"></a>
								<a href="#" class="table-icon delete" onClick=""></a>
							</td>
						</tr>
				<?php }?>
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

