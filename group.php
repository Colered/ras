<?php include('header.php'); 
$groupName=""; $groupId="";
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$groupId = base64_decode($_GET['edit']);
	$obj = new Groups();
	$result = $obj->getDataByGroupID($groupId);
	$row = $result->fetch_assoc();
}
$groupName = isset($_GET['edit']) ? $row['name'] : (isset($_POST['txtGname'])? $_POST['txtGname']:'');
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Student Groups</div>
            <form name="groups" id="groups" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditGroup" />
				<input type="hidden" name="groupId" value="<?php echo $groupId; ?>" />
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
                        <input type="text" class="inp_txt required" id="txtGname" maxlength="50" name="txtGname" value="<?php echo $groupName; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddGroup" class="buttonsub" value="<?php echo $buttonName = ($groupName!="") ? "Update Group":"Add Group" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'group_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

