<?php include('header.php'); 
$buldName=""; $buldId="";
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$buldId = base64_decode($_GET['edit']);
	$obj = new Buildings();
	$result = $obj->getDataByBuldID($buldId);
	while ($data = $result->fetch_assoc()){
			$buldName = $data['building_name'];
	}
}
$hiddenVal = ($buldName!="") ? "EditBuld":"Buld";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Building</div>
            <form action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="<?php echo $hiddenVal; ?>" />
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
                        <input type="text" class="inp_txt" id="txtBname" maxlength="50" name="txtBname" value="<?php echo $buldName; ?>">
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

