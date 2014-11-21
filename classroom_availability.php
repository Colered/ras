<?php include('header.php');
$obj = new Classroom_Availability();
$classroomAvailData = $obj->getClassroomAvailRule();
$roomTypedata=$obj->getRoomType();
/*$timeslotData=$obj->getTimeslot();
$options = "";
while($data = $timeslotData->fetch_assoc()){
	$options .= '<option value="'.$data['id'].'">'.$data['timeslot_range'].'</option>';
}*/
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
$classRmAvailId="";
$roomId="";
$roomTypeId="";
$mappedruleids = array();
if(isset($_GET['rid']) && $_GET['rid']!=""){
	 $roomId = $_GET['rid'];
	 $resultRoomTypeId=$obj->getRoomTypeById($roomId);
	 $roomTypeIdOrigin=$resultRoomTypeId->fetch_row();
	 $roomTypeId=$roomTypeIdOrigin[0];
	 $mappedruleids = $obj->getRuleIdsForRoom($roomId);
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Classroom Availability</div>
			<form action="postdata.php" method="post" class="form-align" name="classroomAvailabilityForm" id="classroomAvailabilityForm">
				<input type="hidden" name="form_action" value="addEditClassAvailability" />
				<input type="hidden" id="classRmAvailId" name="classRmAvailId" value="<?php echo $classRmAvailId; ?>" />
				<input type="hidden" id="roomId" name="roomId" value="<?php echo $roomId; ?>" />
                <div class="custtable_left">
				<div class="custtd_left green">
					<?php if(isset($_SESSION['succ_msg']))
						echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);?>
				</div>
				<div class="clear"></div>
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Room Type <span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
						<select id="slctRmType" name="slctRmType[]"  class="selectMultiple inp_txt required" >
					 		  <option value="">--Select Room Type--</option>
                              <?php //if($roomTypedata!="0"){
								while($roomTypedataResult = $roomTypedata->fetch_assoc()){ ?>
									<option value="<?php echo $roomTypedataResult['id'].'#'.$roomTypedataResult['room_type']?>"  <?php if($roomTypeId == $roomTypedataResult['id']){echo "selected"; } ?> ><?php echo $roomTypedataResult['room_type'];?></option>
							<?php }//}else{ ?>
								<!--<option value="">No room type available</option>-->
                            <?php //} ?>
                        </select>
					</div>
                    <div class="clear"></div>
				    <div class="custtd_left">
                        <h2>Room Name <span class="redstar">*</span></h2>
                    </div>
					<?php if(isset($roomId) && $roomId!=''){?>
						<script type="text/javascript">
							getRoomByType('<?php echo $roomId;?>');
						</script>
					<?php } ?>
                    <div class="txtfield">
                         <select id="slctRmName" name="slctRmName" class="select1 inp_txt required" onchange="changeRoomData()" >
						  	<option value="">--Select Room--</option>
                         </select>
                    </div>
					<div class="createScheduleBlock">
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
                        From:<input type="text" size="12" id="fromTmDuratn" />
                        To:<input type="text" size="12" id="toTmDuratn" />
                    </div>
                     <div class="clear"></div>
                     <div class="custtd_left">
                        <h2>Days and Timeslot<span class="redstar">*</span></h2>
                    </div>
                     <div class="txtfield" >
					    <div class="tmSlot">
                        <input type="checkbox" id="Mon" name="day[]"  value="0" class="days"/><span class="dayName"> Mon </span>
						<select id="ts-avail-day-0" name="Mon[]" class="slctTs" multiple="multiple" style="height:110px;">
						<?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue" name="day[]"  value="1" class="days"/><span class="dayName"> Tue </span>
						<select id="ts-avail-day-1" name="Tue[]" class="slctTs" multiple="multiple" style="height:110px;">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed" name="day[]"  value="2" class="days"/><span class="dayName"> Wed </span>
						 <select id="ts-avail-day-2" name="Wed[]" class="slctTs" multiple="multiple" style="height:110px;">
                          <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu" name="day[]"  value="3" class="days"/><span class="dayName"> Thu </span>
						 <select id="ts-avail-day-3" name="Thu[]" class="slctTs" multiple="multiple" style="height:110px;">
                         <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri" name="day[]"  value="4" class="days"/><span class="dayName"> Fri </span>
						 <select id="ts-avail-day-4" name="Fri[]" class="slctTs" multiple="multiple" style="height:110px;">
                          <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Sat" name="day[]"  value="5" class="days"/><span class="dayName"> Sat </span>
						 <select id="ts-avail-day-5" name="Sat[]" class="slctTs" multiple="multiple" style="height:110px;">
                          <?php echo $options; ?>
                        </select>
						</div>
                    </div>
					 <div class="custtable_left div-arrow-img" style="cursor:pointer">
					  <input type="button" name="saveRule" class="buttonsub btnCreateRule" value="Create Rule">
                     </div>
					 <div class="clear"></div>
                   </div>
                </div>

			<div class="clear"></div>
			<div class="scheduleBlock">
				<div >
					<span style="font-size:14px"><b>Select A Rule For Classroom Availability:</b></span>
				</div>
				<div >
                    <ul id="rules" name="rules" class="rule">
                       <table width="1200" border="0" >
					   <?php
					    $count = 0;
					   	while($data = $classroomAvailData->fetch_assoc()){
							if($count%6 == 0){ echo "<tr>"; }?>
								<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;"><li class="main-title"><input type="checkbox" name="ckbruleVal[]" value="<?php echo $data['id']; ?>" <?php if(in_array($data['id'], $mappedruleids)) { echo "checked"; } ?>  /><b>&nbsp;<?php echo $data['rule_name']; ?></b>
								<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onclick="deleteRuleClassroom(<?php echo $data['id']; ?>);" src="images/delete-rule.png" /></span>
								</li>
								<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span>
								<ul class="listing">
									<?php //get the day and timeslot
									$dayData = $obj->getClassroomAvailDay($data['id']);

									while($ddata = $dayData->fetch_assoc()){
										$timeslotData = $obj->getClassroomAvailTimeslot($ddata['timeslot_id']);
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
										<li><span style="text-decoration:underline"><?php
											if($ddata['day']==0){echo $day_name="Mon ";}
											if($ddata['day']==1){echo $day_name="Tue ";}
											if($ddata['day']==2){echo $day_name="Wed ";}
											if($ddata['day']==3){echo $day_name="Thu ";}
											if($ddata['day']==4){echo $day_name="Fri ";}
											if($ddata['day']==5){echo $day_name="Sat ";}
											echo '</span>:&nbsp;';
											echo $finalTSval;
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
                        <input type="text" size="12" id="exceptnClsrmAval" />
                    </div>
					<div class="addbtnException">
					    <input type="button" name="btnAddMore" class="btnclsrmException" value="Add">
                     </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                    </div>
					<div class="divException">
						<?php
					if($roomId!=""){
						$x=0;
						$sessionHtml='';
						$subj_session_query="select * from  classroom_availability_exception where room_id='".$roomId."'";
						$subj_session_result= mysqli_query($db, $subj_session_query);
						while($subj_session_data = mysqli_fetch_assoc($subj_session_result)){
						$x++;
						if($x==1){
							$sessionHtml.='<div class="sessionList">
   							<table id="datatables" class="exceptionTbl">
       						  <thead>
          					   <tr>
								<th>Sr. No.</th>
          						<th >Exception Date</th>
          						<th >Remove</th>
							   </tr>
       					      </thead>
       					      <tbody>';}
						 	$sessionHtml.='<tr>
           						<td>'.$x.'</td>
	   							<td>'.$subj_session_data['exception_date'].'</td>
	   							';
							$sessionHtml.='<td style="display:none">
							<input type="hidden" name="exceptionDate[]" id="sessionName'.$x.'"  value="'.$subj_session_data['exception_date'].'"/>
							<input type="hidden" name="sessionRowId[]" id="sessionRowId'.$x.'"  value="'.$subj_session_data['id'].'"/></td>
							<td id='.$subj_session_data['id'].'><a class="remove_field" onclick="removeClassException('.$subj_session_data['id'].', 0);">Remove</a></td></tr>';
       					}
					$sessionHtml.='<input type="hidden" name="maxSessionListVal" id="maxSessionListVal"  value="'.$x.'"/>';
					$sessionHtml.='</tbody></table></div>';
					echo $sessionHtml;
				 }?>

					</div>
					<div class="clear"></div>
					<div class="txtfield" style="margin-left:500px;">
                        <input type="submit" name="btnSave" class="buttonsub" value="Save">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'classroom_availability_view.php';">
                    </div>
			 </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

