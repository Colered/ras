<?php
include('header.php');
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    $objP = new Programs();
    $result = $objP->getProgramById($programId);

    // set the value
    $button_save = 'Edit Program';
    $form_action = 'edit_program';

}else{
    $button_save = 'Add Program';
    $form_action = 'add_program';
}

?>

<script type="text/javascript">
$(document).ready(function() {
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
		if(this.value==1){
		  $('#firstCycle').show();
		}else if(this.value==2){
		  $('#firstCycle').show();
		  $('#secondCycle').show();
		}else if(this.value==3){
		  $('#firstCycle').show();
		  $('#secondCycle').show();
		  $('#thirdCycle').show();
		}
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
                        <input type="text" class="inp_txt" id="txtPrgmName" maxlength="50" name="txtPrgmName" required="true">
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
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Duration <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromPrgm" name="prog_from_date" required="true"/>
                        To:<input type="text" size="12" id="toPrgm" name="prog_to_date" required="true"/>
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
						</div>
						<div class="cylcebox">
							<h3>Days</h3>
							<select id="slctDays1" name="slctDays1[]" class="ts-avail" multiple="multiple" required="true">
								<option value="0">Mon</option>
								<option value="1">Tue</option>
								<option value="2">Wed</option>
								<option value="3">Thu</option>
								<option value="4">Fri</option>
								<option value="5">Sat</option>
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
							</div>
							<div class="cylcebox">
								<h3>Days</h3>
								<select id="slctDays2" name="slctDays2[]" class="ts-avail" multiple="multiple" required="true">
									<option value="0">Mon</option>
									<option value="1">Tue</option>
									<option value="2">Wed</option>
									<option value="3">Thu</option>
									<option value="4">Fri</option>
									<option value="5">Sat</option>
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
							</div>
							<div class="cylcebox">
								<h3>Days</h3>
								<select id="slctDays3" name="slctDays3[]" class="ts-avail" multiple="multiple" required="true">
									<option value="0">Mon</option>
									<option value="1">Tue</option>
									<option value="2">Wed</option>
									<option value="3">Thu</option>
									<option value="4">Fri</option>
									<option value="5">Sat</option>
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

