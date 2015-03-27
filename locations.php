<?php include('header.php');
$user = getPermissions('locations');
$locName=""; $locId="";
$obj = new locations();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	if($user['edit'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';

	}
	$locId = base64_decode($_GET['edit']);
	$result = $obj->getDataByLocID($locId);
	$row = $result->fetch_assoc();
}else{
	if($user['add_role'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';

	}
}
$locName = isset($_GET['edit']) ? $row['name'] : (isset($_POST['txtLname'])? $obj->cleanText($_POST['txtLname']):'');
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Location</div>
            <form name="locations" id="locations" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditLoc" />
				<input type="hidden" name="locId" value="<?php echo $locId; ?>" />
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
                        <input type="text" class="inp_txt required" id="txtLname" maxlength="50" name="txtLname" value="<?php echo $locName; ?>">
                    </div>
                    <div class="clear"></div>					                    
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddLoc" class="buttonsub" value="<?php echo $buttonName = ($locName!="") ? "Update Location":"Add Location" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'locations_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

