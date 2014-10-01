<?php
include('header.php');
$objP = new Programs();
$objTS = new Timeslot();
$programId = '';
//get the list of all available timeslots
$timeslotData = $objTS->viewTimeslot();
$options = "";
while($data = $timeslotData->fetch_assoc()){
	$options .= '<option value="'.$data['id'].'">'.$data['timeslot_range'].'</option>';
}

$rel_prog = $objP->getProgramListYearWise();
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    $unitArr[]= explode(',',$row['unit']);
    //get all the cycles related to data
    $cycleData = $objP->getProgramCycleList($programId);
    while($data = $cycleData->fetch_assoc()){
       $cycleIdsArr[]= $data['id'];
       $daysArr[]= explode(',',$data['days']);
       $start_week[] = $data['start_week'];
       $end_week[] = $data['end_week'];
       $timeslotArr[] = explode(',',$data['timeslot_id']);
    }
    // set the value
    $totcycle = $objP->getCyclesInProgram($programId);
}

$no_of_cycles = isset($_GET['edit']) ? $totcycle : (isset($_POST['slctNumcycle'])? $_POST['slctNumcycle']:'');
$cycleIdsArr = (!empty($cycleIdsArr) ? $cycleIdsArr : array());

$daysArr1 = isset($_GET['edit']) ? (isset($daysArr[0])? $daysArr[0]: array()) : (!empty($_POST['slctDays1']) ? $_POST['slctDays1'] : array());
$daysArr2 = isset($_GET['edit']) ? (isset($daysArr[1])? $daysArr[1]: array()) : (!empty($_POST['slctDays2']) ? $_POST['slctDays2'] : array());
$daysArr3 = isset($_GET['edit']) ? (isset($daysArr[2])? $daysArr[2]: array()) : (!empty($_POST['slctDays3']) ? $_POST['slctDays3'] : array());

$timeslotArr1 = isset($_GET['edit']) ? (isset($timeslotArr[0])? $timeslotArr[0]: array()) : (!empty($_POST['slctTimeslot1']) ? $_POST['slctTimeslot1'] : array());
$timeslotArr2 = isset($_GET['edit']) ? (isset($timeslotArr[1])? $timeslotArr[1]: array()) : (!empty($_POST['slctTimeslot2']) ? $_POST['slctTimeslot2'] : array());
$timeslotArr3 = isset($_GET['edit']) ? (isset($timeslotArr[2])? $timeslotArr[2]: array()) : (!empty($_POST['slctTimeslot3']) ? $_POST['slctTimeslot3'] : array());

$startweek_1 = isset($_GET['edit']) ? (isset($start_week[0])? $start_week[0]:'') : (isset($_POST['startweek1'])? $_POST['startweek1']:'');
$startweek_2 = isset($_GET['edit']) ? (isset($start_week[1])? $start_week[1]:'') : (isset($_POST['startweek2'])? $_POST['startweek2']:'');
$startweek_3 = isset($_GET['edit']) ? (isset($start_week[2])? $start_week[2]:'') : (isset($_POST['startweek3'])? $_POST['startweek3']:'');
$endweek_1 = isset($_GET['edit']) ? (isset($end_week[0])? $end_week[0]:'') : (isset($_POST['endweek1'])? $_POST['endweek1']:'');
$endweek_2 = isset($_GET['edit']) ? (isset($end_week[1])? $end_week[1]:'') : (isset($_POST['endweek2'])? $_POST['endweek2']:'');
$endweek_3 = isset($_GET['edit']) ? (isset($end_week[2])? $end_week[2]:'') : (isset($_POST['endweek3'])? $_POST['endweek3']:'');

?>
<script type="text/javascript">
$(document).ready(function() {
    show_hide_cycle('<?php echo $no_of_cycles;?>');
	$(function () {
		$("#frmProgram").validate().settings.ignore = ':hidden';
	});

	$('#slctNumCycle').on('change', function() {
		$('#firstCycle').hide();
		$('#secondCycle').hide();
		$('#thirdCycle').hide();
		show_hide_cycle(this.value);

	});

});
</script>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Program Cycles</div>
			<form name="frmProgram" id="frmProgram" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="add_edit_cycles" />
			  <?php if(isset($_GET['edit'])){?>
			  	<input type="hidden" name="programId" value="<?php echo $_GET['edit'];?>" />
			  	<input type="hidden" name="preNumCycle" value="<?php echo $no_of_cycles;?>" />
			  	<?php
			  	   $ct = 0;
			  	   foreach($cycleIdsArr as $val){
			  	      $ct++;
			  	      echo '<input type="hidden" name="preCycleId'.$ct.'" value="'.$val.'" />';
			  	   }
			    } ?>
                <div class="custtable_left">
                    <div class="custtd_left red">
						<?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required" onchange="changeExceptionData(this.value);">
						<option value="" selected="selected">--Select Program--</option>
						<?php
							while($row = $rel_prog->fetch_assoc()){
								echo '<option value="'.$row['id'].'">'.$row['name'].' '.$row['start_year'].' '.$row['end_year'].'</option>';
							}
						?>
						</select>
						<script type="text/javascript">
							jQuery('#slctProgram').val("<?php echo $programId;?>");
						</script>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>No. of Cycles<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctNumCycle" name="slctNumcycle" class="select required">
                            <option value="">--Select Cycles--</option>
                            <option value="1">1 </option>
                            <option value="2">2 </option>
                            <option value="3">3 </option>
                        </select>
						<script type="text/javascript">
							jQuery('#slctNumCycle').val("<?php echo $no_of_cycles;?>");
						</script>
                    </div>
                    <div class="clear"></div>
                    <div id="firstCycle" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
						<div class="custtd_left">
							<h2>1st cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek1" name="startweek1" value="<?php echo $objP->formatDateByDate($startweek_1);?>" class="required" readonly />
						</div>
						<div class="cylcebox">
							<h3>End Date</h3>
							<input type="text" size="14" id="endweek1" name="endweek1" value="<?php echo $objP->formatDateByDate($endweek_1);?>" class="required" readonly />
						</div>
						
						</div>
						<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Occurring<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="c1chWeek1" name="c1chWeek1" class="select required">
                            <option value="">--Select Week--</option>
                            <option value="1w">Weekly</option>
                            <option value="2w">Bi Weekly</option>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
                    </div>
		            <div class="txtfield">
					  <div id="c1week1">
					    <div class="tmSlot">
                        <input type="checkbox" id="Mon1" name="day1[]"  value="Mon1" class="days"/><span class="dayName"> Mon </span>
						<select id="ts-avail-mon1" name="Mon1[]" class="slctTs" multiple="multiple">
							<?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue1" name="day1[]"  value="Tue1" class="days"/><span class="dayName"> Tue </span>
						<select id="ts-avail-tue1" name="Tue1[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed1" name="day1[]"  value="Wed1" class="days"/><span class="dayName"> Wed </span>
						 <select id="ts-avail-wed1" name="Wed1[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu1" name="day1[]"  value="Thu1" class="days"/><span class="dayName"> Thu </span>
						 <select id="ts-avail-thu1" name="Thu1[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri1" name="day1[]"  value="Fri1" class="days"/><span class="dayName"> Fri </span>
						 <select id="ts-avail-fri1" name="Fri1[]" class="slctTs" multiple="multiple">
                            <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Sat1" name="day1[]"  value="Sat1" class="days"/><span class="dayName"> Sat </span>
						 <select id="ts-avail-sat1" name="Sat1[]" class="slctTs" multiple="multiple">
                          <?php echo $options; ?>
                        </select>
						</div>
					  </div>	
                    </div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
                    </div>
		            <div class="txtfield">
					  <div id="c1week2">
					    <div class="tmSlot">
                        <input type="checkbox" id="Mon2" name="day2[]"  value="Mon2" class="days"/><span class="dayName"> Mon </span>
						<select id="ts-avail-mon2" name="Mon2[]" class="slctTs" multiple="multiple">
							<?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Tue2" name="day2[]"  value="Tue2" class="days"/><span class="dayName"> Tue </span>
						<select id="ts-avail-tue2" name="Tue2[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Wed2" name="day2[]"  value="Wed2" class="days"/><span class="dayName"> Wed </span>
						 <select id="ts-avail-wed2" name="Wed2[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Thu2" name="day2[]"  value="Thu2" class="days"/><span class="dayName"> Thu </span>
						 <select id="ts-avail-thu2" name="Thu2[]" class="slctTs" multiple="multiple">
                           <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Fri2" name="day2[]"  value="Fri2" class="days"/><span class="dayName"> Fri </span>
						 <select id="ts-avail-fri2" name="Fri2[]" class="slctTs" multiple="multiple">
                            <?php echo $options; ?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="Sat2" name="day2[]"  value="Sat2" class="days"/><span class="dayName"> Sat </span>
						 <select id="ts-avail-sat2" name="Sat2[]" class="slctTs" multiple="multiple">
                          <?php echo $options; ?>
                        </select>
						</div>
					  </div>	
	                </div>
						<div class="clear"></div>
	
						<div class="custtd_left">
							<h2>Add Exception</h2>
						</div>
						<div class="txtfield">
							<input type="text" size="14" id="exceptnProgAval1" name="exceptnProgAval1" readonly />
						</div>
					<div class="addbtnException">
						<input type="button" name="btnAddMore" class="btnProgCycleAvailExcep1" value="Add">
					 </div>
					<div class="clear"></div>
					<div class="custtd_left">
					</div>
					<div class="divException1">
					<?php
					if($programId!=""){
                        $objP->getProgExceptions($programId,1);
					 } ?>
					</div>
					<div class="clear"></div>

					</div>
                    <div class="clear"></div>
					<div id="secondCycle" style="display:none;">
						<div class="custtd_left">
							<h2>2nd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
								<h3>Start Date</h3>
								<input type="text" size="14" id="startweek2" name="startweek2" value="<?php echo $objP->formatDateByDate($startweek_2);?>" class="required" readonly />
							</div>
							<div class="cylcebox">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek2" name="endweek2" value="<?php echo $objP->formatDateByDate($endweek_2);?>" class="required"  readonly />
							</div>
							<div class="cylcebox" style="width:100px;">
								<h3>Days</h3>
								<select id="slctDays2" name="slctDays2[]" class="ts-avail required" multiple="multiple">
								<option value="0" <?php echo in_array(0,$daysArr2) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr2) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr2) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr2) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr2) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr2) ? 'selected' : ''?>>Sat</option>
								</select>
							</div>
							<div class="cylcebox">
							<h3>Timeslot</h3>
							<select id="slctTimeslot2" name="slctTimeslot2[]" class="ts-avail required" multiple="multiple" style="width:90px;">
								<?php
									$slqTS="SELECT id, timeslot_range FROM timeslot";
									$relTS = mysqli_query($db, $slqTS);
									while($tsdata= mysqli_fetch_array($relTS)){
										echo '<option value="'.$tsdata['id'].'" '.(in_array($tsdata['id'],$timeslotArr2) ? 'selected' : '').'>'.$tsdata['timeslot_range'].'</option>';
									}
								?>
							</select>
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Add Exception</h2>
						</div>
						<div class="txtfield">
							<input type="text" size="14" id="exceptnProgAval2" name="exceptnProgAval2" readonly />
						</div>
						<div class="addbtnException">
							<input type="button" name="btnAddMore" class="btnProgCycleAvailExcep2" value="Add">
						 </div>
						 <div class="clear"></div>
							<div class="custtd_left">
							</div>
							<div class="divException2">
							<?php
							if($programId!=""){
								 $objP->getProgExceptions($programId,2);
							 } ?>
							</div>
							<div class="clear"></div>
					</div>
                    <div class="clear"></div>
					<div id="thirdCycle" style="display:none;">
						<div class="custtd_left">
							<h2>3rd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
								<h3>Start Date</h3>
								<input type="text" size="14" id="startweek3" name="startweek3" value="<?php echo $objP->formatDateByDate($startweek_3);?>" class="required" readonly />
							</div>
							<div class="cylcebox">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek3" name="endweek3" value="<?php echo $objP->formatDateByDate($endweek_3);?>" class="required" readonly />
							</div>
							<div class="cylcebox" style="width:100px;">
								<h3>Days</h3>
								<select id="slctDays3" name="slctDays3[]" class="ts-avail required" multiple="multiple">
								<option value="0" <?php echo in_array(0,$daysArr3) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr3) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr3) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr3) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr3) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr3) ? 'selected' : ''?>>Sat</option>
								</select>
							</div>
							<div class="cylcebox">
							<h3>Timeslot</h3>
							<select id="slctTimeslot3" name="slctTimeslot3[]" class="ts-avail required" multiple="multiple" style="width:90px;">
								<?php
									$slqTS="SELECT id, timeslot_range FROM timeslot";
									$relTS = mysqli_query($db, $slqTS);
									while($tsdata= mysqli_fetch_array($relTS)){
										echo '<option value="'.$tsdata['id'].'" '.(in_array($tsdata['id'],$timeslotArr3) ? 'selected' : '').'>'.$tsdata['timeslot_range'].'</option>';
									}
								?>
							</select>
							</div>
						</div>
							<div class="clear"></div>
							<div class="custtd_left">
								<h2>Add Exception</h2>
							</div>
							<div class="txtfield">
								<input type="text" size="14" id="exceptnProgAval3" name="exceptnProgAval3" readonly />
							</div>
							<div class="addbtnException">
								<input type="button" name="btnAddMore" class="btnProgCycleAvailExcep3" value="Add">
							 </div>
                          <div class="clear"></div>
							<div class="custtd_left">
							</div>
							<div class="divException3">
							<?php
							if($programId!=""){
								  $objP->getProgExceptions($programId,3);
							 } ?>
							</div>
							<div class="clear"></div>
					</div>
                    <div class="clear"></div>

                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="Save">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='program_cycles_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

