<?php include('header.php');
$user = getPermissions('generate_timetable');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$timetable_id = base64_decode($_GET['edit']);
	$objTT = new Timetable();
	$rowTT = $objTT->createdTTData($timetable_id); 
}
$fromGenrtTmtbl = (isset($rowTT['start_date']) && $rowTT['start_date']!="") ? date('d-m-Y' , strtotime($rowTT['start_date'])) : '';
$toGenrtTmtbl = (isset($rowTT['end_date']) && $rowTT['end_date'] != "") ? date('d-m-Y' , strtotime($rowTT['end_date'])) : '';
$program_year_id = (isset($rowTT['programs']) && $rowTT['programs']!="") ? $rowTT['programs'] : '';
$prgm_IdArr = explode(',' ,$program_year_id);
?>
<script language="javascript" type="text/javascript">
		$(function() {
			$('#programs-left').dblclick(function() {
				var targetListmove=$('#programs-left option:selected');
				if(targetListmove.length >0){
					$('#programs-left option:selected').appendTo('#programs');
				}else{
					alert('Please select atleast one item to move');
				}
			  });
			$('#programs').dblclick(function() {
				var targetList=$('#programs option:selected');
				if(targetList.length >0){
					targetList.appendTo('#programs-left');
					var foption = $('#programs-left option:first');
					var soptions = $.makeArray($('#programs-left option:not(:first)')).sort(function(a, b) {
					 return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
					});
					$('#programs-left').html(soptions).prepend(foption);
					foption.attr("selected", true).siblings("option").removeAttr("selected");
				}else{
					alert('Please select atleast one item to move');
				}
			});
			
			$('.move-right').click(function(){
				var targetListmove=$('#programs-left option:selected');
				if(targetListmove.length >0){
					$('#programs-left option:selected').appendTo('#programs');
				}else{
					alert('Please select atleast one item to move');
				}
			});
			$('.move-left').click(function(){
				var targetList=$('#programs option:selected');
				if(targetList.length >0){
					targetList.appendTo('#programs-left');
					var foption = $('#programs-left option:first');
					var soptions = $.makeArray($('#programs-left option:not(:first)')).sort(function(a, b) {
					 return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
					});
					$('#programs-left').html(soptions).prepend(foption);
					foption.attr("selected", true).siblings("option").removeAttr("selected");
				}else{
					alert('Please select atleast one item to move');
				}
			});
			
			$('.my-button-up').click(function(){
				var current = $('#programs option:selected');
				if(current.length==1){
					current.prev().before(current);
				}else{
					alert('Please select only one item to move up');
				}
			});
			$('.my-button-down').click(function(){
				var current = $('#programs option:selected');
				if(current.length==1){
					current.next().after(current);
				}else{
					alert('Please select only one item to move down');
				}
			});
		});

</script>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Generate Timetable</div>
            <form action="postdata.php" method="post" name="timetable" id="timetable">
			<input type="hidden" value="generateTimetable" name="form_action">
				<div class="custtable_left">
					<div class="red" style="padding-bottom:10px;">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
                    
					<div class="custtd_left" style="display:none">
                        <h2>Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield" style="display:none">
                        <input type="text" class="inp_txt" required="true" id="txtAName" maxlength="50" name="txtAName" value="<?php echo 'Schedule-'.time(); ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2><strong>Time Interval</strong><span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" required="true" id="fromGenrtTmtbl" name="fromGenrtTmtbl" size="13" value="<?php echo $fromGenrtTmtbl; ?>">
                        To:<input type="text" required="true" id="toGenrtTmtbl" name="toGenrtTmtbl" size="12" value="<?php echo $toGenrtTmtbl; ?>">
                    </div>
                    <div class="clear"></div>
					 <div class="custtd_left">
                        <h2><strong>Choose Programs</strong><span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
						<h2 style="color: #5A5A5A; font-family: 'Tahoma'; font-size: 13px; line-height: 27px; margin-left:20px;"><strong>&nbsp;</strong><span class="redstar"></span></h2>
						<select id="programs-left" name="programs-left[]" class="slctTs" multiple="multiple" style="width:330px; height:200px; margin-left:29px;">
						<?php 
						$objP = new Programs();
						$result = $objP->getProgramWithCycle();
						while($row = $result->fetch_assoc()){
							 //$selected=(in_array($row['program_year_id'],$prgm_IdArr)) ? 'selected="selected"' : '' ;
							 if(!in_array($row['program_year_id'],$prgm_IdArr)){
							?><option value="<?php echo $row['program_year_id'];?>" <?php //echo $selected;?>><?php echo $row['name'];?></option><?php
								}	
						}					
						?>                         
                        </select>
					</div>
					<div class="txtfield" style="float:left; margin-top:92px;">
						<div class="move-right" style="cursor:pointer"><img src="images/arrow-right.png" /></div>
						<div class="move-left" style="cursor:pointer"><img src="images/arrow-left.png" /></div>
					</div>
					<div class="txtfield" style="float:left">
						<h2 style="color: #5A5A5A; font-family: 'Tahoma'; font-size: 13px; line-height: 27px;"><strong>Ordered list of program for timetable generation</strong><span class="redstar">*</span></h2>
						
						<?php 
						//$objP = new Programs(); $seletedIds =array();
						//$seletedDatas = $objP->getProgramWithCycleSelected();
						///$seletedData  =  $seletedDatas->fetch_assoc();
						//$seletedIds = explode(',', $seletedData['programs']);
						///$result = $objP->getProgramNameByCycleId($seletedData['programs']);
						?>
						<select id="programs" name="programs[]" class="slctTs" multiple="multiple" style="width:330px; height:200px;">
						<?php
						$objTimetable=new Timetable();
						$result=$objTimetable->getTimetablesData();
						while ($data = $result->fetch_assoc()){
									$program_names = $program_ids = array();
									$program_array = explode(",",$data['programs']);
									foreach($program_array as $program_id)
									{
										$programs = $objP->getProgramDataByPrgmYrID($program_id);
										$pgm_names = $programs->fetch_assoc();	
										$program_names[] = $pgm_names['name'];
										$program_ids[] = $program_id;
									}
						}
						for($i=0; $i<count($program_names); $i++){
							?><option value="<?php echo $program_ids[$i];?>" <?php //echo $selected;?>><?php echo $program_names[$i];?></option><?php
						}				
						?>                         
                        </select>
					</div>
					<div class="txtfield" style="float:left; margin-top:92px;">
						<div class="my-button-up" style="cursor:pointer"><img src="images/arrow-up.png" /></div>
						<div class="my-button-down" style="cursor:pointer"><img src="images/arrow-down.png" /></div>
					</div>
					<div class="txtfield" id="wait" style="display:none;width:450px;height:44px;position:initial;top:40%;left:50%;"><img src='images/bar-circle.gif' style="float:left" /><br><span style="float:left" ><strong>Grab a cup of coffee! ... this will take several minutes!...</strong></span></div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield" style="padding-left:41px; padding-top:10px;">
                        <input type="button" name="btnGenrtTimetbl" class="buttonsub btnGenertTimetbl" value="Generate Timetable">
                    </div>
                    <div class="txtfield" style="padding-top:10px;">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'timetable_dashboard.php';">
                    </div>
                </div>	
            </form>
			<div class="clear"></div>
			<div style="float:left">
			<div class="rule">
               <h2><strong>List Of Rules Being Followed By The System While Generating The Timetable.</strong></h2>
            </div>
			<ul class="rule-list">
			<li>
			<input type="checkbox" checked="checked" disabled="disabled" /> All the activities of a subject needs to be in same classroom for one week.
			</li>
			<li>
			<input type="checkbox" checked="checked" disabled="disabled" /> A teacher cannot have more than 4 sessions per day.
			</li>
			<li>
			<input type="checkbox" checked="checked" disabled="disabled" /> A teacher cannot have classes at different locations on the same day.
			</li>
			<li>
			<input type="checkbox" checked="checked" disabled="disabled" /> A teacher can have maximum two working saturdays per cycle.
			</li>
			<li>
			<input type="checkbox" checked="checked" disabled="disabled" /> All sessions scheduled on Saturday will be from same academic area.
			</li>
			</ul>
			</div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
