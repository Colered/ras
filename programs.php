<?php
include('header.php');
$user = getPermissions('programs');
$objP = new Programs();
$objClassroom = new Classroom();
$programId="";
if(isset($_GET['edit']) && $_GET['edit']!=''){
	if($user['edit'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
    $programId = base64_decode($_GET['edit']);
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    $unitArr[]= explode(',',$row['unit']);
    // set the value
    $button_save = 'Update';
    $form_action = 'edit_program';

}else{
	if($user['add_role'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
    $button_save = 'Add Program';
    $form_action = 'add_program';
}

$program_name = isset($_GET['edit']) ? $row['program_name'] : (isset($_POST['txtPrgmName'])? $_POST['txtPrgmName']:'');
$company_name = isset($_GET['edit']) ? $row['company'] : (isset($_POST['txtCompanyName'])? $_POST['txtCompanyName']:'');
$no_participants = isset($_GET['edit']) ? $row['participants'] : (isset($_POST['txtParticipants'])? $_POST['txtParticipants']:'');
$program_type = isset($_GET['edit']) ? $row['program_type'] : (isset($_POST['slctPrgmType'])? $_POST['slctPrgmType']:'');
$max_session_no = isset($_GET['edit']) ? $row['max_no_session'] : (isset($_POST['maxSessNo'])? $_POST['maxSessNo']:'');
$max_tot_session_no = isset($_GET['edit']) ? $row['max_tot_no_session'] : (isset($_POST['maxTotSessNo'])? $_POST['maxTotSessNo']:'');
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
<style>
.custtd_left{ width:320px;}
</style>
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
                        <h2>Max No Sessions of Same Area during a Class day <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<?php 
						$maxsess = array();
						if(count($max_session_no)>0){
							$maxsess = explode('-', $max_session_no);
						}
					 ?>
						<span>MON:</span> <select id="slctMon" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[0]) && $i == $maxsess[0]) || ((isset($maxsess[0]) && $maxsess[0]=='') && ($i==2))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>TUE:</span> <select id="slctTue" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[1]) && $i == $maxsess[1]) || ((!isset($maxsess[1]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>WED:</span> <select id="slctWed" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[2]) && $i == $maxsess[2]) || ((!isset($maxsess[2]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>THU:</span> <select id="slctThu" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[3]) && $i == $maxsess[3]) || ((!isset($maxsess[3]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>FRI:</span> <select id="slctFri" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[4]) && $i == $maxsess[4]) || ((!isset($maxsess[4]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>SAT:</span> <select id="slctSat" name="maxSessNo[]" class="required">
							<?php for($i=0; $i<=10; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxsess[5]) && $i == $maxsess[5]) || ((!isset($maxsess[5]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
                    </div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Max Total No. of Sessions during a Class Day <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<?php 
						$maxTotSess = array();
						if(count($max_tot_session_no)>0){
							$maxTotSess = explode('-', $max_tot_session_no);
						}
					 ?>
						<span>MON:</span> <select id="slctMon" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[0]) && $i == $maxTotSess[0]) || ((isset($maxTotSess[0]) && $maxTotSess[0]=='') && ($i==2))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>TUE:</span> <select id="slctTue" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[1]) && $i == $maxTotSess[1]) || ((!isset($maxTotSess[1]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>WED:</span> <select id="slctWed" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[2]) && $i == $maxTotSess[2]) || ((!isset($maxTotSess[2]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>THU:</span> <select id="slctThu" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[3]) && $i == $maxTotSess[3]) || ((!isset($maxTotSess[3]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>FRI:</span> <select id="slctFri" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[4]) && $i == $maxTotSess[4]) || ((!isset($maxTotSess[4]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
						<span>SAT:</span> <select id="slctSat" name="maxTotSessNo[]" class="required">
							<?php for($i=0; $i<=50; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php echo ((isset($maxTotSess[5]) && $i == $maxTotSess[5]) || ((!isset($maxTotSess[5]) && ($i==2)))) ? 'selected' : ''?>><?php echo $i; ?></option>
							<?php } ?>
                        	</select>
                    </div>
					<div class="clear"></div>
					<div class="custtd_left">
						<h2>No. of Participants</h2>
					</div>
					<div class="txtfield">
						<input type="text" class="inp_txt" id="txtParticipants" maxlength="100" name="txtParticipants" value="<?php echo $no_participants;?>">
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
					<div class="custtd_left">
                        <h2>Classroom Priority Order <span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
                        
						<?php
						$allRooms = $objClassroom->getRoom();
						$total = $allRooms->num_rows;
						$selectedOrder=""; $order_priority=0;
						if($total >0){
							while($row = $allRooms->fetch_assoc())
							{ 
								?>
								<div class="names" style="float:left; width:190px; text-align:left">
								<input type="text" readonly="readonly" name="roomnames[<?php echo $row['id']; ?>]" value="<?php echo $row['room_name']; ?>" style="border:none" />
								</div>
								<select id="roomorder" name="roomorder[]" class="select1 required" style="width: 40px; text-align:left">
								<?php 
								if($programId!=""){
									$roomOrdersData = $objClassroom->getRoomsPriorityOrder($programId, $row['id'] );
									$orderRow = $roomOrdersData->fetch_assoc();
									$order_priority = $orderRow['order_priority'];
								}
								for($i=1; $i<=$total; $i++){
									?>
									<option <?php if($i==$order_priority){ echo "selected='selected'"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option> <?php
							 	} ?>
								</select><br />
							<?php }	
						} ?>
						
						<script type="text/javascript">
							jQuery('#slctPrgmType').val("<?php echo $program_type;?>");
						</script>
                    </div>
                    <div class="clear"></div>
                   <!-- <div class="custtd_left">
                        <h2>Program Duration <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromPrgm" name="prog_from_date" value="<?php //echo $objP->formatDate($program_from_date);?>" class="required" readonly/>
                        To:<input type="text" size="12" id="toPrgm" name="prog_to_date" value="<?php //echo $objP->formatDate($program_to_date);?>" class="required" readonly/>
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

