<?php
ob_start();
include('header.php');
$user = getPermissions('subjects');
$action="addEditSubject";
$subjectName = "";
$subjectCode = "";
$sessionNum = "";
$subjectCode = "";
$areaCode = "";
$areaName = "";
$programName = "";
$roomType = "";
$roomName = "";
$subjectId = "";
$program_year_detail = "";
$programYearId = "";
$cycle_no = "";
$cycleData = array();
$disTest = "";
$disSession = "";
$disFDivCss = "";
$subIdEncrypt = "";
$objT = new Teacher();
$rel_teacher = $objT->getTeachersWithRecess();
$objS = new Subjects();
$objB = new Buildings();
$objTS = new Timeslot();
$activities = array();
$teachers = array();
$rule_id_gr_arr=array();
//room dropdown
$room_dropDwn = $objB->getRoomsDropDwn();
$ActivityAvailData = $objS->getActivityAvailRule();
//timeslot dropdown
$tslot_dropDwn = $objTS->getTimeSlotStartDateDropDwn();
$daysDBArr = array('0'=>'Mon','1'=>'Tue','2'=>'Wed','3'=>'Thu','4'=>'Fri','5'=>'Sat','6'=>'Sun');
$option_duration='<option value="">--Select--</option>
                  <option value="15">00:15</option>
                  <option value="30">00:30</option>
                  <option value="45">00:45</option>
                  <option value="60">01:00</option>
                  <option value="75">01:15</option>
                  <option value="90">01:30</option>
                  <option value="105">01:45</option>
                  <option value="120">02:00</option>
                  <option value="135">02:15</option>
                  <option value="150">02:30</option>
                  <option value="165">02:45</option>
                  <option value="180">03:00</option>
                  <option value="195">03:15</option>
                  <option value="210">03:30</option>
                  <option value="225">03:45</option>
                  <option value="240">04:00</option>
                  <option value="255">04:15</option>
                  <option value="270">04:30</option>
                  <option value="285">04:45</option>
                  <option value="300">05:00</option>
                  <option value="315">05:15</option>
                  <option value="330">05:30</option>
                  <option value="345">05:45</option>
                  <option value="300">06:00</option>
                  <option value="315">06:15</option>
                  <option value="330">06:30</option>
                  <option value="345">06:45</option>
                  <option value="300">07:00</option>
                  <option value="315">07:15</option>
                  <option value="330">07:30</option>
                  <option value="345">07:45</option>
                  <option value="345">08:00</option>';	

if(isset($_REQUEST['rule']) && $_REQUEST['rule'] == 1)
{
	$ruleCSS="display:block;";
	$selectedRule = "selected='selected'";
}
else
{
	$ruleCSS="display:none;";
	$selectedRule = "";
}
if ((isset($_GET['edit']) && $_GET['edit'] != "") || (isset($_GET['clone']) && $_GET['clone'] != "")) {	
    if(isset($_GET['edit']) && $_GET['edit'] != ""){
		if($user['edit'] != '1')
		{
			echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
		}
		$disTest = "disabled";
		$action="addSessions";
    	$disFDivCss = "style='opacity:.5; pointer-event:none'";
		$subIdEncrypt = $_GET['edit'];
    	$subjectId = base64_decode($_GET['edit']);
		$detail_grp2 = $objS->getRulesBySubjectId($subjectId);		
		while($data_grp_rule_id = $detail_grp2->fetch_assoc()){
		 		$rule_id_gr_arr[]=$data_grp_rule_id['subject_rule_id'];
		}
		if(count($rule_id_gr_arr)>0){
		 	$rule_id_gr_uni_arr = array_unique($rule_id_gr_arr);
			$rule_id_grp_str=implode(',',$rule_id_gr_uni_arr);
		}
		if(isset($_REQUEST['rule']) && $_REQUEST['rule'] == 1)
		{
			$disDivCss = "style='display:none;'";
			$disMainDivCss = "style='display:block;'";
		}else{
			$disDivCss = "style='display:block;'";
			$disMainDivCss = "style='display:block;'";
		}
		
	}else if(isset($_GET['clone']) && $_GET['clone'] != ""){
		if($user['clone'] != '1')
		{
			echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
		}
		$disSession = "disabled";
   		$disDivCss = "style='opacity:.5; pointer-event:none;display:block;'";
		$disMainDivCss = "style='opacity:.5; pointer-event:none;display:block;'";
		$subIdEncrypt = $_GET['clone'];
    	$subjectId = base64_decode($_GET['clone']);
	}
    $obj = new Subjects();
    $result = $obj->getDataBySubjectID($subjectId);
    $row = $result->fetch_assoc();
    if ($row) {
        if (isset($row['program_year_id'])) {
            $cycleDataall = $obj->getCycleDataByProgId($row['program_year_id']);
            while ($cycleDatas = mysqli_fetch_assoc($cycleDataall)) {
                $cycleData[] = $cycleDatas['id'];
            }
        }
        if (isset($row['cycle_no'])) {
            $cycle_no = $row['cycle_no'];
        }
    } else {
        header('Location: subject_view.php');
        exit();
    }
} else {
	if($user['add_role'] != '1')
	{
		header("location:page_not_found.php");
	}
    $disSession = "disabled";
    $disDivCss = "style='opacity:.5; pointer-event:none;display:block'";
	$disMainDivCss = "style='opacity:.5; pointer-event:none;display:block'";
}
//$objT = new Teacher();
$rel_teacher1 = $objT->getTeachers();
if(isset($_GET['edit']) && $_GET['edit'] != ""){
	//code for edit mode
	$subjectName = isset($_GET['edit']) ? $row['subject_name'] : (isset($_POST['txtSubjName']) ? $_POST['txtSubjName'] : '');
	$subjectCode = isset($_GET['edit']) ? $row['subject_code'] : (isset($_POST['txtSubjCode']) ? $_POST['txtSubjCode'] : '');
	$areaId = isset($_GET['edit']) ? $row['area_id'] : (isset($_POST['slctArea']) ? $_POST['slctArea'] : '');
	$progId = isset($_GET['edit']) ? $row['program_year_id'] : (isset($_POST['slctProgram']) ? $_POST['slctProgram'] : '');
}else if(isset($_GET['clone']) && $_GET['clone'] != ""){
	//code while creating the clone
	$subjectName = isset($_GET['clone']) ? $row['subject_name'] : (isset($_POST['txtSubjName']) ? $_POST['txtSubjName'] : '');
	//$subjectCode = isset($_GET['clone']) ? $row['subject_code'] : (isset($_POST['txtSubjCode']) ? $_POST['txtSubjCode'] : '');
	$areaId = isset($_GET['clone']) ? $row['area_id'] : (isset($_POST['slctArea']) ? $_POST['slctArea'] : '');
	$progId = isset($_GET['clone']) ? $row['program_year_id'] : (isset($_POST['slctProgram']) ? $_POST['slctProgram'] : '');
}
//edit values for  edit activity / session
if (isset($_GET['edit_actid']) && isset($_GET['edit_sessid'])) {
    $act_hidden_id = $_GET['edit_actid'];
    $sess_hidden_id = $_GET['edit_sessid'];
    $dataSessArr = $objS->getSessionRow($sess_hidden_id);
    $dataActArr = $objS->getActRow($act_hidden_id);
	$result_act = $objS->getAllActivities($sess_hidden_id);
	while($dataTeachArr = $result_act->fetch_assoc()) {
		$pos = strpos($dataTeachArr['teacher_id'],",");
		
		if($pos == false)
		{
			$teachers[] = $dataTeachArr['teacher_id'];
		}
		else
		{
			$teachers_all = explode(",",$dataTeachArr['teacher_id']);
			foreach($teachers_all as $tid)
			{
				$teachers[] = $tid;
			}
		}
		$activities[] = $dataTeachArr['id'];
	}
//	echo "here";print"<pre>";print_r($teachers);print"</pre>";die;
    $sess_btn_lbl = "Update Session";
} else {
    $sess_btn_lbl = "Add Session";
    $act_hidden_id = '';
    $sess_hidden_id = '';
}

$sess_name_edit = isset($_GET['edit_actid']) ? $dataSessArr['session_name'] : '';
$sess_duration_edit = isset($_GET['edit_actid']) ? $dataSessArr['duration'] : '';
$sess_teacherid_edit = isset($_GET['edit_actid']) ? $dataActArr['teacher_id'] : '';
$sess_roomid_edit = isset($_GET['edit_actid']) ? $dataActArr['room_id'] : '';
$sess_act_date_edit = isset($_GET['edit_actid']) ? $dataActArr['act_date'] : '';
$sess_starttime_edit = isset($_GET['edit_actid']) ? $dataActArr['start_time'] : '';
$sess_caseno_edit = isset($_GET['edit_actid']) ? $dataSessArr['case_number'] : '';
$sess_technical_notes_edit = isset($_GET['edit_actid']) ? $dataSessArr['technical_notes'] : '';
$sess_description_edit = isset($_GET['edit_actid']) ? $dataSessArr['description'] : '';
?>
<style type="text/css">
#content tr:nth-child(2n+1) {
    background: none;
}
</style>
<div id="content">
    <div id="main">
<?php if (isset($_SESSION['succ_msg'])) {
    echo '<div class="full_w green center">' . $_SESSION['succ_msg'] . '</div>';
    unset($_SESSION['succ_msg']);
} ?>
        <div class="custtd_left red">
<?php if (isset($_SESSION['error_msg']))
    echo $_SESSION['error_msg']; unset($_SESSION['error_msg']);
?>
        </div>
        <div id="addSubAndSess" class="addSubAndSess" <?php /* ?>style="opacity:.5; pointer-event:none;"<?php */ ?>>
            <div class="full_w">
				<?php if(isset($_GET['clone']) && $_GET['clone'] != ""){ ?>
						<div class="h_title">Clone of Subject "<?php echo $subjectName; ?>"</div>
				 <?php }else{ ?>
				 		<div class="h_title">Subject</div>
				 <?php } ?>
                <form name="subjectForm" id="subjectForm" action="postdata.php" method="post">
                    <input type="hidden" name="form_action" value="<?php echo $action;?>" />
                    <input type="hidden" id="subjectId" name="subjectId" value="<?php echo $subjectId; ?>" />
                    <input type="hidden" id="subIdEncrypt" name="subIdEncrypt" value="<?php echo $subIdEncrypt; ?>" />
                    <input type="hidden" id="act_hidden_id" name="act_hidden_id" value="<?php echo $act_hidden_id; ?>" />
                    <input type="hidden" id="sess_hidden_id" name="sess_hidden_id" value="<?php echo $sess_hidden_id; ?>" />
					<input type="hidden" id="cloneId" name="cloneId" value="<?php echo $subIdEncrypt; ?>" />
					<input type="hidden" id="program_year_id" name="program_year_id" value="<?php echo $progId; ?>" />
					<input type="hidden" id="cycle_id" name="cycle_id" value="<?php echo $cycle_no; ?>" />
					<input type="hidden" id="rule_id_grp" name="rule_id_grp" value="<?php echo $rule_id_grp_str; ?>" />
                    <div class="custtable_left">
                        <div class="addSubDiv" <?php echo $disFDivCss; ?>>
                            <div class="custtd_left">
                                <h2>Choose Program<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctProgram" name="slctProgram" class="select1 required" <?php echo $disTest; ?> onchange="getCycleByProgId(this)">
                                    <option value="" selected="selected">--Select Program--</option>
                                    <?php
                                    $program_qry = "select * from program_years";
                                    $program_result = mysqli_query($db, $program_qry);
                                    while ($program_data = mysqli_fetch_assoc($program_result)) {
                                        $program_year_detail = $program_data['name'] . ' ' . $program_data['start_year'] . ' ' . $program_data['end_year'];
                                        $selected = (trim($progId) == trim($program_data['id'])) ? ' selected="selected"' : '';
                                        ?>
                                        <option value="<?php echo $program_data['id']; ?>" <?php echo $selected; ?>><?php echo $program_data['name']; ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Cycle<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctCycle" name="slctCycle" class="select1 required" <?php echo $disTest; ?>>
                                    <option value="" selected="selected">--Select Cycle--</option>
                                    <?php
                                    if (count($cycleData) > 0) {
                                        for ($i = 0; $i < count($cycleData); $i++) {
                                            $selected = ($cycleData[$i] == $cycle_no) ? ' selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $cycleData[$i]; ?>" <?php echo $selected; ?>><?php echo $i + 1; ?></option>
    <?php }
} ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Area <span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctArea" name="slctArea" class="select1 required" <?php echo $disTest; ?>>
                                    <option value="" selected="selected">--Select Area--</option>
<?php
$area_qry = "select * from area";
$area_result = mysqli_query($db, $area_qry);
while ($area_data = mysqli_fetch_assoc($area_result)) {
    $selected = (trim($areaId) == trim($area_data['id'])) ? ' selected="selected"' : '';
    ?>
                                        <option value="<?php echo $area_data['id'] ?>" <?php echo $selected; ?>><?php echo $area_data['area_name']; ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Subject Name<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt required" id="txtSubjName" maxlength="50" name="txtSubjName" value="<?php echo $subjectName; ?>" <?php echo $disTest; ?>>
                            </div>
                            <div class="clear"></div>
                            <input type="hidden" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="<?php if($subjectCode != "") echo $subjectCode;?>">
							<div class="sessionboxSub btnSessiondiv">
                                <div style="float:left; width:175px;"><input type="submit" name="saveSubject" class="buttonsub" <?php echo $disTest; ?> value="Save Subject">
								<input type="button" name="btnCancel" class="buttonsub" <?php echo $disTest; ?> value="Cancel" onclick="location.href = 'subject_view.php';"></div>
                            </div>
                            <div class="clear"></div>
                        </div>						
						<div class="custtd_left" <?php echo $disMainDivCss; ?>>
							<h2 style="margin-top:20px;"><strong>Create Sessions By</strong></h2>
                        </div>
						<div>
							<select name="allocation_style" id="allocation_style" style="height:27px;margin-top:20px; width:150px;margin-left:13px;" onchange="setAllocation(this.value);" <?php echo $disSession; ?>>
								<option value="Allocation by Individual">Individual</option>
								<option value="Allocation by Rule" <?php echo $selectedRule;?>>Rule</option>								
							</select>
						</div>					
						<div id="rule_div" style="padding-top:20px;margin-top:10px;width:1200px;<?php echo $ruleCSS;?>" class="sessionData" <?php echo $disDivCss; ?>>
							<div class="custtd_left" style="width:95px;">
                                <h2>Session Name<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt" id="txtSessName" maxlength="50" name="txtSessName" style="width:151px;">
                            </div>
                            <div class="custtd_left" style="width:65px;margin-left:20px;">
                                <h2>Teacher<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctTeacherRule" name="slctTeacherRule[]" class="required" onchange="processSelectBoxRule();" multiple="multiple" <?php echo $disSession; ?> style="width:151px; height:75px;">
										<?php
										while ($row = $rel_teacher->fetch_assoc()) {
											if(in_array($row['id'],$teachers))
											{
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}
											$teacherName="";
											$teacherName = $row['teacher_name'];
											if($row['email'] !=""){
												$teacherName = $row['teacher_name'] . ' (' . $row['email'] . ')';
											}
											echo '<option '.$selected.' value="' . $row['id'] . '">' . $teacherName. '</option>';
										}
										?>                       
								</select>
                            </div>
                            <div class="custtd_left" style="width:152px;margin-left:20px;">
                                <h2>Multiple Teacher Reason<span class="redstar">*</span></h2>
                            </div>
							<div class="txtfield">
								<select id="reasonRule" name="reasonRule" class="required" <?php echo $disSession; ?> style="height:27px; width:151px;">
								 <option value="">--Select--</option>
								 <option <?php if(isset($dataActArr['reason']) && $dataActArr['reason'] == 'Alternate Choices for Session') echo 'selected';?> value="Alternate Choices for Session">Alternate Choices for Session</option>
								 <option <?php if(isset($dataActArr['reason']) && $dataActArr['reason'] == 'Teaching Session Jointly') echo 'selected';?> value="Teaching Session Jointly">Teaching Session Jointly</option>
							   </select>									  
                             </div>
							 <div class="clear"></div>
							 <div style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-top:10px; width:1200px;">
								<div class="custtd_left">
									<h2><strong>Create A New Rule:-</strong></h2>
								</div>
								<div class="clear"></div>
								<div class="custtd_left" style="width:180px;">
									<h2>Schedule Name <span class="redstar">*</span></h2>
								</div>
								<div class="txtfield">
									<input type="text" class="inp_txt" id="txtSchd" maxlength="50" name="txtSchd">
								</div>												
								 <div class="custtd_left" style="margin-left:20px;width:150px;">
									<h2>Time Interval <span class="redstar">*</span></h2>
								 </div>
								<div class="txtfield"style="padding-top:7px;">
									From:<input type="text" size="12" id="fromSpecialAval" name="fromSpecialAval" />
									To:<input type="text" size="12" id="toSpcialAval" name="toSpcialAval" />
								</div>
								<div class="clear"></div>
								<div class="custtd_left" style="width:180px;">
									<h2>Occurring<span class="redstar">*</span></h2>
								</div>
								<div class="txtfield">
									<select id="c1chWeek1" name="c1chWeek1" class="select1 required" onchange="showCycleDetails(this.value);">
										<option value="1w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
										<option value="2w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
									</select>
								</div>
								<div class="clear"></div>
								<div class="custtd_left" id="custtd_leftc1w1" style="width:180px;">
									<h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
								</div>
								<div class="txtfield" >
									<div id="c1week1">
										<div class="tmSlotc1w1">
											<input type="checkbox" id="Mon1C1W1" name="day[]"  value="Mon1C1W1" class="special_days"/><span class="dayName"> Mon </span>
											<div id="sp-act-ts-mon-w1">
												<div>Duration</div>
												<select name="duration-sp-mon" id="duration-sp-mon-w1" class="cls-duration-sp-mon" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-mon-w1" name="Mon[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w1">
										<input type="checkbox" id="Tue1C1W1" name="day[]"  value="Tue1C1W1" class="special_days"/><span class="dayName"> Tue </span>
											<div id="sp-act-ts-tue-w1">
												<div>Duration</div>
												<select name="duration-sp-tue" id="duration-sp-tue-w1" class="cls-duration-sp-tue" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-tue-w1" name="Tue[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w1">
										<input type="checkbox" id="Wed1C1W1" name="day[]"  value="Wed1C1W1" class="special_days"/><span class="dayName"> Wed </span>
											<div id="sp-act-ts-wed-w1">
												<div>Duration</div>
												<select name="duration-sp-wed" id="duration-sp-wed-w1" class="cls-duration-sp-wed" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-wed-w1" name="Wed[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w1">
										<input type="checkbox" id="Thu1C1W1" name="day[]"  value="Thu1C1W1" class="special_days"/><span class="dayName"> Thu </span>
											<div id="sp-act-ts-thu-w1">
												<div>Duration</div>
												<select name="duration-sp-thu" id="duration-sp-thu-w1" class="cls-duration-sp-thu" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-thu-w1" name="Thu[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w1">
										<input type="checkbox" id="Fri1C1W1" name="day[]"  value="Fri1C1W1" class="special_days"/><span class="dayName"> Fri </span>
											<div id="sp-act-ts-fri-w1">
												<div>Duration</div>
												<select name="duration-sp-fri" id="duration-sp-fri-w1" class="cls-duration-sp-fri" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-fri-w1" name="Fri[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w1">
										<input type="checkbox" id="Sat1C1W1" name="day[]"  value="Sat1C1W1" class="special_days"/><span class="dayName"> Sat </span>
											<div id="sp-act-ts-sat-w1">
												<div>Duration</div>
												<select name="duration-sp-sat" id="duration-sp-sat-w1" class="cls-duration-sp-sat" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-sat-w1" name="Sat[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>		
										</div>
									</div>
								</div>
								<div class="clear"></div>
								<div class="custtd_left" id="custtd_leftc1w2" style="display:none;width:180px;">
									<h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
								</div>
								<div class="txtfield" >
									<div id="c1week2" style="display:none;">
										<div class="tmSlotc1w2">
											<input type="checkbox" id="Mon2C1W2" name="day[]"  value="Mon2C1W2" class="special_days"/><span class="dayName"> Mon </span>
											<div id="sp-act-ts-mon-w2">
												<div>Duration</div>
												<select name="duration-sp-mon" id="duration-sp-mon-w2" class="cls-duration-sp-mon" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-mon-w2" name="Mon[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w2">
										<input type="checkbox" id="Tue2C1W2" name="day[]"  value="Tue2C1W2" class="special_days"/><span class="dayName"> Tue </span>
											<div id="sp-act-ts-tue-w2">
												<div>Duration</div>
												<select name="duration-sp-tue" id="duration-sp-tue-w2" class="cls-duration-sp-tue" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-tue-w2" name="Tue[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w2">
										<input type="checkbox" id="Wed2C1W2" name="day[]"  value="Wed2C1W2" class="special_days"/><span class="dayName"> Wed </span>
											<div id="sp-act-ts-wed-w2">
												<div>Duration</div>
												<select name="duration-sp-wed" id="duration-sp-wed-w2" class="cls-duration-sp-wed" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-wed-w2" name="Wed[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w2">
										<input type="checkbox" id="Thu2C1W2" name="day[]"  value="Thu2C1W2" class="special_days"/><span class="dayName"> Thu </span>
											<div id="sp-act-ts-thu-w2">
												<div>Duration</div>
												<select name="duration-sp-thu" id="duration-sp-thu-w2" class="cls-duration-sp-thu" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-thu-w2" name="Thu[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w2">
										<input type="checkbox" id="Fri2C1W2" name="day[]"  value="Fri2C1W2" class="special_days"/><span class="dayName"> Fri </span>
											<div id="sp-act-ts-fri-w2">
												<div>Duration</div>
												<select name="duration-sp-fri" id="duration-sp-fri-w2" class="cls-duration-sp-fri" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-fri-w2" name="Fri[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>
										</div>
										<div class="tmSlotc1w2">
										<input type="checkbox" id="Sat2C1W2" name="day[]"  value="Sat2C1W2" class="special_days"/><span class="dayName"> Sat </span>
											<div id="sp-act-ts-sat-w2">
												<div>Duration</div>
												<select name="duration-sp-sat" id="duration-sp-sat-w2" class="cls-duration-sp-sat" >
												   <?php echo $option_duration;?>
												</select>
												<div>Start Time</div>
												<select id="ts-sp-sat-w2" name="Sat[]" class="slctSpTs">
													  <option value="">--Select--</option>
													  <?php echo $tslot_dropDwn;?>
												</select>
											</div>		
										</div>
									</div>
								</div>
								<div class="clear"></div>
								<div class="custtable_left div-arrow-img" style="cursor:pointer">
									<input type="button" name="saveRule" class="buttonsub" value="Create Rule" onclick="createActivityAvailRule();">
								</div>
								<div class="clear"></div>
							</div>
							<div class="scheduleBlockAct" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-top:10px;">
								<div>
									<span style="font-size:14px"><b>OR Select A Pre-defined Rule for Creating Sessions :</b></span>
								</div>
								<div>
									<ul id="rules" name="rules" class="rule">
										<table border="1" >
										   <?php
											$count = 0;
											while($data = $ActivityAvailData->fetch_assoc()){
												$rule_id=$data['id'];
												if($count%6 == 0){ echo "<tr>"; }  ?>
													<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;"><li style="min-height:20px;" class="main-title"><input type="checkbox" name="ruleval[]" value="<?php echo $data['id']; ?>"  class="rule_checkbox" <?php if(in_array($data['id'], $rule_id_gr_arr)) { echo "checked"; } ?>/><b>&nbsp;<?php echo $data['rule_name']; ?></b>
													<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onclick="deleteActivityByRule(<?php echo $rule_id; ?>);" src="images/delete-rule.png" /></span>
													</li>
													<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span><br/>
													<span>Occurrence: <?php if($data['occurrence'] == '1w') echo 'Weekly';else if($data['occurrence'] == '2w') echo 'Biweekly';else echo 'N/A'; ?></span>
													<ul class="listing">
														<?php //get the day and timeslot
														$week1=$week2='';
														$tsobj = new Timeslot();
														if($data['week1']!='' &&  count(unserialize($data['week1']))>0){
															foreach(unserialize($data['week1']) as $key=> $value)
															{
																$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
																$week1 = $week1." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
															}
														}
														if(count(unserialize($data['week2']))>0)
														{
															if($data['occurrence'] == '2w'){
																foreach(unserialize($data['week2']) as $key=> $value)
																{
																	$tsobj = new Timeslot();
																	$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
																	$week2 = $week2." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
																}
															}
														}
														?>
														<?php if($data['week1']!=''){?>
														<li><b>Week1:</b><br/><?php echo $week1;?></li>
														<?php } if($data['occurrence'] == '2w'){?>
														<li><b>Week2:</b><br/><?php echo $week2;?></li>
														<?php } ?>
													</ul>
												</div>
											</td>								
										<?php $count++; } ?>
										</tr>
										</table>
									</ul>
								</div>
							</div>
							<div class="clear"></div>
							<div class="txtfield" style="margin-top:15px;">
								<input type="button" name="btnSave" class="buttonsub" value="Save" onclick="checkSubjectForm();">
							</div>
							<div class="clear"></div>
						</div>
                        <div id="individual_div" class="sessionData" <?php echo $disDivCss; ?>>
                            <div class="custtd_left">
                                <h2><strong>Manage Sessions:-</strong></h2>
                            </div>
                            <div class="txtfield" style="padding:0px;">
                                <div class="sessionboxSub" style="width:108px;">
                                    <h3>Session Name<span class="redstar">*</span></h3>
                                    <input type="text" class="inp_txt_session required" <?php echo $disSession; ?> id="txtSessionName" maxlength="50" style="width:94px;" name="txtSessionName" value="<?php echo $sess_name_edit; ?>">
                                </div>
                                <div class="sessionboxSub" style="width:108px;">
                                    <h3>Duration(Hr)<span class="redstar">*</span></h3>
                                    <select name="duration" id="duration" class="activity_row_chk" <?php echo $disSession; ?> style="height:27px; width:106px">
                                        <option value="">--Select--</option>
                                        <option value="15">00:15</option>
                                        <option value="30">00:30</option>
                                        <option value="45">00:45</option>
                                        <option value="60" selected="selected">01:00</option>
                                        <option value="75">01:15</option>
                                        <option value="90">01:30</option>
                                        <option value="105">01:45</option>
                                        <option value="120">02:00</option>
                                        <option value="135">02:15</option>
                                        <option value="150">02:30</option>
                                        <option value="165">02:45</option>
                                        <option value="180">03:00</option>
                                        <option value="195">03:15</option>
                                        <option value="210">03:30</option>
                                        <option value="225">03:45</option>
                                        <option value="240">04:00</option>
                                        <option value="255">04:15</option>
                                        <option value="270">04:30</option>
                                        <option value="285">04:45</option>
                                        <option value="300">05:00</option>
                                        <option value="315">05:15</option>
                                        <option value="330">05:30</option>
                                        <option value="345">05:45</option>
                                        <option value="300">06:00</option>
                                        <option value="315">06:15</option>
                                        <option value="330">06:30</option>
                                        <option value="345">06:45</option>
                                        <option value="300">07:00</option>
                                        <option value="315">07:15</option>
                                        <option value="330">07:30</option>
                                        <option value="345">07:45</option>
                                        <option value="345">08:00</option>
                                    </select>
                                    <script type="text/javascript">
                                        jQuery('#duration').val("<?php echo $sess_duration_edit; ?>");
                                    </script>
                                </div>
                                 <div class="sessionboxSub" style="width:150px;">
                                    <h3>Teacher<span class="redstar">*</span></h3>									
										<select id="slctTeacherInd" name="slctTeacherInd[]" class="required" onchange="processSelectBoxInd();" multiple="multiple" <?php echo $disSession; ?> style="width:151px; height:75px;">
										<?php
										while ($row = $rel_teacher1->fetch_assoc()) {
											if(in_array($row['id'],$teachers))
											{
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}
											$teacherName="";
											$teacherName = $row['teacher_name'];
											if($row['email'] !=""){
												$teacherName = $row['teacher_name'] . ' (' . $row['email'] . ')';
											}
											echo '<option '.$selected.' value="' . $row['id'] . '">' . $teacherName. '</option>';
										}
										?>                       
									   </select>
									   <?php
										foreach($activities as $value)
										{
										  echo '<input type="hidden" name="postdata[]" value="'. $value. '">';
										}
										?>
                                    
                                </div>
								<div class="sessionboxSub" style="width:165px;margin-left:5px;">
                                    <h3>Multiple Teacher Reason</h3>									
										<select id="reasonInd" name="reason" class="required" <?php echo $disSession; ?> style="height:27px; width:140px;">
										 <option value="">--Select--</option>
										 <option <?php if(isset($dataActArr['reason']) && $dataActArr['reason'] == 'Alternate Choices for Session') echo 'selected';?> value="Alternate Choices for Session">Alternate Choices for Session</option>
										 <option <?php if(isset($dataActArr['reason']) && $dataActArr['reason'] == 'Teaching Session Jointly') echo 'selected';?> value="Teaching Session Jointly">Teaching Session Jointly</option>
									   </select>									  
                                </div>
                                <div class="sessionboxSub" style="width:108px;">
                                    <h3>Room</h3>
                                    <select name="room_id" id="room_id" class="activity_row_chk" <?php echo $disSession; ?> style="height:27px; width:106px;">
                                        <option value="">--Select--</option>
<?php echo $room_dropDwn; ?>
                                    </select>
                                    <script type="text/javascript">
                                        jQuery('#room_id').val("<?php echo $sess_roomid_edit; ?>");
                                    </script>
                                </div>
                                <div class="sessionboxSub" style="width:105px;">
                                    <h3>Date</h3>
                                    <input type="text" size="12" id="subSessDate" value="<?php echo ($sess_act_date_edit=='0000-00-00') ? '' : $sess_act_date_edit; ?>" <?php echo $disSession; ?> style="height:23px; width:102px;"/>
                                </div>
                                <div class="sessionboxSub" style="width:108px;">
                                    <h3>Start Time</h3>
                                    <select name="tslot_id" id="tslot_id" class="activity_row_chk" <?php echo $disSession; ?> style="height:27px; width:106px">
                                        <option value="">--Select--</option>
<?php echo $tslot_dropDwn; ?>
                                    </select>
                                    <script type="text/javascript">
                                        jQuery('#tslot_id').val("<?php echo $sess_starttime_edit; ?>");
                                    </script>
                                </div>
								<div class="sessionboxSub" style="width:108px;">
                                    <h3>Case No</h3>
                                    <input type="text" class="inp_txt_session alphanumeric" <?php echo $disSession; ?> id="txtCaseNo" style="width:94px;" name="txtCaseNo" value="<?php echo $sess_caseno_edit; ?>">
                                </div>
                                <div class="sessionboxSub"style="width:150px;">
                                    <h3>Technical Notes</h3>
                                    <textarea style="height:40px; width:135px" class="inp_txt_session alphanumeric" <?php echo $disSession; ?> id="txtareatechnicalNotes" cols="20" rows="2" name="txtTechnicalNotes"><?php echo $sess_technical_notes_edit; ?></textarea>
                                </div>
                                <div class="sessionboxSub" style="width:150px;" >
                                    <h3>Description</h3>
                                    <textarea style="height:40px;" class="inp_txt_session alphanumeric" <?php echo $disSession; ?> id="txtareaSessionDesp" cols="20" rows="2" name="txtSessionDesp"><?php echo $sess_description_edit; ?></textarea>
                                </div>
								<div class="sessionboxSub addbtnSession" style="width:140px;float:right;">
                                    <input type="button" name="btnAddMore" <?php echo $disSession; ?> id="btnAddNewSess" class="btnSession buttonsub" value="<?php echo $sess_btn_lbl; ?>" style="width:115px; height:30px; margin-bottom: 1px;">

                                </div>
                                <div class="sessionboxSub addbtnSession" style="width:140px;float:right;">
                                    <input type="button" name="btnCheckAvail" id="btnCheckAvail" class="btnSession buttonsub" <?php echo $disSession; ?> value="Check Availability" style="height:30px;">
                                    <span style="display:none" name="showstatusAvail" id="showstatusAvail" ><img alt="OK" src="images/ok.gif" /></span>
                                    <span style="display:none" name="showstatusNoAvail" id="showstatusNoAvail" ><img alt="OK" src="images/error.gif" /></span>
                                    <!--<input style="display:none" type="button" name="showstatus" id="showstatus" class="btnSession buttonsub" value="">-->
                                </div>
                                </div>
                            <div class="clear"></div>
                        </div>
                        <div class="divSession" style="width:88%;text-align:left; <?php if(isset($_GET['clone']) && $_GET['clone'] != ""){ echo 'display:none'; } ?>">
                            <?php
                            if ($subjectId != "") {
                                $x = 0;
								$sessionHtml = '';
								$last_order ='';
								$sessionHtml.='<div class="sessionList">
												<table id="datatables" class="display datatableSession">
												  <thead>
												   <tr>
												   <td colspan="11">
												   <table>
												   <tr>
														<th width="8%">Session Name</th>
														<th width="8%">Duration</th>
														<th width="8%">Teacher</th>
														<th width="8%">Multiple Teacher Reason</th>
														<th width="8%">Room</th>
														<th width="8%">Date</th>
														<th width="8%">Start Time</th>
														<th width="8%">Case No</th>
														<th width="8%">Technical Notes</th>
														<th width="8%">Description</th>
														<td width="8%" style="display:none"></th>
														<th width="8%">Actions</th>
												   </tr>
												   </table>
												   </td>
												   </tr>
												  </thead>
												 <tbody>';
								$sql_get_act = "select id from subject_session WHERE subject_id = '" . $subjectId . "' order by order_number ASC";
								$query_get_act = mysqli_query($db, $sql_get_act);
								while($session_data = mysqli_fetch_assoc($query_get_act))
								{
									$sessionHtml.='<tr class="addColor"><td colspan="11" class="dragHandle"><table>';
									$subj_session_query = "select subs.id as sessionID, subs.*, ta.id as activityId,  ta.*, room.room_name, ts.start_time from  subject_session as subs LEFT JOIN teacher_activity as ta ON subs.id = ta.session_id LEFT JOIN room ON ta.room_id = room.id LEFT JOIN timeslot as ts ON ta.timeslot_id = ts.id WHERE ta.session_id='" . $session_data['id'] . "' order by subs.order_number ASC";
									$subj_session_result = mysqli_query($db, $subj_session_query);
									while ($subj_session_data = mysqli_fetch_assoc($subj_session_result)) {
										$x++;
										$actID = 0;
										if ($subj_session_data['activityId'] != "") {
											$actID = $subj_session_data['activityId'];
										}
										$edit_session_lnk = '<a class="table-icon edit" href="subjects.php?edit=' . $subIdEncrypt . '&edit_actid=' . $actID . '&edit_sessid=' . $subj_session_data['sessionID'] . '"></a>  |  ';
										//setting default duration as 15 min for the activities
										$duration = $subj_session_data['duration'];
										if ($duration == "") {
											$duration = "15";
										} 
										$act_Date = (trim($subj_session_data['act_date'])=='0000-00-00') ? '' : $subj_session_data['act_date'];
										$teacher_array = explode(",",$subj_session_data['teacher_id']);
										$teachers_names = array();
										foreach($teacher_array as $teacher_id)
										{
											$sql_teach = "select teacher_name from teacher where id='".$teacher_id."'";
											$sql_teach_result = mysqli_query($db, $sql_teach);
											$sql_teach_result_data = mysqli_fetch_assoc($sql_teach_result);
											$teachers_names[] = $sql_teach_result_data['teacher_name'];
										}
										$teacher_str = implode(" , ",$teachers_names);
										$sessionHtml.='<tr  id="' . $x . '" >
										<td width="8%">' . $subj_session_data['session_name'] . '</td>
										<td width="8%">' . date('H:i', mktime(0, $duration)) . '</td>
										<td width="8%">' . $teacher_str . '</td>
										<td width="8%">' . $subj_session_data['reason'] . '</td>
										<td width="8%">' . $subj_session_data['room_name'] . '</td>
										<td width="8%">' . $act_Date . '</td>
										<td width="8%">' . $subj_session_data['start_time'] . '</td>
										<td width="8%">' . $subj_session_data['case_number'] . '</td>
										<td width="8%">' . $subj_session_data['technical_notes'] . '</td>
										<td width="8%">' . $subj_session_data['description'] . '</td>';
											$sessionHtml.='<td width="8%" style="display:none"><input type="hidden" name="sessionName[]" id="sessionName' . $x . '"  value="' . $subj_session_data['session_name'] . '"/>

										<input type="hidden" name="sessionDesc[]" id="sessionDesc' . $x . '"  value="' . $subj_session_data['description'] . '"/>
										<input type="hidden" name="sessionCaseNo[]" id="sessionCaseNo' . $x . '"  value="' . $subj_session_data['case_number'] . '"/>
										<input type="hidden" name="sessionTechNote[]" id="sessionTechNote' . $x . '"  value="' . $subj_session_data['technical_notes'] . '"/>
										<input type="hidden" name="sessionOrder[]" id="sessionOrder' . $x . '"  value="' . $subj_session_data['order_number'] . '"/>
										<input type="hidden" name="sessionRowId[]" id="sessionRowId' . $x . '"  value="' . $subj_session_data['id'] . '"/>
										<input type="hidden" name="sessionSubId[]" id="sessionSubId' . $x . '"  value="' . $subj_session_data['sessionID'] . '"/></td>
										<td width="8%" id=' . $x . '>' . $edit_session_lnk . '<a class="table-icon delete remove_field" onclick="removeSession(' . $actID . ',' . $subj_session_data['sessionID'] . ', \'' . base64_encode($subjectId) . '\', ' . $x . ');"></a></td></tr>';
									}
									$sessionHtml.='</table></td></tr>';

								}
							    
                               
                                $sessionHtml.='<input type="hidden" name="maxSessionListVal" id="maxSessionListVal"  value="' . $x . '"/>';
                                $sessionHtml.='<input type="hidden" name="EditMaxExceptnListVal" id="EditMaxExceptnListVal"  value="' . $x . '"/>';
                                $sessionHtml.='<input type="hidden" name="sessionIDVal" id="sessionIDVal"  value=""/>';
                                $sessionHtml.='<input type="hidden" name="sessionIDSubject" id="sessionIDSubject"  value=""/>';
                                $sessionHtml.='<input type="hidden" name="serialNum" id="serialNum"  value=""/>';
                                $sessionHtml.='<input type="hidden" name="sessionIDSArr" id="sessionIDSArr"  value=""/>';
                                $sessionHtml.='</tbody></table></div>';
                                echo $sessionHtml;
                                ?>
                                <script type="text/javascript">sortingSession();</script>
						<?php } ?>
                        </div>
                        <div class="clear"></div>
                        <div class="custtd_left">
                        </div>
                        <div class="txtfield">
<?php //if($subjectName==""){  ?>
                                <!--<input type="submit" name="btnAddSubject" class="buttonsub" value="Save Session">-->
<?php //}  ?>
                        </div>
                        <div class="txtfield">
                            <input style=" <?php if(isset($_GET['clone']) && $_GET['clone'] != ""){ echo 'display:none'; } ?>" type="button" name="btnCancel" class="buttonsub" value="<?php echo $buttonName = ($subjectName != "") ? "Done" : "Cancel" ?>" onclick="location.href = 'subject_view.php';">
                        </div>
                    </div>
					<div class="sessionboxSub" id="dialog-confirm" title="Message">
						<p>Teacher is already allocated to two saturdays of this cycle.</p>
					</div>
					<div class="sessionboxSub" id="dialog-confirm-area" title="Message">
						<p>The sessions scheduled on Saturdays should be from the same academic area.</p>
					</div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
