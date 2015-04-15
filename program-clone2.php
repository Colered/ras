<?php
	include('header.php');
	$user = getPermissions('programs');
	if($user['clone'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
	$prgm_clone_old_id=(isset($_GET['clone']) && $_GET['clone']!="")? base64_decode($_GET['clone']):'';
	$prgm_clone_new_id=(isset($_GET['id']) && $_GET['id']!="")? base64_decode($_GET['id']):'';
	$obj=new Programs();
	$result=$obj->getProgramYearsById($prgm_clone_old_id);
	$result_new=$obj->getProgramYearsById($prgm_clone_new_id);
	$prgm_yr_new_arr=$prgm_yr_new_name_arr=$prgm_yr_new_cycle_arr=array();
	while ($data_new = $result_new->fetch_assoc()){
			$prgm_yr_new_arr[] = $data_new['id'];
			$prgm_yr_new_name_arr[] = $data_new['name'];
			//$prgm_yr_new_cycle_arr[] = $data_new['name'];
	}
//print"<pre>";	print_r($prgm_yr_new_arr);die;
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
			<li style="background-color: #eee;color:#aaa; list-style:none;"><span style="font-size:14px;"><strong>Step-1  </strong></span>Cloning Program &amp; Cycles</li>
			<li style="background-color: #1c478e;color:#fff; list-style:none;"><span><span style="font-size:14px;"><strong>Step-2  </strong></span>Cloning Subjects</li>
		</ul>
	</div>
	<div style="float:right;padding:5px 5px;"><input  type="button" class="buttonsub" value="Save & Finish" name="btnPrgmClone" id="btnPrgmClone" onclick="PrgmSubSessCloning();"/>		</div>
        <div class="full_w">
            <div class="h_title">Program and Subject View</div>		
			
			 <table id="datatables" class="display">
                <thead>
                    <tr>
					    <!--<th><input type="checkbox" id="ckbAllSub" value="Select all" title="Select All"/></th>-->
                        <th >ID</th>
						<th >Program</th>
                        <th >Subject Name</th>
						<th style="display:none;">Subject Code </th>
                        <th >Area</th>
                        <th width="350">Session</th>
					</tr>
                </thead>
                <tbody>
                    <?php
					 $j=0;$cyc_arr1 = array();
					 while ($data = $result->fetch_assoc()){
						$cycles = $obj->getProgramCycleList($prgm_yr_new_arr[$j]);
						while($cyc_arr = $cycles->fetch_assoc())
						 {
							$cyc_arr1[] = $cyc_arr['id'];
						 }
						$result_subject=$obj->getSubjectByPrgmId($data['id']);
						while ($data1 = $result_subject->fetch_assoc()){
							$data_cycle = $obj->getCyclesInProgram($data1['program_year_id']);
							if($data_cycle == 1)
							{
								$cycle_id = 0;
							}elseif($data_cycle == 2){
								$cycle_details = $obj->getMinMaxCyclesInProgram($data1['program_year_id']);
								$cycles_data = explode("-",$cycle_details);
								if($data1['cycle_no'] == $cycles_data[0])
									$cycle_id = 0;
								else
									$cycle_id = 1;
							}elseif($data_cycle == 3){
								$cycle_details = $obj->getMinMaxCyclesInProgram($data1['program_year_id']);
								$cycles_data = explode("-",$cycle_details);								
								if($data1['cycle_no'] == $cycles_data[0])
									$cycle_id = 0;
								elseif($data1['cycle_no'] == $cycles_data[1])
									$cycle_id = 2;
								else
									$cycle_id = 1;
							}							
					 ?>
						<tr id="<?php echo $data1['id']; ?>">
							<td class="align-center"><?php echo $data1['id']; ?> 
							</td>
							<td class="align-center"><?php echo $prgm_yr_new_name_arr[$j]; ?>
								<input type="hidden" name="prgm_clone[]" value="<?php echo $data1['id']; ?>"/>
								<input type="hidden" id="program_yr_new_id<?php echo $prgm_yr_new_arr[$j]; ?>" name="program_yr_new_id[]" value="<?php echo $prgm_yr_new_arr[$j]; ?>" />
							</td>
							<td class="align-center">
								<span id="subject_nm_txt<?php echo $data1['id']; ?>" class="txt-sub"><?php echo $data1['subject_name']; ?> </span>
								<input type="text" class="ipt" id="subject_name<?php echo $data1['id']; ?>" name="subject_name[]" value="<?php echo $data1['subject_name']; ?>" size="50px" />
							</td>
							<td class="align-center" style="display:none;">
								<span id="subject_cd_txt<?php echo $data1['id']; ?>" class=""><?php echo $data1['subject_code'].'-'.$i; ?> </span>
								<input type="hidden" class="ipt" id="subject_code<?php echo $data1['id']; ?>" name="subject_code[]" value="<?php $auto_code = $obj->subCodeGen(5,'NO_NUMERIC'); echo $auto_code; ?>"  />
							</td>
							<td class="align-center"><?php echo $data1['area_name'];?>
							<input type="hidden"  id="area<?php echo $data1['area_id']; ?>" name="area_id[]" value="<?php echo $data1['area_id']; ?>" />
							<input type="hidden" id="cycle<?php echo $cyc_arr1[$cycle_id]; ?>" name="cycle_num[]" value="<?php echo $cyc_arr1[$cycle_id]; ?>" />
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
