<?php include('header.php'); 
$areaName=""; $areaCode=""; $areaColor=""; $areaId="";
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$areaId = base64_decode($_GET['edit']);
	$obj = new Areas();
	$result = $obj->getDataByAreaID($areaId);
	while ($data = $result->fetch_assoc()){
			$areaName = $data['area_name'];
			$areaCode = $data['area_code'];
			$areaColor = $data['area_color'];
	}
}
$hiddenVal = ($areaName!="") ? "EditArea":"Area";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Area</div>
            <form action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="<?php echo $hiddenVal; ?>" />
				<input type="hidden" name="areaId" value="<?php echo $areaId; ?>" />
                <div class="custtable_left">
                    <div class="custtd_left red">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Area Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtAreaName" maxlength="50" name="txtAreaName" value="<?php echo $areaName; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Area Code<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtAreaCode" maxlength="50" name="txtAreaCode" value="<?php echo $areaCode; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Area Color<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="color"  class="colorArea" id="txtAColor" name="txtAColor" value="<?php echo $areaColor; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="addArea" class="buttonsub" value="<?php echo $buttonName = ($areaName!="") ? "Update Area":"Add Area" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'areas_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
