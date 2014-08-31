<?php
include('header.php');
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    $objP = new Programs();
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    //get all the cycles related to data
    $cycleData = $objP->getProgramCycleList($programId);
    while($data = $cycleData->fetch_assoc()){
       $daysArr[]= explode(',',$data['days']);
       $start_week[] = $data['start_week'];
       $end_week[] = $data['end_week'];
    }

    // set the value
    $totcycle = $objP->getCyclesInProgram($programId);
    $button_save = 'Edit Program';
    $form_action = 'edit_program';

}else{
    $button_save = 'Add Program';
    $form_action = 'add_program';
}

$program_name = isset($_GET['edit']) ? $row['program_name'] : (isset($_POST['txtPrgmName'])? $_POST['txtPrgmName']:'');
$program_type = isset($_GET['edit']) ? $row['program_type'] : (isset($_POST['slctPrgmType'])? $_POST['slctPrgmType']:'');
$program_from_date = isset($_GET['edit']) ? $row['start_date'] : (isset($_POST['prog_from_date'])? $_POST['prog_from_date']:'');
$program_to_date = isset($_GET['edit']) ? $row['end_date'] : (isset($_POST['prog_to_date'])? $_POST['prog_to_date']:'');

$no_of_cycles = isset($_GET['edit']) ? $totcycle : (isset($_POST['slctNumcycle'])? $_POST['slctNumcycle']:'');

$daysArr1 = isset($_GET['edit']) ? (isset($daysArr[0])? $daysArr[0]:'') : (!empty($_POST['slctDays1']) ? $_POST['slctDays1'] : array());
$daysArr2 = isset($_GET['edit']) ? (isset($daysArr[1])? $daysArr[1]:'') : (!empty($_POST['slctDays2']) ? $_POST['slctDays2'] : array());
$daysArr3 = isset($_GET['edit']) ? (isset($daysArr[2])? $daysArr[2]:'') : (!empty($_POST['slctDays3']) ? $_POST['slctDays3'] : array());

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

	$("#frmProff").submit(function(){
		$("#frmProgram").validate();
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
            <div class="h_title">Program</div>
			<form name="frmProgram" id="frmProgram" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="<?php echo $form_action;?>" />
			  <?php if(isset($programId)){?>
			  	<input type="hidden" name="programId" value="<?php echo $programId;?>" />
			  <?php } ?>
                <div class="custtable_left">
                    <div class="custtd_left red">
						<?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtPrgmName" maxlength="50" name="txtPrgmName" value="<?php echo $program_name;?>" required="true">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Type <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctPrgmType" name="slctPrgmType" class="select1" required="true">
                            <option value="" selected="selected">--Select Program--</option>
                            <option value="1 year">One Year</option>
                            <option value="2 year">Two Year</option>
							<option value="3 year">Three Year</option>
                        </select>
						<script type="text/javascript">
							jQuery('#slctPrgmType').val("<?php echo $program_type;?>");
						</script>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Duration <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromPrgm" name="prog_from_date" value="<?php echo $program_from_date;?>" required="true"/>
                        To:<input type="text" size="12" id="toPrgm" name="prog_to_date" value="<?php echo $program_to_date;?>" required="true"/>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>No. of Cycle<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctNumCycle" name="slctNumcycle" class="select" required="true">
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
							<h3>Start Week</h3>
							<select id="startweek1" name="startweek1" class="select" required="true">
							<option value="">--Select Week--</option>
							<?php
									for($i=1;$i<=52;$i++){
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
							?>
							</select>
							<script type="text/javascript">
								jQuery('#startweek1').val("<?php echo $startweek_1;?>");
						    </script>
						</div>
						<div class="cylcebox">
							<h3>End Week</h3>
							<select id="endweek1" name="endweek1" class="select" required="true">
							<option value="">--Select Week--</option>
							<?php
									for($i=1;$i<=52;$i++){
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
							?>
							</select>
							<script type="text/javascript">
								jQuery('#endweek1').val("<?php echo $endweek_1;?>");
							</script>
						</div>
						<div class="cylcebox">
							<h3>Days</h3>
							<select id="slctDays1" name="slctDays1[]" class="ts-avail" multiple="multiple" required="true">
								<option value="0" <?php echo in_array(0,$daysArr1) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr1) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr1) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr1) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr1) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr1) ? 'selected' : ''?>>Sat</option>
							</select>
							</div>
						</div>
					</div>
                    <div class="clear"></div>
					<div id="secondCycle" style="display:none;">
						<div class="custtd_left">
							<h2>2nd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
								<h3>Start Week</h3>
								<select id="startweek2" name="startweek2" class="select" required="true">
								<option value="">--Select Week--</option>
								<?php
										for($i=1;$i<=52;$i++){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
								?>
								</select>
								<script type="text/javascript">
									jQuery('#startweek2').val("<?php echo $startweek_2;?>");
								</script>
							</div>
							<div class="cylcebox">
								<h3>End Week</h3>
								<select id="endweek2" name="endweek2" class="select" required="true">
								<option value="">--Select Week--</option>
								<?php
										for($i=1;$i<=52;$i++){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
								?>
								</select>
								<script type="text/javascript">
									jQuery('#endweek2').val("<?php echo $endweek_2;?>");
								</script>
							</div>
							<div class="cylcebox">
								<h3>Days</h3>
								<select id="slctDays2" name="slctDays2[]" class="ts-avail" multiple="multiple" required="true">
								<option value="0" <?php echo in_array(0,$daysArr2) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr2) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr2) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr2) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr2) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr2) ? 'selected' : ''?>>Sat</option>
								</select>
							</div>
						</div>
					</div>
                    <div class="clear"></div>
					<div id="thirdCycle" style="display:none;">
						<div class="custtd_left">
							<h2>3rd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
								<h3>Start Week</h3>
								<select id="startweek3" name="startweek3" class="select" required="true">
								<option value="">--Select Week--</option>
								<?php
										for($i=1;$i<=52;$i++){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
								?>
								</select>
								<script type="text/javascript">
									jQuery('#startweek3').val("<?php echo $startweek_3;?>");
								</script>
							</div>
							<div class="cylcebox">
								<h3>End Week</h3>
								<select id="endweek3" name="endweek3" class="select" required="true">
								<option value="">--Select Week--</option>
								<?php
										for($i=1;$i<=52;$i++){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
								?>
								</select>
								<script type="text/javascript">
									jQuery('#endweek3').val("<?php echo $endweek_3;?>");
								</script>
							</div>
							<div class="cylcebox">
								<h3>Days</h3>
								<select id="slctDays3" name="slctDays3[]" class="ts-avail" multiple="multiple" required="true">
								<option value="0" <?php echo in_array(0,$daysArr3) ? 'selected' : ''?>>Mon</option>
								<option value="1" <?php echo in_array(1,$daysArr3) ? 'selected' : ''?>>Tue</option>
								<option value="2" <?php echo in_array(2,$daysArr3) ? 'selected' : ''?>>Wed</option>
								<option value="3" <?php echo in_array(3,$daysArr3) ? 'selected' : ''?>>Thu</option>
								<option value="4" <?php echo in_array(4,$daysArr3) ? 'selected' : ''?>>Fri</option>
								<option value="5" <?php echo in_array(5,$daysArr3) ? 'selected' : ''?>>Sat</option>
								</select>
							</div>
						</div>
					</div>
                    <div class="clear"></div>

                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="<?php echo $button_save;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='programs_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

