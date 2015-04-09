<?php
include('header.php');
$user = getPermissions('programs');
$objP = new Programs();
if(isset($_GET['clone']) && $_GET['clone']!=''){
	if($user['clone'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
    $programId = base64_decode($_GET['clone']);
    $result = $objP->getProgramById($programId);
    $row = $result->fetch_assoc();
    $unitArr[]= explode(',',$row['unit']);
    // set the value
    $button_save = 'Save & Continue';
    $form_action = 'clone_program';
}
$program_name = isset($_GET['clone']) ? $row['program_name'] : (isset($_POST['txtPrgmName'])? $_POST['txtPrgmName']:'');
$company_name = isset($_GET['clone']) ? $row['company'] : (isset($_POST['txtCompanyName'])? $_POST['txtCompanyName']:'');
$program_type = isset($_GET['clone']) ? $row['program_type'] : (isset($_POST['slctPrgmType'])? $_POST['slctPrgmType']:'');
$max_session_no = isset($_GET['clone']) ? $row['max_no_session'] : (isset($_POST['maxSessNo'])? $_POST['maxSessNo']:'');
$max_tot_session_no = isset($_GET['clone']) ? $row['max_tot_no_session'] : (isset($_POST['maxTotSessNo'])? $_POST['maxTotSessNo']:'');
$unitArr1 = isset($_GET['clone']) ? (isset($unitArr[0])? $unitArr[0]: array()) : (!empty($_POST['slctUnit']) ? $_POST['slctUnit'] : array());
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
.custtd_left{ width:320px;padding:5px;}
.h_title{padding:5px;}
.additionTbl{ width:75%;}
.custtable_left{padding:15px;}
.clearfix ul li{
float:left;
color:#fff;
padding: 5px;
min-width: 120px;
margin: 5px 10px;
border:1px solid black;
}
.clearfix ul{
margin-left:6px !important;
}
</style>
<div id="content">
    <div id="main">
	<div class="steps clearfix">
		<ul>
			<li style="background-color: #0092B0;color:#fff; list-style:none;"><span style="font-size:14px;"><strong>Step-1  </strong></span>Cloning Program &amp; Cycles</li>
			<li style="background-color: #eee;color:#aaa; list-style:none;"><span style="font-size:14px;"><strong>Step-2  </strong></span>Cloning Subjects</li>
		</ul>
	</div>
	<div style="float:right;padding:5px 5px;">
			<input type="button" name="btnAdd" id="btnAdd" class="buttonsub" value="<?php echo $button_save;?>" onclick="addClonedProgram();">
			<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='programs_view.php';">
	</div>	
	<form name="frmProgram" id="frmProgram" action="postdata.php" method="post">	
	<div class="full_w">
	
            <div class="h_title">Clone of Program "<?php echo $program_name; ?>"</div>	
				
			    <input type="hidden" name="form_action" value="<?php echo $form_action;?>" />
				<?php if(isset($_GET['clone'])){?>
			  	<input type="hidden" name="programId" value="<?php echo $_GET['clone'];?>" />
				<?php } ?>
                <div class="custtable_left">
				<?php if(isset($_SESSION['error_msg'])) {?>
                    <div class="custtd_left red">
						 <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
				<?php } ?>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtPrgmName" maxlength="50" name="txtPrgmName" value="Clone of- <?php echo $program_name;?>">
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
					<?php $disabled = (isset($_GET['clone']) ? 'disabled="disabled"' :''); ?>
                        <select id="slctPrgmType" name="slctPrgmType" class="select1 required" <?php echo $disabled;?>>
                            <option value="">--Select Program--</option>
                            <option value="1">One Year</option>
                            <option value="2">Two Year</option>
							<option value="3">Three Year</option>
                        </select>
						<script type="text/javascript">
							jQuery('#slctPrgmType').val("<?php echo $program_type;?>");
						</script>
						<?php if($disabled!="") {?>         
						<input type="hidden" name="slctPrgmType" value="<?php echo $program_type;?>"/>
						<?php } ?>
                    </div>
                    <div class="clear"></div>                 
                </div>
            
        </div><!--end full_w div-->
        <!-- add program cycles-->
		<?php 
		$rel_prog = $objP->getProgramYearsById($programId);	
		while($row = $rel_prog->fetch_assoc()) 
		{
			$totcycle=0;
			$program_year_id = $row['id'];
			$totcycle = $objP->getCyclesInProgram($program_year_id);
			$start_week = $end_week = $occurrence = $week1 = $week2 = array();
			$cycleData = $objP->getProgramCycleList($program_year_id);
			while($data = $cycleData->fetch_assoc()){
			   $cycleIdsArr[]= $data['id'];
			   $start_week[] = $data['start_week'];
			   $end_week[] = $data['end_week'];
			   $occurrence[] = $data['occurrence'];
			   $week1[] = unserialize($data['week1']);
			   $week2[] = unserialize($data['week2']);			
			 }
			 //print"<pre>";print_r($occurrence);
			$no_of_cycles = isset($_GET['clone']) ? $totcycle : (isset($_POST['slctNumcycle'])? $_POST['slctNumcycle']:'');
			$startweek_1 = isset($_GET['clone']) ? (isset($start_week[0])? $start_week[0]:'') : (isset($_POST['startweek1'])? $_POST['startweek1']:'');
			$startweek_2 = isset($_GET['clone']) ? (isset($start_week[1])? $start_week[1]:'') : (isset($_POST['startweek2'])? $_POST['startweek2']:'');
			$startweek_3 = isset($_GET['clone']) ? (isset($start_week[2])? $start_week[2]:'') : (isset($_POST['startweek3'])? $_POST['startweek3']:'');
			$endweek_1 = isset($_GET['clone']) ? (isset($end_week[0])? $end_week[0]:'') : (isset($_POST['endweek1'])? $_POST['endweek1']:'');
			$endweek_2 = isset($_GET['clone']) ? (isset($end_week[1])? $end_week[1]:'') : (isset($_POST['endweek2'])? $_POST['endweek2']:'');
			$endweek_3 = isset($_GET['clone']) ? (isset($end_week[2])? $end_week[2]:'') : (isset($_POST['endweek3'])? $_POST['endweek3']:'');
			?>
			<script type="text/javascript">
				$(document).ready(function() {
					show_hide_cycle_clone('<?php echo $no_of_cycles;?>','<?php echo $program_year_id;?>');
					showHideTimeslots('<?php echo $program_year_id;?>');
					showTimeSlotsClone('<?php echo $program_year_id;?>');
					showHideDates('<?php echo $program_year_id;?>');
					$(function () {
						$("#frmProgram").validate().settings.ignore = ':hidden';
					});
				});				
			</script>
		
		<div class="full_w">		
			<div class="h_title">Program Cycles <?php echo $row['name'];?></div>			
				<input type="hidden" name="form_action" value="clone_program" />
				<div class="custtd_left red"></div>
				<div class="clear"></div>
				<div class="custtd_left"><h2>No. of Cycles<span class="redstar">*</span></h2></div>                   
				<div class="txtfield">
					<select id="slctNumCycle" name="programcycles[<?php echo $program_year_id;?>][slctNumcycle]" class="select" <?php if(isset($cycleIdsArr) && count($cycleIdsArr)>0){ echo "readonly"; }?> onchange="show_hide_cycle_clone(this.value,<?php echo $program_year_id;?>)">
						<option value="">--Select Cycles--</option>
						<option value="1" <?php if($no_of_cycles == 1) echo 'selected="selected"';?>>1 </option>
						<option value="2" <?php if($no_of_cycles == 2) echo 'selected="selected"';?>>2 </option>
						<option value="3" <?php if($no_of_cycles == 3) echo 'selected="selected"';?>>3 </option>
					</select>
					
				</div>
				<div class="clear"></div>
				<div id="firstCycle-<?php echo $program_year_id;?>" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
					<div class="custtd_left"><h2>1st cycle<span class="redstar">*</span></h2></div>
					<div class="txtfield">
						<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][startweek1]" value="<?php echo $objP->formatDateByDate($startweek_1);?>" class="required" readonly />
						</div>
						<div class="cylcebox">
							<h3>End Date</h3>
							<input type="text" size="14" id="endweek1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][endweek1]" value="<?php echo $objP->formatDateByDate($endweek_1);?>" class="required" readonly />
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left"><h2>Occurring<span class="redstar">*</span></h2></div>
                    <div class="txtfield">
                        <select id="c1chWeek1" name="programcycles[<?php echo $program_year_id;?>][c1chWeek1]" class="select required" onchange="showCycleDetailsclone(this.value,<?php echo $program_year_id;?>);">
                            <option value="">--Select Week--</option>
                            <option value="1w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
                            <option value="2w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc1w1-<?php echo $program_year_id;?>" style="display:none;"><h2>Days and Timeslot 1st<span class="redstar">*</span></h2></div>
					<div class="txtfield">
						<div id="c1week1-<?php echo $program_year_id;?>" style="display:none;">
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-0-<?php echo $program_year_id;?>" value="Mon1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
								<select id="ts-avail-c1-w1-0-<?php echo $program_year_id;?>" name="<programcycles[<?php echo $program_year_id;?>][cycle1][week1][0][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week1[0][0]))
											$arr = $week1[0][0];
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-1-<?php echo $program_year_id;?>" value="Tue1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
								<select id="ts-avail-c1-w1-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week1][1][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week1[0][1]))
										$arr = $week1[0][1]; 
										else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-2-<?php echo $program_year_id;?>"  value="Wed1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
								<select id="ts-avail-c1-w1-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week1][2][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week1[0][2]))
											$arr = $week1[0][2];
										else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-3-<?php echo $program_year_id;?>"  value="Thu1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
								 <select id="ts-avail-c1-w1-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week1][3][]" class="slctTs required" multiple="multiple">
								   <?php if(isset($week1[0][3]))
											$arr = $week1[0][3];
										 else
											$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-4-<?php echo $program_year_id;?>"  value="Fri1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
								 <select id="ts-avail-c1-w1-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week1][4][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week1[0][4]))
											$arr = $week1[0][4];
										else
											$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w1">
								<input type="checkbox" id="c1-w1-5-<?php echo $program_year_id;?>" value="Sat1C1W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[0][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
								 <select id="ts-avail-c1-w1-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week1][5][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week1[0][5]))
											$arr = $week1[0][5];
										else
											$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
                        </div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc1w2-<?php echo $program_year_id;?>" style="display:none;"><h2>Days and Timeslot 2nd<span class="redstar">*</span></h2></div>
					<div class="txtfield">
						<div id="c1week2-<?php echo $program_year_id;?>" style="display:none;">
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-0-<?php echo $program_year_id;?>" value="Mon2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
								<select id="ts-avail-c1-w2-0-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][0][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week2[0][0]))
											$arr = $week2[0][0];
										  else
											$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-1-<?php echo $program_year_id;?>" value="Tue2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
								<select id="ts-avail-c1-w2-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][1][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week2[0][1]))
											$arr = $week2[0][1];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-2-<?php echo $program_year_id;?>" value="Wed2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
								 <select id="ts-avail-c1-w2-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][2][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week2[0][2]))
											$arr = $week2[0][2];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-3-<?php echo $program_year_id;?>" value="Thu2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
								 <select id="ts-avail-c1-w2-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][3][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week2[0][3]))
											$arr = $week2[0][3];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-4-<?php echo $program_year_id;?>" value="Fri2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
								 <select id="ts-avail-c1-w2-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][4][]" class="slctTs required" multiple="multiple">
								   <?php if(isset($week2[0][4]))
											$arr = $week2[0][4];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc1w2">
								<input type="checkbox" id="c1-w2-5-<?php echo $program_year_id;?>" value="Sat2C1W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[0][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
								 <select id="ts-avail-c1-w2-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle1][week2][5][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week2[0][5]))
											$arr = $week2[0][5];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left"><h2>Add Exception</h2></div>						
					<div class="txtfield"><input type="text" size="14" id="exceptnProgAval1-<?php echo $program_year_id;?>" name="exceptnProgAval1" readonly /></div>
					<div class="addbtnException"><input type="button" name="btnAddMore" class="btnProgCycleAvailExcep1-<?php echo $program_year_id;?>" value="Add" onclick="addExceptionDate(<?php echo $program_year_id; ?>)"></div>
					<div class="clear"></div>
					<div class="custtd_left"></div>
					<div class="divException1-<?php echo $program_year_id;?>">
						<?php
						if($programId!=""){
							$objP->getProgExceptionsClone($program_year_id,1);
						 } ?>
					</div>
					<div class="clear"></div>
					<!--add new additional day and time-->
					<div class="clear"></div>
					<div class="custtd_left"><h2>Add Additional Day and Timeslot</h2></div>					
					<div class="txtfield">
						<input type="text" size="14" id="additionalDayCal1-<?php echo $program_year_id;?>" name="additionalDayCal1" readonly />
					</div>
					<div class="txtfield">
						<select id="timeSlot1-<?php echo $program_year_id; ?>" name="additionalDayTS1[]" class="timeSlot1" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions();echo $options;?>
						</select>
					</div>
					<div class="addbtnAddition">
						<input type="button" name="btnAddMore" class="additionalDayButt1-<?php echo $program_year_id; ?>" value="Add" onclick="addAdditionDates(<?php echo $program_year_id; ?>)">
					</div>
					<div class="divAddition1" id="divAddition1-<?php echo $program_year_id;?>">
						<?php
						if($programId!=""){
							$objP->getProgAdditionClone($program_year_id,1);
						 } ?>
					</div>
					<div class="clear"></div>
					<div class="clear"></div>
				</div><!--first cycle end-->
				<div id="secondCycle-<?php echo $program_year_id;?>" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
					<div class="custtd_left"><h2>2nd cycle<span class="redstar">*</span></h2></div>			
					<div class="txtfield">
						<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][startweek2]" value="<?php echo $objP->formatDateByDate($startweek_2);?>" class="required" readonly />
						</div>
						<div class="cylcebox">
							<h3>End Date</h3>
							<input type="text" size="14" id="endweek2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][endweek2]" value="<?php echo $objP->formatDateByDate($endweek_2);?>" class="required" readonly />
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left"><h2>Occurring<span class="redstar">*</span></h2></div>
					<div class="txtfield">
						<select id="c1chWeek2" name="programcycles[<?php echo $program_year_id;?>][c1chWeek2]" class="select required" onchange="showCycleDetailstwoclone(this.value,<?php echo $program_year_id;?>);">
							<option value="">--Select Week--</option>
							<option value="1w" <?php if(isset($occurrence['1']) && $occurrence['1'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
							<option value="2w" <?php if(isset($occurrence['1']) && $occurrence['1'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
						</select>
					</div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc2w1-<?php echo $program_year_id;?>" style="display:none;">
						<h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
						<div id="c2week1-<?php echo $program_year_id;?>" style="display:none;">
							<div class="tmSlotc2w1">
								<input type="checkbox" id="c2-w1-0-<?php echo $program_year_id;?>" value="MonC2W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[1][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
								<select id="ts-avail-c2-w1-0-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][0][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week1[1][0]))
										$arr = $week1[1][0];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w1">
								<input type="checkbox" id="c2-w1-1-<?php echo $program_year_id;?>" value="TueC2W1-<?php echo $program_year_id;?>" class="days"  <?php if(isset($week1[1][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
								<select id="ts-avail-c2-w1-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][1][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week1[1][1]))
										$arr = $week1[1][1];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w1">
								<input type="checkbox" id="c2-w1-2-<?php echo $program_year_id;?>" value="WedC2W1-<?php echo $program_year_id;?>" class="days"  <?php if(isset($week1[1][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
								 <select id="ts-avail-c2-w1-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][2][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week1[1][2]))
										$arr = $week1[1][2];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w1">
								<input type="checkbox" id="c2-w1-3-<?php echo $program_year_id;?>" value="ThuC2W1-<?php echo $program_year_id;?>" class="days"  <?php if(isset($week1[1][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
								 <select id="ts-avail-c2-w1-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][3][]" class="slctTs required" multiple="multiple">
								   <?php if(isset($week1[1][3]))
										$arr = $week1[1][3];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w1">
								<input type="checkbox" id="c2-w1-4-<?php echo $program_year_id;?>" value="FriC2W1-<?php echo $program_year_id;?>" class="days"  <?php if(isset($week1[1][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
								 <select id="ts-avail-c2-w1-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][4][]" class="slctTs required" multiple="multiple">
								<?php if(isset($week1[1][4]))
										$arr = $week1[1][4];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
							<div class="tmSlot">
								<input type="checkbox" id="c2-w1-5-<?php echo $program_year_id;?>" value="SatC2W1-<?php echo $program_year_id;?>" class="days"  <?php if(isset($week1[1][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
								 <select id="ts-avail-c2-w1-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week1][5][]" class="slctTs required" multiple="multiple">
								<?php if(isset($week1[1][5]))
										$arr = $week1[1][5];
										else
									$arr = array();
									$options = $objP->getTimeslotOptions($arr);
									echo $options;?>
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc2w2-<?php echo $program_year_id;?>" style="display:none;">
						<h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
						<div id="c2week2-<?php echo $program_year_id;?>" style="display:none;">
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-0-<?php echo $program_year_id;?>" value="MonC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
								<select id="ts-avail-c2-w2-0-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][0][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week2[1][0]))
											$ar = $week2[1][0];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-1-<?php echo $program_year_id;?>" value="TueC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
								<select id="ts-avail-c2-w2-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][1][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week2[1][1]))
											$arr = $week2[1][1];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-2-<?php echo $program_year_id;?>" value="WedC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
								 <select id="ts-avail-c2-w2-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][2][]" class="slctTs required" multiple="multiple">
								   <?php if(isset($week2[1][2]))
											$arr = $week2[1][2];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-3-<?php echo $program_year_id;?>" value="ThuC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
								 <select id="ts-avail-c2-w2-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][3][]" class="slctTs required" multiple="multiple">
								   <?php if(isset($week2[1][3]))
											$arr = $week2[1][3];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-4-<?php echo $program_year_id;?>" value="FriC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
								 <select id="ts-avail-c2-w2-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][4][]" class="slctTs required" multiple="multiple">
								  <?php if(isset($week2[1][4]))
											$arr = $week2[1][4];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
							<div class="tmSlotc2w2">
								<input type="checkbox" id="c2-w2-5-<?php echo $program_year_id;?>" value="SatC2W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[1][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
								 <select id="ts-avail-c2-w2-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle2][week2][5][]" class="slctTs required" multiple="multiple">
								 <?php if(isset($week2[1][5]))
											$arr = $week2[1][5];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left"><h2>Add Exception</h2></div>
					<div class="txtfield">
						<input type="text" size="14" id="exceptnProgAval2-<?php echo $program_year_id;?>" name="exceptnProgAval2" readonly />
					</div>
					<div class="addbtnException">
						<input type="button" name="btnAddMore" class="btnProgCycleAvailExcep2-<?php echo $program_year_id;?>" value="Add" onclick="addExceptionDateTwo(<?php echo $program_year_id; ?>)">
					</div>
					<div class="clear"></div>
					<div class="custtd_left"></div>
					<div class="divException2-<?php echo $program_year_id;?>">
						<?php
						if($programId!=""){
							 $objP->getProgExceptionsClone($program_year_id,2);
						 } ?>
					</div>
					<div class="clear"></div>
					<div class="clear"></div>
					<div class="custtd_left">
						<h2>Add Additional Day and Timeslot</h2>
					</div>
					<div class="txtfield"><input type="text" size="14" id="additionalDayCal2-<?php echo $program_year_id;?>" name="additionalDayCal2" readonly /></div>
					<div class="txtfield">
						<select id="timeSlot2-<?php echo $program_year_id;?>" name="additionalDayTS2[]" class="timeSlot2" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions();echo $options;?>
						</select>
					</div>
					<div class="addbtnAddition"><input type="button" name="btnAddMore" class="additionalDayButt2-<?php echo $program_year_id;?>" value="Add" onclick="addAdditionDatesCycleTwo(<?php echo $program_year_id; ?>)"></div>
					<div class="divAddition2" id="divAddition2-<?php echo $program_year_id;?>">
						<?php
						if($programId!=""){
							$objP->getProgAdditionClone($program_year_id,2);
						 } ?>
					</div>
					<div class="clear"></div>
					<div class="clear"></div>
				</div><!--second cycle ends here-->
				<div id="thirdCycle-<?php echo $program_year_id;?>" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
					<div class="custtd_left"><h2>3rd cycle<span class="redstar">*</span></h2></div>
						<div class="txtfield">
							<div class="cylcebox">
								<h3>Start Date</h3>
								<input type="text" size="14" id="startweek3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][startweek3]" value="<?php echo $objP->formatDateByDate($startweek_3);?>" class="required" readonly />
							</div>
							<div class="cylcebox">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][endweek3]" value="<?php echo $objP->formatDateByDate($endweek_3);?>" class="required" readonly />
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left"><h2>Occurring<span class="redstar">*</span></h2></div>
						<div class="txtfield">
							<select id="c1chWeek3" name="programcycles[<?php echo $program_year_id;?>][c1chWeek3]" class="select required" onchange="showCycleDetailsthreeclone(this.value,<?php echo $program_year_id;?>);">
								<option value="">--Select Week--</option>
								<option value="1w" <?php if(isset($occurrence['2']) && $occurrence['2'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
								<option value="2w" <?php if(isset($occurrence['2']) && $occurrence['2'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
							</select>
						</div>
						<div class="clear"></div>
						<div class="custtd_left" id="custtd_leftc3w1-<?php echo $program_year_id;?>" style="display:none;">
							<h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div id="c3week1-<?php echo $program_year_id;?>" style="display:none;">
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-0-<?php echo $program_year_id;?>" value="MonC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
									<select id="ts-avail-c3-w1-0-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][0][]" class="slctTs required" multiple="multiple">
										<?php if(isset($week1[2][0]))
											$arr = $week1[2][0];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-1-<?php echo $program_year_id;?>" value="TueC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
									<select id="ts-avail-c3-w1-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][1][]" class="slctTs required" multiple="multiple">
									   <?php if(isset($week1[2][1]))
											$arr = $week1[2][1];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-2-<?php echo $program_year_id;?>" value="WedC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
									 <select id="ts-avail-c3-w1-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][2][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week1[2][2]))
											$arr = $week1[2][2];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-3-<?php echo $program_year_id;?>" value="ThuC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
									 <select id="ts-avail-c3-w1-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][3][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week1[2][3]))
											$arr = $week1[2][3];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-4-<?php echo $program_year_id;?>" value="FriC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
									 <select id="ts-avail-c3-w1-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][4][]" class="slctTs required" multiple="multiple">
										<?php if(isset($week1[2][4]))
											$arr = $week1[2][4];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w1">
									<input type="checkbox" id="c3-w1-5-<?php echo $program_year_id;?>" value="SatC3W1-<?php echo $program_year_id;?>" class="days" <?php if(isset($week1[2][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
									 <select id="ts-avail-c3-w1-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week1][5][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week1[2][5]))
											$arr = $week1[2][5];
											else
										$arr = array();
										$options = $objP->getTimeslotOptions($arr);
										echo $options;?>
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="clear"></div>
						<div class="custtd_left" id="custtd_leftc3w2-<?php echo $program_year_id;?>" style="display:none;">
							<h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div id="c3week2-<?php echo $program_year_id;?>" style="display:none;">
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-0-<?php echo $program_year_id;?>" value="MonC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
									<select id="ts-avail-c3-w2-0-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][0][]" class="slctTs required" multiple="multiple">
										<?php if(isset($week2[2][0]))
												$arr = $week2[2][0];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-1-<?php echo $program_year_id;?>" value="TueC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
									<select id="ts-avail-c3-w2-1-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][1][]" class="slctTs required" multiple="multiple">
									   <?php if(isset($week2[2][1]))
												$arr = $week2[2][1];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-2-<?php echo $program_year_id;?>" value="WedC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
									 <select id="ts-avail-c3-w2-2-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][2][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week2[2][2]))
												$arr = $week2[2][2];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-3-<?php echo $program_year_id;?>" value="ThuC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
									 <select id="ts-avail-c3-w2-3-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][3][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week2[2][3]))
												$arr = $week2[2][3];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-4-<?php echo $program_year_id;?>" value="FriC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
									 <select id="ts-avail-c3-w2-4-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][4][]" class="slctTs required" multiple="multiple">
									  <?php if(isset($week2[2][4]))
												$arr = $week2[2][4];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
								<div class="tmSlotc3w2">
									<input type="checkbox" id="c3-w2-5-<?php echo $program_year_id;?>" value="SatC3W2-<?php echo $program_year_id;?>" class="days" <?php if(isset($week2[2][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
									 <select id="ts-avail-c3-w2-5-<?php echo $program_year_id;?>" name="programcycles[<?php echo $program_year_id;?>][cycle3][week2][5][]" class="slctTs required" multiple="multiple">
									<?php if(isset($week2[2][5]))
												$arr = $week2[2][5];
												else
											$arr = array();
											$options = $objP->getTimeslotOptions($arr);
											echo $options;?>
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left"><h2>Add Exception</h2></div>
						<div class="txtfield">
							<input type="text" size="14" id="exceptnProgAval3-<?php echo $program_year_id;?>" name="exceptnProgAval3" readonly />
						</div>
						<div class="addbtnException">
							<input type="button" name="btnAddMore" class="btnProgCycleAvailExcep3-<?php echo $program_year_id;?>" value="Add" onclick="addExceptionDateThree(<?php echo $program_year_id; ?>)">
						</div>
						<div class="clear"></div>
						<div class="custtd_left"></div>
						<div class="divException3-<?php echo $program_year_id;?>">
							<?php
							if($programId!=""){
								 $objP->getProgExceptionsClone($program_year_id,3);
							 } ?>
						</div>
						<div class="clear"></div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Add Additional Day and Timeslot</h2>
						</div>
						<div class="txtfield">
							<input type="text" size="14" id="additionalDayCal3-<?php echo $program_year_id;?>" name="additionalDayCal3" readonly />
						</div>
						<div class="txtfield">
							<select id="timeSlot3-<?php echo $program_year_id;?>" name="additionalDayTS3[]" class="timeSlot3" multiple="multiple">
								<?php $options = $objP->getTimeslotOptions();echo $options;?>
							</select>
						</div>
						<div class="addbtnAddition">
							<input type="button" name="btnAddMore" class="additionalDayButt3-<?php echo $program_year_id;?>" value="Add" onclick="addAdditionDatesCycleThree(<?php echo $program_year_id; ?>)">
						</div>
						<div class="divAddition3" id="divAddition3-<?php echo $program_year_id;?>">
							<?php
							if($programId!=""){
								$objP->getProgAdditionClone($program_year_id,3);
							 } ?>
						</div>
						<div class="clear"></div>
						<div class="clear"></div>
					</div>		
		</div>
		<script>
			$(document).ready(function(){
				<?php if(isset($occurrence['0'])){?>
					showCycleDetailsclone('<?php echo $occurrence['0'];?>','<?php echo $program_year_id;?>');
				<?php }if(isset($occurrence['1'])){?>
					showCycleDetailstwoclone('<?php echo $occurrence['1'];?>','<?php echo $program_year_id;?>');
				<?php }if(isset($occurrence['2'])){?>
					showCycleDetailsthreeclone('<?php echo $occurrence['2'];?>','<?php echo $program_year_id;?>');
				<?php } ?>
			});
		</script>
		<?php } ?>		
		 <!--<div class="txtfield">
			<input type="button" name="btnAdd" id="btnAdd" class="buttonsub" value="<?php echo $button_save;?>" onclick="addClonedProgram();">
		</div>
		<div class="txtfield">
			<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='programs_view.php';">
		</div>-->
		<!-- add program cycles-->
		<div class="clear"></div>
		</form>
    </div><!--end main div-->
    <div class="clear"></div>
</div><!--end content div-->
<?php include('footer.php'); ?>

