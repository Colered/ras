<?php include('header.php');
$user = getPermissions('program_cycles');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
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
				<div class="h_title">Program Cycles View
				<?php if($user['add_role'] != '0'){?>
				<a href="program_cycles.php" class="gird-addnew" title="Add New Cycles">Add new</a>
				<?php } ?>
				</div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Program Name</th>
							<th>Cycle Info</th>
							<?php if($user['add_role'] != '0' || $user['delete_role'] != '0'){?>
							<th>Action</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php
						//$result = $objP->getProgramListYearWise();
						$result = $objP->getProgramWithCycle();
						
						while($row = $result->fetch_assoc()){
						$cycleInfo = $objP->getCyclesInfo($row['program_year_id']);
                     ?>
						<tr>
							<td class="align-center"><?php echo $row['program_year_id'];?></td>
							<td class="align-center"><?php echo $row['name'];?></td>
							<td width="500">
							<?php if($cycleInfo!=''){?>
									<div style="text-align:center"><img id="sessionNameImg<?php echo $row['progid'];?>" src="images/plus_icon.png" alt="Smiley face" class="sessionNameImg" onclick="showHideCycleInfo('<?php echo $row['progid']?>');"></div>
									<div id="divSessionName<?php echo $row['progid'];?>" class="subjectSession">
									<?php echo $cycleInfo;?>
									</div>
						  	<?php }else{
							 		echo '<div style="text-align:center">N/A</div>';
							      }
							?>
							</td>
							<?php if($user['add_role'] != '0' || $user['delete_role'] != '0'){?>
								<td class="align-center" id="<?php echo $row['progid'] ?>">
								<?php if($user['add_role'] != '0'){?>
									<a href="program_cycles.php?edit=<?php echo base64_encode($row['progid']);?>" class="table-icon edit" title="Edit"></a>
								<?php } ?>
								<?php if($user['delete_role'] != '0'){?>
									<a href="#" class="table-icon delete" onclick="deleteCycle(<?php echo $row['progid'];?>)"></a>
								<?php } ?>
								</td>
							<?php } ?>
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

