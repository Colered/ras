<?php
include('header.php');
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
	<?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
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
                        <th width="200">Session</th>
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
							$program_query="select * from  program_years where id='".$data['program_year_id']."'";
							$program_result= mysqli_query($db, $program_query);
							$program_data = mysqli_fetch_assoc($program_result);
							$program_detail=$program_data['name'].' '.$program_data['start_year'].' '.$program_data['end_year'];
							echo $program_detail;
						?>
						</td>
						<td class="align-center"><?php echo $data['case_number'] ?></td>
						<td class="align-center"><?php echo $data['technical_notes'] ?></td>
						<?php
						    $sessionHtml='';
							$subj_session_query="select session_name,order_number,description from subject_session where subject_id='".$data['id']."'";
							$subj_session_result= mysqli_query($db, $subj_session_query);
							$sessionHtml.='<table id="sesssionTable"  border="1" ><thead><tr><th >Session Name</th><th >Order No.</th><th >Description</th></tr></thead><tbody>';
							while($subj_session_data = mysqli_fetch_assoc($subj_session_result)){
							//$subj_session_order_num = (isset($subj_session_data['order_number'])) ? $subj_session_data['order_number'] : '&nbsp;';
								    $sessionHtml.='<tr>
														<td>'.$subj_session_data['session_name'].'</td>
		  												<td>'.$subj_session_data['order_number'].'</td>
		   												<td>'.$subj_session_data['description'].'</td>
                								  </tr> ';
							}
		   					$sessionHtml.='</tbody></table>';
						?>
						<td class="align-center" width="200">
						 	<img id="sessionNameImg<?php echo $data['id'];?>" src="images/plus_icon.png" alt="Smiley face" class="sessionNameImg" onclick="getSessionName(<?php echo $data['id']?>);">
						  	<div id="divSessionName<?php echo $data['id'];?>" class="subjectSession"><?php echo $sessionHtml;?></div>
						</td>
						<td class="align-center"><?php echo $data['date_add'] ?></td>
						<td class="align-center"><?php echo $data['date_update'] ?></td>
                        <td class="align-center" id="<?php echo $data['id'] ?>">
                            <a href="subjects.php?edit=<?php echo base64_encode($data['id'].'#'.$area_detail.'#'.$program_detail.'#'.$data['program_year_id'])?>" class="table-icon edit" title="Edit"></a>
							<a href="#" class="table-icon delete" onClick="deleteSubject(<?php echo $data['id'] ?>)"></a>
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
<?php include('footer.php'); ?>
