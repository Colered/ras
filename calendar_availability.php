<?php include('header.php'); 
$objTimeslot = new Timeslot();
$tslot_dropDwn = $objTimeslot->getTimeSlotStartDateDropDwnNew();
$tslot_dropDwnEnd = $objTimeslot->getTimeSlotEndDateDropDwn();
//echo "<pre>";
//print_r($_POST);
?>
<html>
<head>   
<link href="css/calendar.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
$user = getPermissions('program_cycles');
if($user['add_role'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$objP = new Programs();
$objTS = new Timeslot();
$programId = ''; $totcycle=0; $editPrevNumCycle = 0;
$objSpecialActivity  = new SpecialActivity();

//get the list of all available timeslots
$options = "";
$rel_prog = $objP->getProgramListYearWise();
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
	$totcycle = $objP->getCyclesInProgram($programId);
	if($totcycle!="" && $totcycle>0){ //means the program is not new
		$editPrevNumCycle = $totcycle;
		$result = $objP->getProgramById($programId);
		$row = $result->fetch_assoc();
		$resulty = $objP->getProgramByYearId($programId);
		$row1 = $resulty->fetch_assoc();
		$unitArr[]= explode(',',$row['unit']);
		//get all the cycles related to data
		$cycleData = $objP->getProgramCycleList($programId);
	
		while($data = $cycleData->fetch_assoc()){
		   $cycleIdsArr[]= $data['id'];
		   $start_week[] = $data['start_week'];
		   $end_week[] = $data['end_week'];
		   $occurrence[] = $data['occurrence'];
		   $week1[] = unserialize($data['week1']);
		   $week2[] = unserialize($data['week2']);
	
		}
	}else{
	//do nothinf
	
	}
}
$no_of_cycles = "";
if(isset($_POST['slctNumcycle']) && ($_POST['slctNumcycle'] !="")){
	$no_of_cycles = $_POST['slctNumcycle'];
}else{
	$no_of_cycles = $totcycle;
}
$areaColor = isset($_GET['edit']) ? (isset($row['area_color'])? $row['area_color'] :(isset($_POST['txtAColor']) ? $_POST['txtAColor'] : '')):'';
$cycleIdsArr = (!empty($cycleIdsArr) ? $cycleIdsArr : array());
$startweek_1 = isset($_GET['edit']) ? (isset($_POST['startweek1'])? $_POST['startweek1']: (isset($start_week[0])? $objP->formatDateByDate($start_week[0]):'')):'';
$startweek_2 = isset($_GET['edit']) ? (isset($_POST['startweek2'])? $_POST['startweek2']: (isset($start_week[1])? $objP->formatDateByDate($start_week[1]):'')):'';
$startweek_3 = isset($_GET['edit']) ? (isset($_POST['startweek3'])? $_POST['startweek3']: (isset($start_week[2])? $objP->formatDateByDate($start_week[2]):'')):'';
$endweek_1 = isset($_GET['edit']) ? (isset($_POST['endweek1'])? $_POST['endweek1']: (isset($end_week[0])? $objP->formatDateByDate($end_week[0]):'')):'';
$endweek_2 = isset($_GET['edit']) ? (isset($_POST['endweek2'])? $_POST['endweek2']: (isset($end_week[1])? $objP->formatDateByDate($end_week[1]):'')):'';
$endweek_3 = isset($_GET['edit']) ? (isset($_POST['endweek3'])? $_POST['endweek3']: (isset($end_week[2])? $objP->formatDateByDate($end_week[2]):'')):'';
?>
<style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
 </style>
<script type="text/javascript">
$(document).ready(function() {
    show_hide_cycle('<?php echo $no_of_cycles;?>');
	$(function () {
		$("#frmProgram").validate().settings.ignore = ':hidden';
	});
});
</script>
<script type="text/javascript">
  $(function() {
    var dialog, form,
      templatename = $( "#templatename" ),
      txtAColor = $( "#txtAColor" ),
      password = $( "#password" ),
      allFields = $( [] ).add( templatename ).add( txtAColor ).add( password ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addRule() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
      valid = valid && checkLength( templatename, "templatename", 1, 10000 );
      if ( valid ) {
        /*$( "#users" ).append( "<tr>" +
          "<td>" + templatename.val() + "</td>" +
          "<td>" + txtAColor.val() + "</td>" +
          "<td>" + txtAColor.val() + "</td>" +
        "</tr>" );*/
		$('#addingRule').submit();
        dialog.dialog( "close" );
     }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 500,
      width: 450,
      modal: true,
      buttons: {
        "Save": addRule,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        //form[ 0 ].reset();
		$('#addingRule')[0].reset();
		$('.simpleColorDisplay').css('background-color', '#FFFFFF');
        allFields.removeClass( "ui-state-error" );
      }
    });
 
   /* form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      //addRule();
	  $('#addingRule').submit();
    });
 */
    $( "#template" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
	
	$("#btnAddAvailabilityData").button().on( "click", function() {
      $('#btnAddAvailabilityData').attr('disabled', 'disabled');
	  $('#showSucc').show();
	  $('#frmProgram').submit();
    });
	
	
  });
  
</script>
<script type="text/javascript" src="js/jquery.simple-color.js"></script>
<script>
	$(document).ready(function(){
  		$(".simple_color").simpleColor();
	});
	//ravin
	$(document).ready(function(){
		$('.monthDay').click( function() {
			var sleID = $(this).attr('id');
			var selectedVal = "";
			var selected = $("input[type='radio'][name='ruleval']:checked");
			if (selected.length > 0) {
				selectedVal = selected.val();
				$selColor = selectedVal.split("-");
				//alert($selColor[1]);
				$oldColorCode = rgb2hex($('#'+sleID).css('background-color'));
				if(($selColor[1] == $oldColorCode) || ($selColor[0]==0)){
					$('#'+sleID).css('background-color', '#E5E5E5'); //SET THE BACKGROUND COLOR
					var assignColorId = sleID;
					$('.'+sleID).val(assignColorId);
					$('.'+sleID).removeAttr('checked');
				}else{
					$('.'+sleID).prop('checked', 'checked');
					$('#'+sleID).css('background-color', $selColor[1]); //SET THE BACKGROUND COLOR
					var assignColorId = sleID+'__'+$selColor[0];
					$('.'+sleID).val(assignColorId); //assign merged value to checkbox the formt is ruleid-list-cycleno-date
					
				}
			}else{
				alert('Please select a day template first.')
			}
			}
		);
	});
	
</script>
<div id="content">
    <div id="main">
        <div class="full_w">
		    <div class="h_title">Program Cycles</div>
			<form name="frmProgram" id="frmProgram" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="add_edit_cycles_using_cal" />
			  <?php if(isset($_GET['edit'])){?>
			  	<input type="hidden" name="programId" value="<?php echo $_GET['edit'];?>" />
				<input type="hidden" name="preNumCycle" value="<?php echo $editPrevNumCycle;?>" />
			  	<?php
			  	   $ct = 0;
			  	   foreach($cycleIdsArr as $val){
			  	      $ct++;
			  	      echo '<input type="hidden" name="preCycleId'.$ct.'" value="'.$val.'" />';
			  	   }
			    } ?>
                <div class="custtable_left">
					<div class="full_w green center" style="border:none;">
					<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);} ?>
					</div>
                    <div class="custtd_left red">
						<?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required" onChange="changeExceptionDataCal(this.value);">
						<option value="" selected="selected">--Select Program--</option>
						<?php
							while($row = $rel_prog->fetch_assoc()){
								//echo '<option value="'.$row['id'].'">'.$row['name'].' '.$row['start_year'].' '.$row['end_year'].'</option>';
								echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
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
                        <select id="slctNumCycle" onChange="resetcycles();" name="slctNumcycle" class="select required" <?php if(count($cycleIdsArr)>0){ echo "readonly"; }?>>
                            <option value="">--Select Cycles--</option>
                            <option value="1" <?php if($no_of_cycles==1){echo 'selected';} ?>>1 </option>
                            <option value="2" <?php if($no_of_cycles==2){echo 'selected';} ?>>2 </option>
                            <option value="3" <?php if($no_of_cycles==3){echo 'selected';} ?>>3 </option>
                        </select>
						<?php /*?><script type="text/javascript">
							jQuery('#slctNumCycle').val("<?php echo $no_of_cycles;?>");
						</script><?php */?>
                    </div>
                    <div class="clear"></div>
                    <div id="firstCycle" style="display:none; margin-bottom:10px;">
						<div class="custtd_left">
							<h2>1st cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek1" name="startweek1" value="<?php echo $startweek_1;?>" class="required" readonly />
							</div>
							<div class="cylcebox" style="margin-left:60px;">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek1" name="endweek1" value="<?php echo $endweek_1;?>" class="required" readonly />
							</div>
						</div>
					</div>
						<div class="clear"></div>
					<div id="secondCycle" style="display:none; margin-bottom:10px;">
						<div class="custtd_left">
							<h2>2nd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek2" name="startweek2" value="<?php echo $startweek_2;?>" class="required" readonly />
							</div>
							<div class="cylcebox" style="margin-left:60px;">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek2" name="endweek2" value="<?php echo $endweek_2;?>" class="required" readonly />
							</div>
						</div>
					</div>
						<div class="clear"></div>
					<div id="thirdCycle" style="display:none; margin-bottom:10px;">
						<div class="custtd_left">
							<h2>3rd cycle<span class="redstar">*</span></h2>
						</div>
						<div class="txtfield">
							<div class="cylcebox">
							<h3>Start Date</h3>
							<input type="text" size="14" id="startweek3" name="startweek3" value="<?php echo $startweek_3;?>" class="required" readonly />
							</div>
							<div class="cylcebox" style="margin-left:60px;">
								<h3>End Date</h3>
								<input type="text" size="14" id="endweek3" name="endweek3" value="<?php echo $endweek_3;?>" class="required" readonly />
							</div>
						</div>
						</div>
                    <div class="clear"></div>
					</div>
			 </div>
    <div class="clear"></div>
	<!-- code starts for day template manage -->
	<?php 
	$result = $objSpecialActivity->getAllDayTemplate();
	?>
		 <div class="full_w">
		    <div class="h_title">Select a day template OR
			<div class="txtfield" style="float:right">
				<input style="color:#FFFFFF; float:right; margin-top:-7px; margin-right:10px; float:right" type="button" name="" id="template" class="buttonsub" value="Add new day template" onClick="return checkweekTS()">
			</div>
			</div>
			<ul id="rules" class="rule">
<table width="1200" border="1">
<tbody>
	
	<tr>
		<td class="sched-data">
			<div style="word-wrap: break-word; overflow-y: scroll; height: 140px;">
				<li style="min-height:20px;" class="main-title"><input style="width:28px; height:20px; cursor:pointer; float:left" type="radio" name="ruleval" value="0-#E5E5E5"><b>Clear Day</b>
				<span style="background-color:#E5E5E5; width:100px;"></span>
				</li>
			</div>
		</td>
	<?php
	$i = 1;
	while($rowTemplate = $result->fetch_assoc()){
		if(($i % 6)==0){
			echo '<tr>';
		}	?>						
		<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;">
				<li style="min-height:20px;" class="main-title"><input style="width:28px; height:20px; cursor:pointer; float:left" type="radio" name="ruleval" value="<?php echo $rowTemplate['id'].'-'.$rowTemplate['color_identifier_code']; ?>"><b><?php echo $rowTemplate['template_name']; ?></b>
				<span style="background-color:<?php echo $rowTemplate['color_identifier_code']; ?>; width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onClick="deleteAvailTemplate(<?php echo $rowTemplate['id'];  ?>, '<?php echo $_GET['edit'];?>');" src="images/delete-rule.png"></span>
				</li>
				<?php
				$resultUsages = $objSpecialActivity->getAllDayTempTSUsages($rowTemplate['id']);
				while($rowUsages = $resultUsages->fetch_assoc()){
				?>
				<ul class="listing">
						<li><span><?php echo $rowUsages['sch_start_time']; ?> - <?php echo $rowUsages['sch_end_time']; ?></span>&nbsp;:&nbsp;<?php echo $rowUsages['usage_name'] ;?></li>
				</ul>
				<?php } ?>
				</div>
		</td>
		<?php
		$i++;	
		if(($i % 6)==0){
			echo '</tr>';
		}
	 } ?>
	</tr>
</tbody>
</table>
	</ul>
			
			
			<!--<div id="users">
				no template found
			</div>-->
		 </div>
    </div>
</div>
	<!--for first year-->
<?php
	$calendarObj = new Calendar_Availability();
	//get the data of all availability through calendar for a program.
	$finalSelectedDay = $objP->getCalAvailabillityDatabyProgId($programId);
	if(isset($_GET['year']) && $_GET['year']!=''){
		$currentYear = $_GET['year'];
	}else{
		$currentYear =date("Y");
	}
	$cycleNo = 1;
	?>
	<div class="year-cal cycle1" id="cycle1" <?php if($startweek_1 == "" || $startweek_1 == ""){ echo "style='display:none;'"; }?>>
	<div class="navigation-div"><?php echo $calendarObj->_createNaviYear($currentYear, $cycleNo); ?> </div><br/>
	<?php
	$fsStartMonth = date("m", strtotime($startweek_1));
	$fsEndMonth = date("m", strtotime($endweek_1));
	$currentYear = date("Y", strtotime($startweek_1));
	$startYear = date("Y", strtotime($startweek_1));
	$endYear = date("Y", strtotime($endweek_1));
	$fsStartDay = date("d", strtotime($startweek_1));
	$fsEndDay = date("d", strtotime($endweek_1));
	$totalMonths = (($endYear - $currentYear) * 12) + ($fsEndMonth - $fsStartMonth);
	$endmonth = $fsStartMonth + $totalMonths;
	//get all holidays array
	$holidaysResult = array();
	$objHoliday = new Holidays();
	$holidaysResult = $objHoliday->getHolidaysDates();
	$k = 1;
	for($i=$fsStartMonth; $i<=$endmonth; $i++){
		$calendar = new Calendar_Availability();
		$month = (($i % 12) == 0)? 12 : ($i%12);
		echo $calendar->show($month, $currentYear, $cycleNo, $fsStartDay, $fsEndDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult);
		$currentYear = (($i % 12) == 0)?$currentYear + 1:$currentYear;
		if(($k % 6)==0){
			echo '<div class="clear"> </div>';
		}
		$k++;
	}
	?>
	</div>
	
	<!-- for second cycle -->
	<?php 
	$cycleNo = 2; ?>
	<div class="year-cal cycle2" id="cycle2" <?php if($startweek_2 == "" || $startweek_2 == ""){ echo "style='display:none;'"; }?>>
	<div class="navigation-div"><?php echo $calendarObj->_createNaviYear($currentYear, $cycleNo); ?> </div><br/>
	<?php
	$fsStartMonth = date("m", strtotime($startweek_2));
	$fsEndMonth = date("m", strtotime($endweek_2));
	$currentYear = date("Y", strtotime($startweek_2));
	$startYear = date("Y", strtotime($startweek_2));
	$endYear = date("Y", strtotime($endweek_2));
	$fsStartDay = date("d", strtotime($startweek_2));
	$fsEndDay = date("d", strtotime($endweek_2));
	$totalMonths = (($endYear - $currentYear) * 12) + ($fsEndMonth - $fsStartMonth);
	$endmonth = $fsStartMonth + $totalMonths;
	$k = 1;
	for($i=$fsStartMonth; $i<=$endmonth; $i++){
		$calendar = new Calendar_Availability();
		$month = (($i % 12) == 0)? 12 : ($i%12);
		echo $calendar->show($month, $currentYear, $cycleNo, $fsStartDay, $fsEndDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult);
		$currentYear = (($i % 12) == 0)?$currentYear + 1:$currentYear;
		if(($k % 6)==0){
			echo '<div class="clear"> </div>';
		}
		$k++;
	}
	?>
	</div>
	<!-- for third cycle -->
	<?php $cycleNo = 3; ?>
	<div class="year-cal cycle3" id="cycle3" <?php if($startweek_3 == "" || $startweek_3 == ""){ echo "style='display:none;'"; }?>>
	<div class="navigation-div"><?php echo $calendarObj->_createNaviYear($currentYear, $cycleNo); ?> </div><br/>
	<?php
	$fsStartMonth = date("m", strtotime($startweek_3));
	$fsEndMonth = date("m", strtotime($endweek_3));
	$currentYear = date("Y", strtotime($startweek_3));
	$startYear = date("Y", strtotime($startweek_3));
	$endYear = date("Y", strtotime($endweek_3));
	$fsStartDay = date("d", strtotime($startweek_3));
	$fsEndDay = date("d", strtotime($endweek_3));
	$totalMonths = (($endYear - $currentYear) * 12) + ($fsEndMonth - $fsStartMonth);
	$endmonth = $fsStartMonth + $totalMonths;
	$k = 1;
	for($i=$fsStartMonth; $i<=$endmonth; $i++){
		$calendar = new Calendar_Availability();
		$month = (($i % 12) == 0)? 12 : ($i%12);
		//$month = $i % 12;
		echo $calendar->show($month, $currentYear, $cycleNo, $fsStartDay, $fsEndDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult);
		$currentYear = (($i % 12) == 0)?$currentYear + 1:$currentYear;
		if(($k % 6)==0){
			echo '<div class="clear"> </div>';
		}
		$k++;
	}
	?>
	</div>
	<!--year cal ends-->
	<div class="clear"></div>
	<div class="custtd_left" style="width:585px;">
		<!--<h3><span class="redstar">*</span>All Fields are mandatory.</h3>-->
	</div>
	<div class="txtfield">
		<input type="button" style="color:#FFFFFF; float:left;" name="" id="btnAddAvailabilityData" class="buttonsub" value="Save">
		<div style="color:#006600; width:200px; padding-top:10px; display:none;" id="showSucc">Processing... please wait</div>
	</div>
	</form>
			 <!--form to fill in popup-->
		 <div id="dialog-form" title="Adding a New Day Schedule Template: ">
		 <form name="addingRule" id="addingRule" method="post" action="postdata.php">
		 	<input type="hidden" name="form_action" value="addCalAvailRule" />
			<input type="hidden" name="programId" value="<?php echo base64_encode($programId); ?>" />
			<input type="hidden" id="slctNumcycleCount" name="slctNumcycle" value="<?php echo $no_of_cycles;?>" />
			<input type="hidden" size="14" id="startweek1Post" name="startweek1" value="<?php echo $startweek_1;?>" />
			<input type="hidden" size="14" id="endweek1Post" name="endweek1" value="<?php echo $endweek_1;?>" />
			<input type="hidden" size="14" id="startweek2Post" name="startweek2" value="<?php echo $startweek_2;?>" />
			<input type="hidden" size="14" id="endweek2Post" name="endweek2" value="<?php echo $endweek_2;?>" />
			<input type="hidden" size="14" id="startweek3Post" name="startweek3" value="<?php echo $startweek_3;?>" />
			<input type="hidden" size="14" id="endweek3Post" name="endweek3" value="<?php echo $endweek_3;?>" />
							
			
			
			
			<fieldset>
			  <label for="name">Template Name</label>
			  		<input type="text" name="templatename" id="templatename" value="" class="text ui-widget-content ui-corner-all">
			  <label for="coloridentifier">Color Identifier</label>
   			  		<input class="simple_color" id="txtAColor" name="txtAColor" value="<?php echo $areaColor; ?>"/>
					<table width="200" border="1">
					  <tr>
						<th scope="col">Start Time</th>
						<th scope="col">End Time</th>
						<th scope="col">Usage</th>
					  </tr>
					  <?php 
					  $total = 15;
					  for($i=1; $i<=$total; $i++){ ?>
					  <tr>
						<td>
							<input type="hidden" name="totalTsOption" id="totalTsOption" value="<?php echo $total; ?>" />
							<select id="st_tslot_id<?php echo $i; ?>" name="st_tslot<?php echo $i; ?>" >
								<option value="">--Select--</option>
								<?php echo $tslot_dropDwn;?>
							 </select>
						</td>
						<td>
							<select id="end_tslot_id<?php echo $i; ?>" name="end_tslot_id<?php echo $i; ?>" >
								<option value="">--Select--</option>
								<?php echo $tslot_dropDwnEnd;?>
							 </select>
						</td>
						<td> 
							<select id="usage_id<?php echo $i; ?>"  name="usage_id<?php echo $i; ?>">
								<option value="">--Select--</option>
								<option value="Class">Class</option>
								<option value="Recess">Recess</option>
								<option value="Lunch">Lunch</option>
								<option value="Group-Meeting">Group Meeting</option>
							 </select>
						</td>
					  </tr>
					  <?php } ?>
					</table>
			  <!-- Allow form submission with keyboard without duplicating the dialog button -->
			  <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			</fieldset>
		</form>
	</div>
	<!-- ends code for day template manage -->
	<!--<div class="txtfield">
		<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onClick="location.href='program_cycles_view.php';">
	</div>-->
	
<?php include('footer.php'); ?>

