<?php include('header.php');
$obj = new SpecialActivity();
$objTeach = new Teacher();
$teacherData = $objTeach->getTeachers();
$specialAvailData = $obj->getSpecialAvailRule();
$obj2 = new Timeslot();
$tslot_dropDwn = $obj2->getTimeSlotStartDateDropDwn();
$disFDivCss = "style=''";
$special_act_id="";
$activity_filter_val = (isset($_POST['activity_color_filter']) && $_POST['activity_color_filter']!="")?$_POST['activity_color_filter']:'';
$options = '<option value="08:00 AM-09:00 AM">08:00 AM-09:00 AM</option>
			<option value="09:00 AM-10:00 AM">09:00 AM-10:00 AM</option>
			<option value="10:00 AM-11:00 AM">10:00 AM-11:00 AM</option>
			<option value="11:00 AM-12:00 PM">11:00 AM-12:00 PM</option>
			<option value="12:00 PM-01:00 PM">12:00 PM-01:00 PM</option>
			<option value="01:00 PM-02:00 PM">01:00 PM-02:00 PM</option>
			<option value="02:00 PM-03:00 PM">02:00 PM-03:00 PM</option>
			<option value="03:00 PM-04:00 PM">03:00 PM-04:00 PM</option>
			<option value="04:00 PM-05:00 PM">04:00 PM-05:00 PM</option>
			<option value="05:00 PM-06:00 PM">05:00 PM-06:00 PM</option>
			<option value="06:00 PM-07:00 PM">06:00 PM-07:00 PM</option>
			<option value="07:00 PM-08:00 PM">07:00 PM-08:00 PM</option>
			<option value="08:00 PM-09:00 PM">08:00 PM-09:00 PM</option>
			<option value="09:00 PM-10:00 PM">09:00 PM-10:00 PM</option>
			<option value="10:00 PM-11:00 PM">10:00 PM-11:00 PM</option>';

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
$name="";
$teachId = ""; $decodeTeachId="";
$mappedruleids = array();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$special_act_id = base64_decode($_GET['edit']);
	$detail = $obj->specialActivityDetail($special_act_id);
	//echo '<pre>';
	//print_r($detail);
}
	$ad_hoc_act_date_dd = "";
	if(isset($detail['reserved_flag']) && $detail['reserved_flag']=="5" && $detail['adhoc_start_date']=="0000-00-00"){
		$ad_hoc_act_date_dd="1";
	}else if(isset($detail['reserved_flag']) && $detail['reserved_flag']=="5"){
		$ad_hoc_act_date_dd="2";
	}else{
		$ad_hoc_act_date_dd="";
	}
	$special_act_name =(isset($detail['special_activity_name']) && $detail['special_activity_name']!="")? $detail['special_activity_name'] :"";
	$special_activity =(isset($detail['reserved_flag']) && $detail['reserved_flag']!="")? $detail['reserved_flag'] :"";
	$special_activity_type =(isset($detail['special_activity_type']) && $detail['special_activity_type']!="")? $detail['special_activity_type'] :"";
	$program_year_id =(isset($detail['program_year_id']) && $detail['program_year_id']!="")? $detail['program_year_id'] :"";
	$cycle_id =(isset($detail['cycle_id']) && $detail['cycle_id']!="")? $detail['cycle_id'] :"";
	$area_id =(isset($detail['area_id']) && $detail['area_id']!="")? $detail['area_id'] :"";
	$room_id =(isset($detail['room_id']) && $detail['room_id']!="")? $detail['room_id'] :"";
	$subject_id =(isset($detail['subject_id']) && $detail['subject_id']!="")? $detail['subject_id'] :"";
	$subject_val=(isset($detail['subject_id']) && $detail['subject_id']==0)? "N/A": "";
	$teacher_id =(isset($detail['teacher_id']) && $detail['teacher_id']!="")? $detail['teacher_id'] :"";
	$act_date =(isset($detail['act_date']) && $detail['act_date']!="")? $detail['act_date'] :"";
	$start_time_id =(isset($detail['start_time']) && $detail['start_time']!="")? $detail['start_time'] :"";
	$duration =(isset($detail['duration']) && $detail['duration']!="")? $detail['duration'] :"";
	//$actName=(isset($detail['act_name']) && $detail['act_name']!="")? $detail['act_name'] :"";
	$disabled =(isset($special_act_id) && $special_act_id!="")? 'disabled="disabled"' :"";
	$btnSubmit =(isset($_GET['edit']) && $_GET['edit']!="")? "Update" :"Save";
	$objTS = new Timeslot();
	$tslot_dropDwn = $objTS->getTimeSlotStartDateDropDwn();
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Recess Activity / Group Meetings / Ad-hoc Activity</div>
			<form name="specialActivityForm" id="specialActivityForm" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditSpecialActivity" />
				<input type="hidden" id="special_act_id" name="special_act_id" value="<?php echo $special_act_id; ?>" />
                <div class="custtable_left">
				<div class="custtd_left red">
					<?php if(isset($_SESSION['error_msg']))
						echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
				</div>
				<div class="clear"></div>
                <div class="custtable_left">
				<!-- new -->
				<div class="addSubDiv">
                            <div class="custtd_left">
                                <h2 class="blod-text">Activity Name<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt" id="txtActName" maxlength="50" name="txtActName" value="<?php echo $special_act_name;?>" <?php echo $disabled;?>>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left">
                                <h2 class="blod-text">Choose Activity Type<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="special_activity" name="special_activity" class="select1" onchange="specialActivity();" <?php echo $disabled;?>> 
									<option value="" selected="selected">--Select--</option>
									<option value="3" <?php if($special_activity == '3'){echo  'selected="selected"'; }?>>Recess Activities</option>
									<option value="4" <?php if($special_activity == '4'){echo  'selected="selected"'; }?>>Group Meetings</option>
									<option value="5" <?php if($special_activity == '5'){echo  'selected="selected"'; }?>>Adhoc Activities</option>
								</select>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left actType">
                                <h2 class="blod-text">Choose Activity Frequency<span class="redstar spanActivityType">*</span></h2>
                            </div>
                            <div class="txtfield actType">
                                <select id="special_activity_type" name="special_activity_type" class="select1" onchange="specialActivity();" <?php echo $disabled;?>> 
									<option value="" selected="selected">--Select--</option>
									<option value="1" <?php if($special_activity_type == '1' || $special_activity_type == '2'){echo  'selected="selected"'; }?>>One Time Activity</option>
									<option value="2">Periodic Activity</option>
								</select>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left otAct divDuration <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
                    		<div class="txtfield otAct <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       			Duration:<span class="redstar spanDuration">*</span><select name="duration" id="duration" class="activity_row_chk" >
                                        	<?php echo $option_duration;?>
                                    	  </select>
									<script type="text/javascript">
                                        jQuery('#duration').val("<?php echo $duration; ?>");
                                    </script>
							</div>
							<div class="txtfield otAct divDateSingle <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>">
								 Date:<input type="text" size="12" id="oneTimeDate"  name="oneTimeDate" class="txtfield" value="<?php 
								 if($special_activity_type == '1' || $special_activity_type == '2')
								 	{ echo $act_date;}else{ echo "";} ?>"/>
							</div> 
							<div class="txtfield otAct divTs <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>"> 
                                  Start Time:<select id="ot_tslot_id"  name="ot_tslot_id" >
                                        		<option value="">--Select--</option>
												<?php echo $tslot_dropDwn;?>
											</select>
									 <script type="text/javascript">
                                        jQuery('#ot_tslot_id').val("<?php echo $start_time_id; ?>");
                                    </script>
                    		</div>
                    		<div class="clear"></div>
							<div class="custtd_left otAct div-ad-hoc-label  <?php if($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
                    		<div class="txtfield otAct div-ad-hoc-date-slct <?php if($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
									Activity Date:<span class="redstar spanAdHocDate">*</span>
								 	<select name="ad_hoc_date_slct" id="ad_hoc_date_slct"  onchange="adHocDateShowHide();">
											<option value="">-Select-</option>
											<option value="1" <?php if($ad_hoc_act_date_dd == '1'){echo  'selected="selected"'; }?>>Fixed Date</option>
											<option value="2" <?php if($ad_hoc_act_date_dd == '2'){echo  'selected="selected"'; }?> >Range Date</option>
									</select>
							</div>
							<div class="txtfield otAct div-ad-hoc-fixed" >
								    Date:<span class="redstar spanAdHocDate">*</span>
									<input type="text" size="12" id="ad_hoc_fix_date"  name="ad_hoc_fix_date" class="txtfield" value=" "/>
							</div>
							<div class="txtfield otAct div-ad-hoc-range" >
									From:<input type="text" size="12" id="fromADHocDate"  name="fromADHocDate"/>
                        			To:<input type="text" size="12" id="toADHocDate" name="toADHocDate"/>
								    <script type="text/javascript">
                                        jQuery('#ad_hoc_date_slct').val("<?php echo $duration; ?>");
                                    </script>
							</div>		
							<div class="clear"></div>
							<div class="custtd_left">
                                <h2>Choose Program<span class="redstar spanPrgm">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctProgram" name="slctProgram" class="select1 required" onchange="getCycleByProgId(this)" <?php echo $disabled;?>>
                                    <option value="" selected="selected">--Select Program--</option>
                                    <?php
                                    $program_qry = "select * from program_years";
                                    $program_result = mysqli_query($db, $program_qry);
                                    while ($program_data = mysqli_fetch_assoc($program_result)) {
                                        $program_year_detail = $program_data['name'] . ' ' . $program_data['start_year'] . ' ' . $program_data['end_year'];
                                        $selected = (trim($program_year_id) == trim($program_data['id'])) ? ' selected="selected"' : '';
                                        ?>
                                        <option value="<?php echo $program_data['id']; ?>" <?php echo $selected; ?>><?php echo $program_data['name']; ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Cycle<span class="redstar spanCycle">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctCycle" name="slctCycle" class="select1 required" <?php echo $disabled;?> onchange="getSubjectByProgIDAndCycleID();">
                                    <option value="" selected="selected">--Select Cycle--</option>
                                    <?php
									if(isset($program_year_id) && $program_year_id!=""){
										$cycle_query="select * from cycle where program_year_id='".$program_year_id."'";
										$cycleDataall = mysqli_query($db, $cycle_query);
										$cycleData = array();
											while ($cycleDatas = mysqli_fetch_assoc($cycleDataall)){
												$cycleData[] = $cycleDatas['id'];
											}
									}
									if (count($cycleData) > 0) {
                                        for ($i = 0; $i < count($cycleData); $i++) {
										    $selected = (trim($cycle_id) == trim($cycleData[$i])) ? ' selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $cycleData[$i]; ?>" <?php echo $selected; ?>><?php echo $i + 1; ?></option>
										<?php }
									} ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Area <span class="redstar spanArea">*</span></h2>
                            </div>
                            <div class="txtfield ">
                                <select id="slctArea" name="slctArea" class="select1 required" <?php echo $disabled;?>>
                                    <option value="" selected="selected">--Select Area--</option>
						<?php
						$areaId = "";
						$area_qry = "select * from area";
						$area_result = mysqli_query($db, $area_qry);
						while ($area_data = mysqli_fetch_assoc($area_result)) {
							$selected = (trim($area_id) == trim($area_data['id'])) ? ' selected="selected"' : '';
							?>
                                        <option value="<?php echo $area_data['id'] ?>" <?php echo $selected;?>><?php echo $area_data['area_name']; ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
							 <div class="custtd_left">
                                <h2>Choose Room <span class="redstar spanRoom">*</span></h2>
                            </div>
							<div class="txtfield">
                                <select id="slctRoom" name="slctRoom" class="select1 required" <?php echo $disabled;?>>
                                    <option value="" selected="selected">--Select Room--</option>
									<option value="0">N/A</option>
								<?php
								$roomId = "";
								$room_qry = "select * from room";
								$room_result = mysqli_query($db, $room_qry);
								while ($room_data = mysqli_fetch_assoc($room_result)) {
									$selected = (trim($room_id) == trim($room_data['id'])) ? ' selected="selected"' : '';
									?>
                                        <option value="<?php echo $room_data['id'] ?>" <?php echo $selected;?>><?php echo $room_data['room_name']; ?></option>
							<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" >
                                <h2>Subject Name<span class="redstar spanSubject">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctSubjectName" name="slctSubjectName" class="select1 required" <?php echo $disabled;?> >
                                    <option value="" selected="selected">--Select Subject--</option>
                                    <option value="0">N/A</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" style="display:none;">
                                <h2>Subject Code <span class="redstar spanSubCode">*</span></h2>
                            </div>
                            <div class="txtfield" style="display:none;">
                                <input type="text" class="inp_txt" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="<?php echo $subject_val;?>" <?php echo $disabled;?>>
                            </div>
                            <div class="clear"></div>
                        </div>
				<!-- end -->
                    <div class="custtd_left">
                        <h2>Teacher <span class="redstar spanSubCode">*</span></h2>
                    </div>
                    <div class="txtfield">
					 <select id="slctTeacher" name="slctTeacher" class="select1 required" <?php echo $disabled;?> >
						<option value="" >--Select--</option>
						<?php while($data = $teacherData->fetch_assoc()){ 
							$selected = (trim($teacher_id) == trim($data['id'])) ? ' selected="selected"' : '';?>
									<option value="<?php echo $data['id']; ?>" <?php echo $selected;?> ><?php echo $data['teacher_name']; ?><?php if($data['email'] !=""){echo ' ('.$data['email'].')'; } ?></option>
						<?php } ?>
					</select>
                    </div>
                    <div class="clear"></div>
					<h4 style="color:#999999">Note: Each non-mandatory field in the above form are just for information purpose only and will not be used by the timetable allocation algorithm.</h4><br />
					<div class="clear"></div>
					<div class="scheduleBlockSpAct" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
					<div class="custtd_left">
                        <span style="font-size:14px"><b>Create A New Rule(optional):</b></span>
                    </div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Schedule Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtSchd" maxlength="50" name="txtSchd">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromSpecialAval" />
                        To:<input type="text" size="12" id="toSpcialAval" />
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Days and Timeslot<span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield" >
					    <div class="tmSlot">
                        <input type="checkbox" id="Mon" name="day[]"  value="Mon" class="days"/><span class="dayName"> Mon </span>
							<div class="sp-act-ts-mon">
								<div>Duration</div>
								<select name="duration-sp-mon" id="duration-sp-mon" class="cls-duration-sp-mon" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-mon" name="Mon[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue" name="day[]"  value="Tue" class="days"/><span class="dayName"> Tue </span>
							<div class="sp-act-ts-tue">
								<div>Duration</div>
								<select name="duration-sp-tue" id="duration-sp-tue" class="cls-duration-sp-tue" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-tue" name="Tue[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed" name="day[]"  value="Wed" class="days"/><span class="dayName"> Wed </span>
							<div class="sp-act-ts-wed">
								<div>Duration</div>
								<select name="duration-sp-wed" id="duration-sp-wed" class="cls-duration-sp-wed" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-wed" name="Wed[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu" name="day[]"  value="Thu" class="days"/><span class="dayName"> Thu </span>
							<div class="sp-act-ts-thu">
								<div>Duration</div>
								<select name="duration-sp-thu" id="duration-sp-thu" class="cls-duration-sp-thu" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-thu" name="Thu[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri" name="day[]"  value="Fri" class="days"/><span class="dayName"> Fri </span>
							<div class="sp-act-ts-fri">
								<div>Duration</div>
								<select name="duration-sp-fri" id="duration-sp-fri" class="cls-duration-sp-fri" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-fri" name="Fri[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>
						</div>
						<div class="tmSlot">
						<input type="checkbox" id="Sat" name="day[]"  value="Sat" class="days"/><span class="dayName"> Sat </span>
							<div class="sp-act-ts-sat">
								<div>Duration</div>
								<select name="duration-sp-sat" id="duration-sp-sat" class="cls-duration-sp-sat" >
								   <?php echo $option_duration;?>
								</select>
								<div>Start Time</div>
								<select id="ts-sp-sat" name="Sat[]" class="slctSpTs">
									  <option value="">--Select--</option>
									  <?php echo $tslot_dropDwn;?>
								</select>
							</div>		
						</div>
                    </div>
					<div class="custtable_left div-arrow-img" style="cursor:pointer">
					<input type="button" name="saveRule" class="buttonsub" value="Create Rule" onclick="createSpecialAvailRule();">
                   <!-- <img src="images/arrow.png" id="arrow-img" class="arrow-img"  onclick="createTeachAvailRule();"/>-->
                	</div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Add Exception</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" size="12" id="exceptnSpecialActAval" />
                    </div>
					<div class="addbtnException">
					    <input type="button" name="btnAddMore" class="btnSpecialActAvailExcep" value="Add">
                     </div>
                    <div class="clear"></div>
					 <div class="custtd_left">
                    </div>
					<div class="divException">
					</div>
					<div class="clear"></div>
					</div>
                </div>
			<div class="clear"></div>
			<div class="scheduleBlockSpAct" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
				<div>
					<span style="font-size:14px"><b>Select A Rule For Recess Activity / Group Meetings:</b></span>
				</div>
				<div >
                    <ul id="rules" name="rules" class="rule">
                       <table width="1200" border="1" >
					   <?php
					    $count = 0;
					   	while($data = $specialAvailData->fetch_assoc()){
							$rule_id=$data['id'];
							if($count%6 == 0){ echo "<tr>"; }  ?>
								<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;"><li style="min-height:20px;" class="main-title"><input type="checkbox" name="ruleval[]" value="<?php echo $data['id']; ?>"  class="rule__listed_ckb" <?php if(in_array($data['id'], $mappedruleids)) { echo "checked"; } ?>  /><b>&nbsp;<?php echo $data['rule_name']; ?></b>
								<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onclick="deleteRuleSpecialActivity(<?php echo $rule_id; ?>);" src="images/delete-rule.png" /></span>
								</li>
								<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span>
								<ul class="listing">
									<?php //get the day and timeslot
									$dayData = $obj->getSpecialAvailDay($data['id']);
									while($ddata = $dayData->fetch_assoc()){
										$tempData  = explode(',', $ddata['actual_timeslot_id']);
										$start_time = $obj->getStartTime($tempData['0']);
										?>
										<li><span style="text-decoration:underline"><?php echo $ddata['day_name'].'</span>:&nbsp;'.$start_time['start_time'].'  ( Duration : '.$ddata['duration'].' Min)' ;
											?>
										</li>
									<?php } ?>
								</ul>
								<?php 
								$exceptionDates = $obj->getExceptionDate($rule_id);
								if(count($exceptionDates)>0){
									echo '<strong>Exception Date:</strong> <br>';
									$i=0;
									foreach($exceptionDates as $value){
										if($i%2==0)
											echo $value.' , ';
										else
										echo $value.'<br>';
										$i++;
									}
								} ?>
								</div>
								</td>
						<?php $count++; } ?>
						</tr>
						</table>
                    </ul>
                </div>
			</div>
			<div class="clear"></div>
                    <div class="clear"></div>
					<div class="special_act_list"> </div>
					<div class="txtfield" style="margin-left:500px;">
                        <input type="submit" name="btnSave" class="buttonsub" value="<?php echo $btnSubmit;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'special_activity_view.php';">
                    </div>
			 </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
