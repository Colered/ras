<?php
	include('header.php');
	$prgm_clone_old_id=base64_decode($_GET['clone']);
	$prgm_clone_new_id=base64_decode($_GET['id']);
	$obj=new Programs();
	$result=$obj->getProgramYearsById($prgm_clone_old_id);
	$result_new=$obj->getProgramYearsById($prgm_clone_new_id);
	$prgm_yr_new_arr=array();
	while ($data_new = $result_new->fetch_assoc()){
			$prgm_yr_new_arr[] = $data_new['id'];
	}
?>
<script src="js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	oTable=$('#datatables').dataTable({
		"sPaginationType":"full_numbers",
		"aaSorting":[[0, "asc"]],
		"bJQueryUI":true,
		"bPaginate": false,
		"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ 0 ] }
			],
	});
})
</script>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
	.clearfix ul li
	{
		float:left;
		color:#fff;
		padding: 5px;
		min-width: 120px;
		margin: 5px 10px;
		border:1px solid black;
	}
	.clearfix ul{
	margin-left:6px !important;
	}
</style>
<div id="content">
    <div id="main">
	<?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
	<div class="steps clearfix">
		<ul>
			<li style="background-color: #eee;color:#aaa;"><span class="number">Step-1</span><br/> Saving Program & cycles</li>
			<li style="background-color: #00923f;color:#fff;"><span class="number">Step-2</span><br/> Saving Subjects</li>
		</ul>
	</div>
        <div class="full_w">
            <div class="h_title">Program and Subject View</div>		
			<div style="float:right;padding:5px 5px;"><input  type="button" class="buttonsub" value="Save & Finish" name="btnPrgmClone" id="btnPrgmClone" onclick="PrgmSubSessCloning();"/></div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
					    <th><input type="checkbox" id="ckbAllSub" value="Select all" title="Select All"/></th>
                        <th >ID</th>
						<th >Program</th>
                        <th >Subject Name</th>
						<th >Subject Code </th>
                        <th >Area</th>
                        <th width="350">Session</th>
					</tr>
                </thead>
                <tbody>
                    <?php
					 $j=0;
					 while ($data = $result->fetch_assoc()){
						 $result_subject=$obj->getSubjectByPrgmId($data['id']);
							while ($data1 = $result_subject->fetch_assoc()){  
					 ?>
						<tr id="<?php echo $data1['id']; ?>">
							<td class="align-center"><input type="checkbox" value="<?php echo $data1['id']; ?>" name="prgm_clone[]"  class="ckbSubjEdit"/></td>
							<td class="align-center"><?php echo $data1['id']; ?></td>
							<td class="align-center"><?php echo $data1['program_name']; ?>
							<input type="hidden" id="program_yr_new_id<?php echo $prgm_yr_new_arr[$j]; ?>" name="program_yr_new_id[]" value="<?php echo $prgm_yr_new_arr[$j]; ?>" />
							</td>
							<td class="align-center">
								<span id="subject_nm_txt<?php echo $data1['id']; ?>" class="txt-sub"><?php echo $data1['subject_name']; ?> </span>
								<input type="text" class="ipt" id="subject_name<?php echo $data1['id']; ?>" name="subject_name[]" value="<?php echo $data1['subject_name']; ?>" />
							</td>
							<td class="align-center">
								<span id="subject_cd_txt<?php echo $data1['id']; ?>" class="txt-sub"><?php echo $data1['subject_code']; ?> </span>
								<input type="text" class="ipt" id="subject_code<?php echo $data1['id']; ?>" name="subject_code[]" value="<?php echo $data1['subject_code']; ?>" />
							</td>
							<td class="align-center"><?php echo $data1['area_name'];?>
							<input type="hidden"  id="area<?php echo $data1['area_id']; ?>" name="area_id[]" value="<?php echo $data1['area_id']; ?>" />
							<input type="hidden" id="cycle<?php echo $data1['cycle_no']; ?>" name="cycle_num[]" value="<?php echo $data1['cycle_no']; ?>" />
							</td>
							<?php
								$sessionHtml=''; $count=0;
								$subj_session_query="select session_name,order_number,description, case_number, technical_notes from subject_session where subject_id='".$data1['id']."' ORDER BY order_number ASC ";
								$subj_session_result= mysqli_query($db, $subj_session_query);
								$sessionHtml.='<table id="sesssionTable"  border="1" ><thead><tr><th >Session Name</th><th >Description</th><th >Case No:</th><th >Technical Notes</th></tr></thead><tbody>';
								while($subj_session_data = mysqli_fetch_assoc($subj_session_result)){
										$count++;
										$sessionHtml.='<tr>
															<td>'.$subj_session_data['session_name'].'</td>
															<td>'.$subj_session_data['description'].'</td>
															<td>'.$subj_session_data['case_number'].'</td>
															<td>'.$subj_session_data['technical_notes'].'</td>
													  </tr> ';
								}
								$sessionHtml.='</tbody></table>';
	
							if($count>0){ ?>
							<td class="align-center" width="200">
								<img id="sessionNameImg<?php echo $data1['id'];?>" src="images/plus_icon.png" alt="Smiley face" class="sessionNameImg" onclick="getSessionName(<?php echo $data1['id']?>);">
								<div id="divSessionName<?php echo $data1['id'];?>" class="subjectSession"><?php echo $sessionHtml;?></div>
							</td>
							<?php }else{ ?>
							<td class="align-center" width="200">N/A</td>
							<?php } ?>
					   </tr>
					<?php }?>
				<?php $j++;}?>
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
