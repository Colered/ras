<?php include('header.php');
$user = getPermissions('programs');
if($user['view'] != '1')
{
	header("location:page_not_found.php");
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
				<div class="h_title">Programs View
				<?php if($user['add_role'] != '0'){?>
				<a href="programs.php" class="gird-addnew" title="Add New Program">Add new</a>
				<?php } ?>
				</div>
				<table id="datatables" class="display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Program Name</th>
							<th>Sub Program Name</th>
							<th>Unit</th>
							<th>Company</th>
							<th>Program Type</th>
							<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
							<th>Action</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php
						$result = $objP->getProgramListData();
						while($row = $result->fetch_assoc()){
						$unitDBValArr = explode(',',$row['unit']);
						$progUnit = '<ul>';
						if(!empty($unitDBValArr) && $unitDBValArr[0]<>''){
							foreach($unitDBValArr as $val){
							   $progUnit .= '<li>'.$pUnitArr[$val].'</li>';
							}
						}
						$progUnit .= '<ul>';
                     ?>
						<tr>
							<td class="align-center"><?php echo $row['id'];?></td>
							<td class="align-center"><?php echo $row['program_name'];?></td>
							<td class="align-center"><?php echo $objP->getSubPrograms($row['id']);?></td>
							<td><?php echo $progUnit;?></td>
							<td class="align-center"><?php echo ($row['company']<>"") ? $row['company']: 'N/A';?></td>
							<td class="align-center"><?php echo $pTypeArr[$row['program_type']];?></td>
							<!--<td class="align-center"><?php echo $objP->formatDate($row['start_date']);?> - <?php echo $objP->formatDate($row['end_date']);?></td>-->
							<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
								<td class="align-center" id="<?php echo $row['id'] ?>">
									<?php if($user['edit'] != '0'){?>
										<a href="programs.php?edit=<?php echo base64_encode($row['id']);?>" class="table-icon edit" title="Edit"></a>
									<?php } ?>
									<?php if($user['delete_role'] != '0'){?>
										<a href="#" class="table-icon delete" onClick="deleteProgram(<?php echo $row['id'] ?>)"></a>
									<?php } ?>
								</td>
						<?php } ?>
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

