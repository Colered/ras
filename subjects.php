<?php
include('header.php');
$subjectName=""; $subjectCode=""; $sessionNum=""; $subjectCode="";$caseNum=""; $technicalNotes="";$areaCode="";$areaName="";$programName="";$roomType="";$roomName="";$subjectId="";
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$subjectData= base64_decode($_GET['edit']);
	$subjectDetails=explode('#',$subjectData);
	$subjectId=$subjectDetails['0'];
	$areaCode=$subjectDetails['1'];
	$areaName=$subjectDetails['2'];
	$programName=$subjectDetails['3'];
	$obj = new Subjects();
	$result = $obj->getDataBySubjectID($subjectId);
	$row = $result->fetch_assoc();
}
$subjectName = isset($_GET['edit']) ? $row['subject_name'] : (isset($_POST['txtSubjName'])? $_POST['txtSubjName']:'');
$subjectCode = isset($_GET['edit']) ? $row['subject_code'] : (isset($_POST['txtSubjCode'])? $_POST['txtSubjCode']:'');
$caseNum = isset($_GET['edit']) ? $row['case_number'] : (isset($_POST['txtCaseNum'])? $_POST['txtCaseNum']:'');
$technicalNotes = isset($_GET['edit']) ? $row['technical_notes'] : (isset($_POST['txtTechNotes'])? $_POST['txtTechNotes']:'');
?>
<div id="content">
    <div id="main">
		<div class="custtd_left red">
			<?php if(isset($_SESSION['error_msg']))
				  echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
		</div>
	    <div class="full_w">
            <div class="h_title">Subject</div>
            <form name="subjectForm" id="subjectForm" action="postdata.php" method="post">
			<input type="hidden" name="form_action" value="addEditSubject" />
			<input type="hidden" id="subjectId" name="subjectId" value="<?php echo $subjectId; ?>" />
                <div class="custtable_left">
					<div class="custtd_left">
                        <h2>Choose Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required">
                            <option value="" selected="selected">--Select Program--</option>
                             <?php
					          $program_qry="select * from  program";
					          $program_result= mysqli_query($db, $program_qry);
					          while ($program_data = mysqli_fetch_assoc($program_result)){
							  $selected = (trim($programName) == trim($program_data['program_name'])) ? ' selected="selected"' : '';?>
					          <option value="<?php echo $program_data['program_name']; ?>" <?php echo $selected;?>><?php echo $program_data['program_name'];?></option>
					     	 <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Choose Area <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					     <select id="slctArea" name="slctArea" class="select1 required">
						 	  <option value="" selected="selected">--Select Area--</option>
					         <?php
					          $area_qry="select * from area";
					          $area_result= mysqli_query($db, $area_qry);
					          while ($area_data = mysqli_fetch_assoc($area_result)){
							  $selected = (trim($areaCode) == trim($area_data['area_code'])) ? ' selected="selected"' : '';?>
					          <option value="<?php echo $area_data['area_code']?>" <?php echo $selected;?>><?php echo $area_data['area_name'];?></option>
					     <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtSubjName" maxlength="50" name="txtSubjName" value="<?php echo $subjectName; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject Code <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="<?php echo $subjectCode; ?>">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Case No.<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtCaseNum" maxlength="50" name="txtCaseNum" value="<?php echo $caseNum; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Technical Notes<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <textarea style="height:40px;" class="inp_txt required" id="txtTechNotes" cols="20" rows="2" name="txtTechNotes"><?php echo $technicalNotes; ?></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2><strong>Session:-</strong></h2>
                    </div>
						<div class="txtfield ">
						<div class="sessionbox">
						<h3>Session Name<span class="redstar">*</span></h3>
							<input type="text" class="inp_txt_session" id="txtSessionName" maxlength="50" name="txtSessionName" value="">
						</div>
						<div class="sessionbox">
						<h3>Order Number<span class="redstar">*</span></h3>
							<input type="text" class="inp_txt_session" id="txtOrderNum" maxlength="10" name="txtOrderNum" value="">
						</div>
						<div class="sessionbox">
						<h3>Description<span class="redstar">*</span></h3>
							 <textarea style="height:40px;" class="inp_txt_session" id="txtareaSessionDesp" cols="20" rows="2" name="txtSessionDesp"></textarea>
						</div>
					   </div>
					   <div class="sessionbox addbtnSession">
					    <input type="button" name="btnAddMore" class="btnSession" value="Add">
                       </div>
					<div class="clear"></div>
					<div class="custtd_left"></div>
					<div class="divSession">
					<?php
					if($subjectId!=""){
						$x=0;
						$sessionHtml='';
						$subj_session_query="select * from  subject_session where subject_id='".$subjectId."'";
						$subj_session_result= mysqli_query($db, $subj_session_query);
						while($subj_session_data = mysqli_fetch_assoc($subj_session_result)){
						$x++;
						if($x==1){
							$sessionHtml.='<div class="sessionList">
   							<table id="datatables" class="display">
       						  <thead>
          					   <tr>
								<th>Sr. No.</th>
          						<th >Session Name</th>
          						<th >Order Number</th>
          						<th >Description</th>
								<th >Remove</th>
							   </tr>
       					      </thead>
       					      <tbody>';}
						 	$sessionHtml.='<tr>
           						<td>'.$x.'</td>
	   							<td>'.$subj_session_data['session_name'].'</td>
	   							<td>'.$subj_session_data['order_number'].'</td>
	   							<td>'.$subj_session_data['description'].'</td>

        						';
							$sessionHtml.='<td style="display:none"><input type="hidden" name="sessionName[]" id="sessionName'.$x.'"  value="'.$subj_session_data['session_name'].'"/>
								<input type="hidden" name="sessionDesc[]" id="sessionDesc'.$x.'"  value="'.$subj_session_data['order_number'].'"/>
								<input type="hidden" name="sessionOrder[]" id="sessionOrder'.$x.'"  value="'.$subj_session_data['description'].'"/>
								<input type="hidden" name="sessionRowId[]" id="sessionRowId'.$x.'"  value="'.$subj_session_data['id'].'"/></td>
								<td id='.$subj_session_data['id'].'><a class="remove_field" onclick="removeSession('.$subj_session_data['id'].', 0);">Remove</a></td></tr>';
       					}
					$sessionHtml.='<input type="hidden" name="maxSessionListVal" id="maxSessionListVal"  value="'.$x.'"/>';
					$sessionHtml.='</tbody></table></div>';
					echo $sessionHtml;
				 }?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                     </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddSubject" class="buttonsub" value="<?php echo $buttonName = ($subjectName!="") ? "Update Subject":"Add Subject" ?>">
                    </div>
                    <div class="txtfield">
						<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'subject_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
