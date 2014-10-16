<?php
include('header.php');
$objP = new Programs();
$objTS = new Timeslot();
$programId = '';
//get the list of all available timeslots
$options = "";
$week1 = array(); $week2 = array();
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
       $start_week[] = $data['start_week'];
       $end_week[] = $data['end_week'];
	   $occurrence[] = $data['occurrence'];
	   $week1 = unserialize($data['week1']);
	   $week2 = unserialize($data['week2']);
       
    }
	//print"<pre>";print_r($week1);print"</pre>";
    // set the value
	
    $totcycle = $objP->getCyclesInProgram($programId);
	
}
$no_of_cycles = isset($_GET['edit']) ? $totcycle : (isset($_POST['slctNumcycle'])? $_POST['slctNumcycle']:'');
$cycleIdsArr = (!empty($cycleIdsArr) ? $cycleIdsArr : array());
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
                        <select id="c1chWeek1" name="c1chWeek1" class="select required" onchange="showCycleDetails(this.value);">
                            <option value="">--Select Week--</option>
                            <option value="1w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
                            <option value="2w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc1w1" style="display:none;">
                        <h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
					  <div id="c1week1" style="display:none;">
					    <div class="tmSlot">
						<input type="checkbox" id="c1-w1-0" value="Mon1C1W1" class="days" <?php if(isset($week1[0][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
						<select id="ts-avail-c1-w1-0" name="cycle1[week1][0][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week1[0][0]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w1-1" value="Tue1C1W1" class="days" <?php if(isset($week1[0][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
						<select id="ts-avail-c1-w1-1" name="cycle1[week1][1][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week1[0][1]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w1-2"  value="Wed1C1W1" class="days" <?php if(isset($week1[0][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
						 <select id="ts-avail-c1-w1-2" name="cycle1[week1][2][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week1[0][2]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w1-3"  value="Thu1C1W1" class="days" <?php if(isset($week1[0][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
						 <select id="ts-avail-c1-w1-3" name="cycle1[week1][3][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week1[0][3]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w1-4"  value="Fri1C1W1" class="days" <?php if(isset($week1[0][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
						 <select id="ts-avail-c1-w1-4" name="cycle1[week1][4][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week1[0][4]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w1-5" value="Sat1C1W1" class="days" <?php if(isset($week1[0][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
						 <select id="ts-avail-c1-w1-5" name="cycle1[week1][5][]" class="slctTs required" multiple="multiple">
                        <?php $options = $objP->getTimeslotOptions($week1[0][5]);echo $options;?>
                        </select>
						</div>
					  </div>	
                    </div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc1w2" style="display:none;">
                        <h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
                    </div>
		            <div class="txtfield">
					  <div id="c1week2" style="display:none;">
					    <div class="tmSlot">
                        <input type="checkbox" id="c1-w2-0" value="Mon2C1W2" class="days" <?php if(isset($week2[0][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
						<select id="ts-avail-c1-w2-0" name="cycle1[week2][0][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week2[0][0]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w2-1" value="Tue2C1W2" class="days" <?php if(isset($week2[0][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
						<select id="ts-avail-c1-w2-1" name="cycle1[week2][1][]" class="slctTs required" multiple="multiple">
                         <?php $options = $objP->getTimeslotOptions($week2[0][1]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w2-2" value="Wed2C1W2" class="days" <?php if(isset($week2[0][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
						 <select id="ts-avail-c1-w2-2" name="cycle1[week2][2][]" class="slctTs required" multiple="multiple">
                         <?php $options = $objP->getTimeslotOptions($week2[0][2]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w2-3" value="Thu2C1W2" class="days" <?php if(isset($week2[0][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
						 <select id="ts-avail-c1-w2-3" name="cycle1[week2][3][]" class="slctTs required" multiple="multiple">
                         <?php $options = $objP->getTimeslotOptions($week2[0][3]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w2-4" value="Fri2C1W2" class="days" <?php if(isset($week2[0][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
						 <select id="ts-avail-c1-w2-4" name="cycle1[week2][4][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week2[0][4]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c1-w2-5" value="Sat2C1W2" class="days" <?php if(isset($week2[0][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
						 <select id="ts-avail-c1-w2-5" name="cycle1[week2][5][]" class="slctTs required" multiple="multiple">
                         <?php $options = $objP->getTimeslotOptions($week2[0][5]);echo $options;?>
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
                    <div class="clear"></div>
				
					<div id="secondCycle" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
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
								<input type="text" size="14" id="endweek2" name="endweek2" value="<?php echo $objP->formatDateByDate($endweek_2);?>" class="required" readonly />
							</div>
						</div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Occurring<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<select id="c1chWeek1" name="c1chWeek2" class="select required" onchange="showCycleDetailstwo(this.value);">
								<option value="">--Select Week--</option>
								<option value="1w" <?php if(isset($occurrence['1']) && $occurrence['1'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
								<option value="2w" <?php if(isset($occurrence['1']) && $occurrence['1'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
							</select>
						</div>
						<div class="clear"></div>
						<div class="custtd_left" id="custtd_leftc2w1" style="display:none;">
							<h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
						</div>					
						<div class="txtfield">
						  <div id="c2week1" style="display:none;">
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-0" value="MonC2W1" class="days" <?php if(isset($week1[1][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
							<select id="ts-avail-c2-w1-0" name="cycle2[week1][0][]" class="slctTs required" multiple="multiple">
								<?php $options = $objP->getTimeslotOptions($week1[1][0]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-1" value="TueC2W1" class="days"  <?php if(isset($week1[1][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
							<select id="ts-avail-c2-w1-1" name="cycle2[week1][1][]" class="slctTs required" multiple="multiple">
							  <?php $options = $objP->getTimeslotOptions($week1[1][1]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-2" value="WedC2W1" class="days"  <?php if(isset($week1[1][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
							 <select id="ts-avail-c2-w1-2" name="cycle2[week1][2][]" class="slctTs required" multiple="multiple">
							 <?php $options = $objP->getTimeslotOptions($week1[1][2]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-3" value="ThuC2W1" class="days"  <?php if(isset($week1[1][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
							 <select id="ts-avail-c2-w1-3" name="cycle2[week1][3][]" class="slctTs required" multiple="multiple">
							   <?php $options = $objP->getTimeslotOptions($week1[1][3]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-4" value="FriC2W1" class="days"  <?php if(isset($week1[1][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
							 <select id="ts-avail-c2-w1-4" name="cycle2[week1][4][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week1[1][4]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c2-w1-5" value="SatC2W1" class="days"  <?php if(isset($week1[1][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
							 <select id="ts-avail-c2-w1-5" name="cycle2[week1][5][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week1[1][5]);echo $options;?>
							</select>
							</div>
						  </div>	
						</div>
					<div class="clear"></div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc2w2" style="display:none;">
                        <h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
                    </div>
		            <div class="txtfield">
					  <div id="c2week2" style="display:none;">
					    <div class="tmSlot">
                        <input type="checkbox" id="c2-w2-0" value="MonC2W2" class="days" <?php if(isset($week2[1][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
						<select id="ts-avail-c2-w2-0" name="cycle2[week2][0][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week2[1][0]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c2-w2-1" value="TueC2W2" class="days" <?php if(isset($week2[1][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
						<select id="ts-avail-c2-w2-1" name="cycle2[week2][1][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week2[1][1]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c2-w2-2" value="WedC2W2" class="days" <?php if(isset($week2[1][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
						 <select id="ts-avail-c2-w2-2" name="cycle2[week2][2][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week2[1][2]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c2-w2-3" value="ThuC2W2" class="days" <?php if(isset($week2[1][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
						 <select id="ts-avail-c2-w2-3" name="cycle2[week2][3][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week2[1][3]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c2-w2-4" value="FriC2W2" class="days" <?php if(isset($week2[1][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
						 <select id="ts-avail-c2-w2-4" name="cycle2[week2][4][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week2[1][4]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c2-w2-5" value="SatC2W2" class="days" <?php if(isset($week2[1][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
						 <select id="ts-avail-c2-w2-5" name="cycle2[week2][5][]" class="slctTs required" multiple="multiple">
                        <?php $options = $objP->getTimeslotOptions($week2[1][5]);echo $options;?>
                        </select>
						</div>
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
					 <div class="clear"></div>
					
					<div id="thirdCycle" style="display:none;border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
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
						</div>
						<div class="clear"></div>
						<div class="custtd_left">
							<h2>Occurring<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<select id="c1chWeek1" name="c1chWeek3" class="select required" onchange="showCycleDetailsthree(this.value);">
								<option value="">--Select Week--</option>
								<option value="1w" <?php if(isset($occurrence['2']) && $occurrence['2'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
								<option value="2w" <?php if(isset($occurrence['2']) && $occurrence['2'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
							</select>
						</div>
						<div class="clear"></div>
						<div class="custtd_left" id="custtd_leftc3w1" style="display:none;">
							<h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
						</div>					
						<div class="txtfield">
						  <div id="c3week1" style="display:none;">
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-0" value="MonC3W1" class="days" <?php if(isset($week1[2][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
							<select id="ts-avail-c3-w1-0" name="cycle3[week1][0][]" class="slctTs required" multiple="multiple">
								<?php $options = $objP->getTimeslotOptions($week1[2][0]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-1" value="TueC3W1" class="days" <?php if(isset($week1[2][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
							<select id="ts-avail-c3-w1-1" name="cycle3[week1][1][]" class="slctTs required" multiple="multiple">
							   <?php $options = $objP->getTimeslotOptions($week1[2][1]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-2" value="WedC3W1" class="days" <?php if(isset($week1[2][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
							 <select id="ts-avail-c3-w1-2" name="cycle3[week1][2][]" class="slctTs required" multiple="multiple">
							  <?php $options = $objP->getTimeslotOptions($week1[2][2]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-3" value="ThuC3W1" class="days" <?php if(isset($week1[2][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
							 <select id="ts-avail-c3-w1-3" name="cycle3[week1][3][]" class="slctTs required" multiple="multiple">
							  <?php $options = $objP->getTimeslotOptions($week1[2][3]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-4" value="FriC3W1" class="days" <?php if(isset($week1[2][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
							 <select id="ts-avail-c3-w1-4" name="cycle3[week1][4][]" class="slctTs required" multiple="multiple">
								<?php $options = $objP->getTimeslotOptions($week1[2][4]);echo $options;?>
							</select>
							</div>
							<div class="tmSlot">
							<input type="checkbox" id="c3-w1-5" value="SatC3W1" class="days" <?php if(isset($week1[2][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
							 <select id="ts-avail-c3-w1-5" name="cycle3[week1][5][]" class="slctTs required" multiple="multiple">
							  <?php $options = $objP->getTimeslotOptions($week1[2][5]);echo $options;?>
							</select>
							</div>
						  </div>	
						</div>
					<div class="clear"></div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc3w2" style="display:none;">
                        <h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
                    </div>
		            <div class="txtfield">
					  <div id="c3week2" style="display:none;">
					    <div class="tmSlot">
                        <input type="checkbox" id="c3-w2-0" value="MonC3W2" class="days" <?php if(isset($week2[2][0])) echo 'checked';?>/><span class="dayName"> Mon </span>
						<select id="ts-avail-c3-w2-0" name="cycle3[week2][0][]" class="slctTs required" multiple="multiple">
							<?php $options = $objP->getTimeslotOptions($week2[2][0]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c3-w2-1" value="TueC3W2" class="days" <?php if(isset($week2[2][1])) echo 'checked';?>/><span class="dayName"> Tue </span>
						<select id="ts-avail-c3-w2-1" name="cycle3[week2][1][]" class="slctTs required" multiple="multiple">
                           <?php $options = $objP->getTimeslotOptions($week2[2][1]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c3-w2-2" value="WedC3W2" class="days" <?php if(isset($week2[2][2])) echo 'checked';?>/><span class="dayName"> Wed </span>
						 <select id="ts-avail-c3-w2-2" name="cycle3[week2][2][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week2[2][2]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c3-w2-3" value="ThuC3W2" class="days" <?php if(isset($week2[2][3])) echo 'checked';?>/><span class="dayName"> Thu </span>
						 <select id="ts-avail-c3-w2-3" name="cycle3[week2][3][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week2[2][3]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c3-w2-4" value="FriC3W2" class="days" <?php if(isset($week2[2][4])) echo 'checked';?>/><span class="dayName"> Fri </span>
						 <select id="ts-avail-c3-w2-4" name="cycle3[week2][4][]" class="slctTs required" multiple="multiple">
                          <?php $options = $objP->getTimeslotOptions($week2[2][4]);echo $options;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="c3-w2-5" value="SatC3W2" class="days" <?php if(isset($week2[2][5])) echo 'checked';?>/><span class="dayName"> Sat </span>
						 <select id="ts-avail-c3-w2-5" name="cycle3[week2][5][]" class="slctTs required" multiple="multiple">
                         <?php $options = $objP->getTimeslotOptions($week2[2][5]);echo $options;?>
                        </select>
						</div>
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
						<div class="clear"></div>
					</div>
                    <div class="clear"></div>
					
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
<script>
$(document).ready(function(){
	<?php if(isset($occurrence['0'])){?>
		showCycleDetails('<?php echo $occurrence['0'];?>');
	<?php }if(isset($occurrence['1'])){?>
		showCycleDetailstwo('<?php echo $occurrence['1'];?>');
	<?php }if(isset($occurrence['2'])){?>
		showCycleDetailsthree('<?php echo $occurrence['2'];?>');
	<?php } ?>
});
</script>
<?php include('footer.php'); ?>

