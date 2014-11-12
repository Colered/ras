<?php
include('header.php');
$objP = new Programs();
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    $unitArr[]= explode(',',$row['unit']);

    // set the value
    $button_save = 'Edit Program';
    $form_action = 'edit_program';

}else{
    $button_save = 'Add Program';
    $form_action = 'add_program';
}

$program_name = isset($_GET['edit']) ? $row['program_name'] : (isset($_POST['txtPrgmName'])? $_POST['txtPrgmName']:'');
$company_name = isset($_GET['edit']) ? $row['company'] : (isset($_POST['txtCompanyName'])? $_POST['txtCompanyName']:'');
$program_type = isset($_GET['edit']) ? $row['program_type'] : (isset($_POST['slctPrgmType'])? $_POST['slctPrgmType']:'');
$program_from_date = isset($_GET['edit']) ? $row['start_date'] : (isset($_POST['prog_from_date'])? $_POST['prog_from_date']:'');
$program_to_date = isset($_GET['edit']) ? $row['end_date'] : (isset($_POST['prog_to_date'])? $_POST['prog_to_date']:'');

$unitArr1 = isset($_GET['edit']) ? (isset($unitArr[0])? $unitArr[0]: array()) : (!empty($_POST['slctUnit']) ? $_POST['slctUnit'] : array());



?>
<script type="text/javascript">
$(document).ready(function() {
	$('#slctPrgmType').on('change', function() {
           $('#fromPrgm').val('');
		   $('#toPrgm').val('');
	});
});
</script>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Program</div>
			<form name="frmProgram" id="frmProgram" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="<?php echo $form_action;?>" />
			  <?php if(isset($_GET['edit'])){?>
			  	<input type="hidden" name="programId" value="<?php echo $_GET['edit'];?>" />
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
                        <input type="text" class="inp_txt required" id="txtPrgmName" maxlength="50" name="txtPrgmName" value="<?php echo $program_name;?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Unit <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctUnit" name="slctUnit[]" class="selectMultiple required" size="5" multiple="multiple">
                            <option value="1" <?php echo in_array(1,$unitArr1) ? 'selected' : ''?>>Executive Education</option>
                            <option value="2" <?php echo in_array(2,$unitArr1) ? 'selected' : ''?>>Master Programs</option>
							<option value="3" <?php echo in_array(3,$unitArr1) ? 'selected' : ''?>>Tailored Programs</option>
							<option value="4" <?php echo in_array(4,$unitArr1) ? 'selected' : ''?>>Activity</option>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
						<h2>Company</h2>
					</div>
					<div class="txtfield">
						<input type="text" class="inp_txt" id="txtCompanyName" maxlength="100" name="txtCompanyName" value="<?php echo $company_name;?>">
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Type <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctPrgmType" name="slctPrgmType" class="select1 required">
                            <option value="">--Select Program--</option>
                            <option value="1">One Year</option>
                            <option value="2">Two Year</option>
							<option value="3">Three Year</option>
                        </select>
						<script type="text/javascript">
							jQuery('#slctPrgmType').val("<?php echo $program_type;?>");
						</script>
                    </div>
                    <div class="clear"></div>
                   <!-- <div class="custtd_left">
                        <h2>Program Duration <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromPrgm" name="prog_from_date" value="<?php echo $objP->formatDate($program_from_date);?>" class="required" readonly/>
                        To:<input type="text" size="12" id="toPrgm" name="prog_to_date" value="<?php echo $objP->formatDate($program_to_date);?>" class="required" readonly/>
                    </div>
                    <div class="clear"></div>-->
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

