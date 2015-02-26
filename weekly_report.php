<?php include('header.php');
	$fromGenrtWR=isset($_SESSION['from']) ? $_SESSION['from'] : "";
	$toGenrtWR=isset($_SESSION['to']) ? $_SESSION['to'] : "";
	unset($_SESSION['from']);unset($_SESSION['to']);
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Generate Weekly Report</div>
            <form action="postdata_import.php" method="post" id="weekly_report" name="weekly_report" >
			<input type="hidden" value="generateWeeklyReport" name="form_action">
				<div class="custtable_left">
					<div class="red" style="padding-bottom:10px;">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2><strong>Week Interval</strong><span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" required="true" id="fromGenrtWR" name="fromGenrtWR" size="13" value="<?php echo $fromGenrtWR; ?>">
                        To:<input type="text" required="true" id="toGenrtWR" name="toGenrtWR" size="12" value="<?php echo $toGenrtWR; ?>">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield" style="padding-left:41px; padding-top:10px;">
                        <input type="submit" name="btnGenrtWR" class="buttonsub btnGenertTimetbl" value="Generate Weekly Report">
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
