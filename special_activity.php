<?php include('header.php');
$obj = new SpecialActivity();
$objTeach = new Teacher();
$teacherData = $objTeach->getTeachers();
$specialAvailData = $obj->getSpecialAvailRule();
$obj2 = new Timeslot();
$tslot_dropDwn = $obj2->getTimeSlotStartDateDropDwn();
$disFDivCss = "style=''";
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
$name="";
$teachId = ""; $decodeTeachId="";
$mappedruleids = array();
if(isset($_GET['tid']) && $_GET['tid']!=""){
	$teachId = $_GET['tid'];
	$decodeTeachId = base64_decode($teachId);
	$mappedruleids = $obj->getRuleIdsForSpecialAct($decodeTeachId);
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Recess Activity / Group Meetings</div>
			<form name="specialActivityForm" id="specialActivityForm" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditSpecialActivity" />
				<input type="hidden" id="decodeTeachId" name="decodeTeachId" value="<?php echo $decodeTeachId; ?>" />
                <div class="custtable_left">
				<div class="custtd_left red">
					<?php if(isset($_SESSION['error_msg']))
						echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
				</div>
				<div class="clear"></div>
                <div class="custtable_left">
				
				<!-- new -->
				<div class="addSubDiv" <?php //echo $disFDivCss; ?>>
                            <div class="custtd_left">
                                <h2>Choose Activity<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="special_activity" name="special_activity" class="select1" onchange="specialActivity();"> 
									<option value="" selected="selected">--Select--</option>
									<option value="3" <?php if($activity_filter_val == '3'){?> selected="selected"}<?php }?>>Recess Activities</option>
									<option value="4" <?php if($activity_filter_val == '4'){?> selected="selected"}<?php }?>>Group Meetings</option>
									<option value="5" <?php if($activity_filter_val == '5'){?> selected="selected"}<?php }?>>Adhoc Activities</option>
								</select>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left actType">
                                <h2>Choose Activity Type<span class="redstar spanActivityType">*</span></h2>
                            </div>
                            <div class="txtfield actType">
                                <select id="special_activity_type" name="special_activity_type" class="select1" onchange="specialActivityType();"> 
									<option value="" selected="selected">--Select--</option>
									<option value="1">One Time Activity</option>
									<option value="2">Periodic Activity</option>
								</select>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left otAct" >
                       		</div>
                    		<div class="txtfield otAct">
                       			 Date:<input type="text" size="12" id="oneTimeDate"  name="oneTimeDate" class="txtfield" />
                       			 Start Time:<select id="ot_tslot_id"  name="ot_tslot_id[]"  multiple="multiple">
                                        		<option value="">--Select--</option>
												<?php echo $options;?>
											</select>
                    		</div>
                    		<div class="clear"></div>
							<div class="custtd_left">
                                <h2>Choose Program<span class="redstar spanPrgm">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctProgram" name="slctProgram" class="select1 required" onchange="getCycleByProgId(this)">
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
                                <h2>Choose Cycle<span class="redstar spanCycle">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctCycle" name="slctCycle" class="select1 required" >
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
                            <div class="custtd_left" <?php echo $disFDivCss; ?>>
                                <h2>Choose Area <span class="redstar spanArea">*</span></h2>
                            </div>
                            <div class="txtfield " <?php echo $disFDivCss; ?>>
                                <select id="slctArea" name="slctArea" class="select1 required">
                                    <option value="" selected="selected">--Select Area--</option>
						<?php
						$areaId = "";
						$area_qry = "select * from area";
						$area_result = mysqli_query($db, $area_qry);
						while ($area_data = mysqli_fetch_assoc($area_result)) {
							$selected = (trim($areaId) == trim($area_data['id'])) ? ' selected="selected"' : '';
							?>
                                        <option value="<?php echo $area_data['id'] ?>" ><?php echo $area_data['area_name']; ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
							 <div class="custtd_left" <?php echo $disFDivCss; ?>>
                                <h2>Choose Room <span class="redstar spanRoom">*</span></h2>
                            </div>
							<div class="txtfield " <?php echo $disFDivCss; ?>>
                                <select id="slctRoom" name="slctRoom" class="select1 required">
                                    <option value="" selected="selected">--Select Room--</option>
								<?php
								$roomId = "";
								$room_qry = "select * from room";
								$room_result = mysqli_query($db, $room_qry);
								while ($room_data = mysqli_fetch_assoc($room_result)) {
									$selected = (trim($roomId) == trim($room_data['id'])) ? ' selected="selected"' : '';
									?>
                                        <option value="<?php echo $room_data['id'] ?>" ><?php echo $room_data['room_name']; ?></option>
							<?php } ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" <?php echo $disFDivCss; ?>>
                                <h2>Subject Name<span class="redstar spanSubject">*</span></h2>
                            </div>
                            <div class="txtfield" <?php echo $disFDivCss; ?>>
                                <input type="text" class="inp_txt required" id="txtSubjName" maxlength="50" name="txtSubjName" value="" >
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" <?php echo $disFDivCss; ?>>
                                <h2>Subject Code <span class="redstar spanSubCode">*</span></h2>
                            </div>
                            <div class="txtfield" <?php echo $disFDivCss; ?>>
                                <input type="text" class="inp_txt required" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="" >
                            </div>
                            <!--<div class="sessionboxSub btnSessiondiv">
                                <div style="float:left; width:175px;"><input type="submit" name="saveSubject" class="buttonsub"  value="Save Subject">
								<input type="button" name="btnCancel" class="buttonsub"  value="Cancel" onclick="location.href = 'subject_view.php';"></div>
                            </div>-->
                            <div class="clear"></div>
                        </div>
				
				<!-- end -->
				
                    <div class="custtd_left" <?php echo $disFDivCss; ?>>
                        <h2>Teacher <span class="redstar spanSubCode">*</span></h2>
                    </div>
                    <div class="txtfield" <?php echo $disFDivCss; ?>>
					 <select id="slctTeacher" name="slctTeacher" class="select1 required" >
						<option value="" >--Select--</option>
						<?php while($data = $teacherData->fetch_assoc()){ ?>
									<option value="<?php echo $data['id']; ?>" ><?php echo $data['teacher_name']; ?><?php if($data['email'] !=""){echo ' ('.$data['email'].')'; } ?></option>
						<?php } ?>
					</select>
                    </div>
                    <div class="clear"></div>
					<div class="scheduleBlock" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
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
						<select id="ts-avail-mon" name="Mon[]" class="slctTs" multiple="multiple" style="height:110px;">
							<?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue" name="day[]"  value="Tue" class="days"/><span class="dayName"> Tue </span>
						<select id="ts-avail-tue" name="Tue[]" class="slctTs" multiple="multiple" style="height:110px;">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed" name="day[]"  value="Wed" class="days"/><span class="dayName"> Wed </span>
						 <select id="ts-avail-wed" name="Wed[]" class="slctTs" multiple="multiple" style="height:110px;">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu" name="day[]"  value="Thu" class="days"/><span class="dayName"> Thu </span>
						 <select id="ts-avail-thu" name="Thu[]" class="slctTs" multiple="multiple" style="height:110px;">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri" name="day[]"  value="Fri" class="days"/><span class="dayName"> Fri </span>
						 <select id="ts-avail-fri" name="Fri[]" class="slctTs" multiple="multiple" style="height:110px;">
                            <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Sat" name="day[]"  value="Sat" class="days"/><span class="dayName"> Sat </span>
						 <select id="ts-avail-sat" name="Sat[]" class="slctTs" multiple="multiple" style="height:110px;">
                          <?php echo $options; ?>
                        </select>
						</div>
                    </div>
					<div class="custtable_left div-arrow-img" style="cursor:pointer">
					<input type="button" name="saveRule" class="buttonsub" value="Create Rule" onclick="createSpecialAvailRule();">
                   <!-- <img src="images/arrow.png" id="arrow-img" class="arrow-img"  onclick="createTeachAvailRule();"/>-->
                	</div>
                    <div class="clear"></div>
					</div>
                </div>

			<div class="clear"></div>
			<div class="scheduleBlock" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
				<div>
					<span style="font-size:14px"><b>Select A Rule For Recess Activity / Group Meetings:</b></span>
				</div>
				<div >
                    <ul id="rules" name="rules" class="rule">
                       <table width="1200" border="1" >
					   <?php
					    $count = 0;
					   	while($data = $specialAvailData->fetch_assoc()){
							if($count%6 == 0){ echo "<tr>"; }?>
								<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;"><li style="min-height:20px;" class="main-title"><input type="checkbox" name="ruleval[]" value="<?php echo $data['id']; ?>"  class="rule__listed_ckb" <?php if(in_array($data['id'], $mappedruleids)) { echo "checked"; } ?>  /><b>&nbsp;<?php echo $data['rule_name']; ?></b>
								<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onclick="deleteRuleTeacher(<?php echo $data['id']; ?>, '<?php echo $teachID = ($teachId !="" ? $teachId : 0); ?>');" src="images/delete-rule.png" /></span>
								</li>
								<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span>
								<ul class="listing">
									<?php //get the day and timeslot
									$dayData = $obj->getSpecialAvailDay($data['id']);
									while($ddata = $dayData->fetch_assoc()){
										//$timeslotData2 = $obj->getTeacherAvailTimeslot($ddata['timeslot_id']);
										
										$tempData  = explode(',', $ddata['timeslot_id']);
										unset($startArr, $endArr);
										foreach($tempData as $data){
											$tempts = explode('-', $data);
											$startArr[] =$tempts[0];
											$endArr[]=$tempts[1];
										}
										$startnewArr = array_diff($startArr,$endArr);
										$endnewArr = array_diff($endArr,$startArr);
										unset($startTmpArr, $endTmpArr);
										foreach($startnewArr as $val){
										   $startTmpArr[] = $val;
										}
										foreach($endnewArr as $val2){
										   $endTmpArr[] = $val2;
										}
										unset($allTSVal);
										for($i=0;$i<count($startTmpArr);$i++){
										   $allTSVal[] = $startTmpArr[$i].'-'.$endTmpArr[$i];
										}
										$finalTSval = implode(', ', $allTSVal);
										
										?>
										<li><span style="text-decoration:underline"><?php echo $ddata['day_name'].'</span>:&nbsp;'.$finalTSval;
											?>
										</li>
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
					<?php
					if($decodeTeachId!=""){
						$x=0;
						$sessionHtml='';
						$subj_session_query="select * from  teacher_availability_exception where teacher_id='".$decodeTeachId."'";
						$subj_session_result= mysqli_query($db, $subj_session_query);
						while($subj_session_data = mysqli_fetch_assoc($subj_session_result)){
						$x++;
						if($x==1){
						?>
							<div class="exceptionList">
   							<table id="datatables" class="exceptionTbl">
       						  <thead>
          					   <tr>
								<th>Sr. No.</th>
								<th >Exception Date</th>
								<th >Remove</th>
							   </tr>
       					      </thead>
       					      <tbody>
						<?php } ?>
						 	<tr>
           						<td><?php echo $x; ?></td>
	   							<td><?php echo $subj_session_data['exception_date']; ?></td>
								<td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate<?php echo $x; ?>" value="<?php echo $subj_session_data['exception_date']; ?>" />
								<input type="hidden" name="sessionRowId[]" id="sessionRowId<?php echo $x; ?>"  value="<?php echo $subj_session_data['id']; ?>"/></td>
								<td id="<?php echo $subj_session_data['id']; ?>"><a class="remove_field" onclick="deleteExcepTeachAvail(<?php echo $subj_session_data['id']; ?>, 0);">Remove</a></td></tr>
					<?php } ?>
					<input type="hidden" name="maxSessionListVal" id="maxSessionListVal"  value="<?php echo $x; ?>"/>
					</tbody></table></div>
					<?php
					}?>
					</div>
					<div class="clear"></div>
                    <div class="clear"></div>
					<div class="txtfield" style="margin-left:500px;">
                        <input type="submit" name="btnSave" class="buttonsub" value="Save">
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
