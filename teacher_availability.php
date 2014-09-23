<?php include('header.php');
$obj = new Teacher();
$teacherData = $obj->getTeachers();
$teacherAvailData = $obj->getTeacherAvailRule();
$obj2 = new Timeslot();
//get the list of all available timeslots
$timeslotData = $obj2->viewTimeslot();
$options = "";
while($data = $timeslotData->fetch_assoc()){
	$options .= '<option value="'.$data['id'].'">'.$data['timeslot_range'].'</option>';
}
$teachId = ""; $decodeTeachId="";
$mappedruleids = array();
if(isset($_GET['tid']) && $_GET['tid']!=""){
	$teachId = $_GET['tid'];
	$decodeTeachId = base64_decode($teachId);
	$mappedruleids = $obj->getRuleIdsForTeacher($decodeTeachId);
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher Availability</div>
			<form name="teacherAvailabilityForm" id="teacherAvailabilityForm" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditTeacherAvailability" />
				<input type="hidden" id="decodeTeachId" name="decodeTeachId" value="<?php echo $decodeTeachId; ?>" />
                <div class="custtable_left">
				<div class="custtd_left red">
					<?php if(isset($_SESSION['error_msg']))
						echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
				</div>
				<div class="clear"></div>
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Teacher <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					 <select id="slctTeacher" name="slctTeacher" class="required" onchange="changeTeacherData()">
						<option value="" >Please select</option>
						<?php while($data = $teacherData->fetch_assoc()){ ?>
									<option value="<?php echo base64_encode($data['id']); ?>" <?php if($teachId == base64_encode($data['id'])){echo "selected"; } ?>><?php echo $data['teacher_name']; ?><?php if($data['email'] !=""){echo ' ('.$data['email'].')'; } ?></option>
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
                        <input type="text" class="inp_txt alphanumeric" id="txtSchd" maxlength="50" name="txtSchd">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromTeachAval" />
                        To:<input type="text" size="12" id="toTeachAval" />
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Days and Timeslot<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield" >
					    <div class="tmSlot">
                        <input type="checkbox" id="Mon" name="day[]"  value="Mon" class="days"/><span class="dayName"> Mon </span>
						<select id="ts-avail-mon" name="Mon[]" class="slctTs" multiple="multiple">
							<?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue" name="day[]"  value="Tue" class="days"/><span class="dayName"> Tue </span>
						<select id="ts-avail-tue" name="Tue[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed" name="day[]"  value="Wed" class="days"/><span class="dayName"> Wed </span>
						 <select id="ts-avail-wed" name="Wed[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu" name="day[]"  value="Thu" class="days"/><span class="dayName"> Thu </span>
						 <select id="ts-avail-thu" name="Thu[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri" name="day[]"  value="Fri" class="days"/><span class="dayName"> Fri </span>
						 <select id="ts-avail-fri" name="Fri[]" class="slctTs" multiple="multiple">
                            <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Sat" name="day[]"  value="Sat" class="days"/><span class="dayName"> Sat </span>
						 <select id="ts-avail-sat" name="Sat[]" class="slctTs" multiple="multiple">
                          <?php echo $options; ?>
                        </select>
						</div>
                    </div>
					<div class="custtable_left div-arrow-img" style="cursor:pointer">
					<input type="button" name="saveRule" class="buttonsub" value="Create Rule" onclick="createTeachAvailRule();">
                   <!-- <img src="images/arrow.png" id="arrow-img" class="arrow-img"  onclick="createTeachAvailRule();"/>-->
                	</div>
                    <div class="clear"></div>
					</div>
                </div>

			<div class="clear"></div>
			<div class="scheduleBlock" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
				<div>
					<span style="font-size:14px"><b>Select A Rule For Teacher Availability:</b></span>
				</div>
				<div >
                    <ul id="rules" name="rules" class="rule">
                       <table width="1200" border="1" >
					   <?php
					    $count = 0;
					   	while($data = $teacherAvailData->fetch_assoc()){
							if($count%6 == 0){ echo "<tr>"; }?>
								<td class="sched-data"><li class="main-title"><input type="checkbox" name="ruleval[]" value="<?php echo $data['id']; ?>" <?php if(in_array($data['id'], $mappedruleids)) { echo "checked"; } ?>  /><b>&nbsp;<?php echo $data['rule_name']; ?></b></li>
								<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span>
								<ul class="listing">
									<?php //get the day and timeslot
									$dayData = $obj->getTeacherAvailDay($data['id']);
									while($ddata = $dayData->fetch_assoc()){
										$timeslotData2 = $obj->getTeacherAvailTimeslot($ddata['timeslot_id']);?>
										<li><?php echo $ddata['day_name']." ";
											while($tsdata = $timeslotData2->fetch_assoc()){
											 echo $tsdata['timeslot_range'].",";
											 } ?>
										</li>
									<?php } ?>
								</ul>
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
                        <input type="text" size="12" id="exceptnTeachAval" />
                    </div>
					<div class="addbtnException">
					    <input type="button" name="btnAddMore" class="btnTeachAvailExcep" value="Add">
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
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'teacher_availability_view.php';">
                    </div>
			 </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

