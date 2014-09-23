<?php
include('header.php');
$objP = new Programs();
$objTS = new Timeslot();

$rel_prog = $objP->getProgramListYearWise();

if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    $unitArr[]= explode(',',$row['unit']);
    //get all the cycles related to data
    $cycleData = $objP->getProgramCycleList($programId);
    while($data = $cycleData->fetch_assoc()){
       $daysArr[]= explode(',',$data['days']);
       $start_week[] = $data['start_week'];
       $end_week[] = $data['end_week'];
    }

    // set the value
    $totcycle = $objP->getCyclesInProgram($programId);

}

//timeslot dropdown
$tslot_dropDwn = $objTS->getTimeSlotDropDwn();

$no_of_cycles = isset($_GET['edit']) ? $totcycle : (isset($_POST['slctNumcycle'])? $_POST['slctNumcycle']:'');

$daysArr1 = isset($_GET['edit']) ? (isset($daysArr[0])? $daysArr[0]: array()) : (!empty($_POST['slctDays1']) ? $_POST['slctDays1'] : array());
$daysArr2 = isset($_GET['edit']) ? (isset($daysArr[1])? $daysArr[1]: array()) : (!empty($_POST['slctDays2']) ? $_POST['slctDays2'] : array());
$daysArr3 = isset($_GET['edit']) ? (isset($daysArr[2])? $daysArr[2]: array()) : (!empty($_POST['slctDays3']) ? $_POST['slctDays3'] : array());

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
			  <?php } ?>
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
                    <div id="firstCycle" style="display:none;">
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
						<div class="cylcebox" style="width:100px;">
							<h3>Days</h3>
							<select id="slctDays1" name="slctDays1[]" class="ts-avail required" multiple="multiple">
								<option value="0" <?php echo in_array(0,$daysArr1) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr1) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr1) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr1) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr1) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr1) ? 'selected' : ''?>>Sat</option>
							</select>
							</div>
							<div class="cylcebox">
							<h3>Timeslot</h3>
							<select id="slctTimeslot1" name="slctTimeslot1[]" class="ts-avail required" multiple="multiple" style="width:90px;">
							  <?php echo $tslot_dropDwn;?>
							</select>
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Add Exception</h2>
						</div>
						<div class="txtfield">
							<input type="text" size="12" id="exceptnProgAval" />
						</div>
						<div class="addbtnException">
							<input type="button" name="btnAddMore" class="btnProgAvailExcep" value="Add">
						 </div>
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
							  <?php echo $tslot_dropDwn;?>
							</select>
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Add Exception</h2>
						</div>
						<div class="txtfield">
							<input type="text" size="12" id="exceptnProgAval" />
						</div>
						<div class="addbtnException">
							<input type="button" name="btnAddMore" class="btnProgAvailExcep" value="Add">
						 </div>

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
							  <?php echo $tslot_dropDwn;?>
							</select>
							</div>
						</div>
							<div class="clear"></div>
							<div class="custtd_left">
								<h2>Add Exception</h2>
							</div>
							<div class="txtfield">
								<input type="text" size="12" id="exceptnProgAval" />
							</div>
							<div class="addbtnException">
								<input type="button" name="btnAddMore" class="btnProgAvailExcep" value="Add">
							 </div>

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

