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
					<div class="custtd_left red">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" required="true" id="txtAName" maxlength="50" name="txtAName" value="<?php echo $name; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" required="true" id="fromGenrtTmtbl" name="fromGenrtTmtbl" size="13" value="<?php echo $fromGenrtTmtbl; ?>">
                        To:<input type="text" required="true" id="toGenrtTmtbl" name="toGenrtTmtbl" size="12" value="<?php echo $toGenrtTmtbl; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnGenrtTimetbl" class="buttonsub" value="Generate Timetable">
                    </div>
                    <div class="txtfield">
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
