<?php include('header.php'); 
$buldName=""; $buldId="";
$obj = new Buildings();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$buldId = base64_decode($_GET['edit']);
	$result = $obj->getDataByBuldID($buldId);
	$row = $result->fetch_assoc();
}
$buldName = isset($_GET['edit']) ? $row['building_name'] : (isset($_POST['txtBname'])? $obj->cleanText($_POST['txtBname']):'');
$is_default = isset($_GET['edit']) ? $row['is_default'] : (isset($_POST['is_default'])? $obj->cleanText($_POST['is_default']):'');
//$hiddenVal = ($buldName!="") ? "EditBuld":"Buld";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Building</div>
            <form name="buildings" id="buildings" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditBuild" />
				<input type="hidden" name="buldId" value="<?php echo $buldId; ?>" />
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
                        <input type="text" class="inp_txt required alphanumeric" id="txtBname" maxlength="50" name="txtBname" value="<?php echo $buldName; ?>">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Is Default<span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
						<select class="inp_txt required alphanumeric" name="is_default" id="is_default">
						<option value="0">No</option>
						<option value="1" <?php if($is_default=='1'){echo 'selected';} ?>>Yes</option>
						</select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddBuild" class="buttonsub" value="<?php echo $buttonName = ($buldName!="") ? "Update Building":"Add Building" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'buildings_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

