<?php include('header.php');
$user = getPermissions('weekly_report');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
	$fromGenrtWR=isset($_SESSION['from']) ? $_SESSION['from'] : "";
	$toGenrtWR=isset($_SESSION['to']) ? $_SESSION['to'] : "";
	unset($_SESSION['from']);unset($_SESSION['to']);
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Generate Work Plan Report</div>
            <form action="postdata_import.php" method="post" id="workplan_report" name="workplan_report" >
			<input type="hidden" value="generateWorkPlanReport" name="form_action">
				<div class="custtable_left">
					<div class="red removeWKRErr">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
                                <h2><strong>Choose Program</strong><span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctProgram" name="slctProgram" class="select1 required">
                                    <option value="" selected="selected">--Select Program--</option>
                                    <?php
                                    $program_qry = "select * from program_years";
                                    $program_result = mysqli_query($db, $program_qry);
                                    while ($program_data = mysqli_fetch_assoc($program_result)) {
                                        $program_year_detail = $program_data['name'] . ' ' . $program_data['start_year'] . ' ' . $program_data['end_year'];
                                        ?>
                                        <option value="<?php echo $program_data['id']; ?>|<?php echo $program_data['name']; ?>" ><?php echo $program_data['name']; ?></option>
<?php } ?>
                                </select>
                            </div>
					<div class="clear"></div><br />
                    <div class="custtd_left">
                        <h2><strong>Choose Interval</strong><span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" required="true" id="fromGenrtWPR" name="fromGenrtWPR" size="13" value="<?php echo $fromGenrtWR; ?>">
                        To:<input type="text" required="true" id="toGenrtWPR" name="toGenrtWPR" size="12" value="<?php echo $toGenrtWR; ?>">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield" style="padding-left:41px; padding-top:10px;">
                        <input type="submit" name="btnGenrtWR" id="btnWKR" class="buttonsub btnGenertTimetbl" value="Generate Report">
                    </div>
                    <div class="txtfield" style="padding-top:10px;">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'work_plan_report.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
