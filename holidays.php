<?php include('header.php'); 
$user = getPermissions('holidays');
$holiday_reason=""; $holidayId=""; $holiday_date="";
$obj = new Holidays();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	if($user['edit'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
	$holidayId = base64_decode($_GET['edit']);
	$result = $obj->getDataByHolidayID($holidayId);
	$row = $result->fetch_assoc();
}else{
	if($user['add_role'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
}
$holiday_date = isset($_GET['edit']) ? $row['holiday_date'] : (isset($_POST['holiday_date'])? $obj->cleanText($_POST['holiday_date']):'');
$holiday_reason = isset($_GET['edit']) ? $row['holiday_reason'] : (isset($_POST['holiday_reason'])? $obj->cleanText($_POST['holiday_reason']):'');
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Holiday</div>
            <form name="holidays" id="holidays" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditHoliday" />
				<input type="hidden" name="holidayId" value="<?php echo $holidayId; ?>" />
                <div class="custtable_left">
                    <div class="custtd_left red">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Holiday Date<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input class="required" type="text" id="holiday_date" name="holiday_date" size="12" value="<?php echo $holiday_date; ?>" readonly />
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Holiday Reason</h2>
                    </div>
                    <div class="txtfield">
						<textarea class="inp_txt alphanumeric" id="holiday_reason" rows="30" cols="10" maxlength="50" name="holiday_reason"><?php echo $holiday_reason; ?></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddBuild" class="buttonsub" value="<?php echo $buttonName = ($holiday_date!="") ? "Update Holiday":"Add Holiday" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'holidays_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

