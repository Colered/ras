<?php include('header.php');
$name = isset($_GET['name']) ? $_GET['name'] : '';
$fromGenrtTmtbl = isset($_GET['fromGenrtTmtbl']) ? $_GET['fromGenrtTmtbl'] : '';
$toGenrtTmtbl = isset($_GET['toGenrtTmtbl']) ? $_GET['toGenrtTmtbl'] : '';
?>
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
						<select id="programs" name="programs[]" class="slctTs required" multiple="multiple">
						<?php 
						$objP = new Programs();
						$result = $objP->getProgramWithCycle();
						while($row = $result->fetch_assoc()){
							?><option value="<?php echo $row['program_year_id'];?>"><?php echo $row['name'];?></option><?php
						}						
						?>                         
                        </select>
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
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
