<?php include('header.php');
$user = getPermissions('Roles');
$roleName=""; $role_id="";
$obj = new Users();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	if($user['edit'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';

	}
	$role_id = base64_decode($_GET['edit']);
	$result = $obj->getDataByRoleID($role_id);
	$row = $result->fetch_assoc();
}else{
	if($user['add_role'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';

	}
}
$roleName = isset($_GET['edit']) ? $row['name'] : (isset($_POST['txtRname'])? $obj->cleanText($_POST['txtRname']):'');
$buttonName = (isset($_GET['edit']) && $_GET['edit']!="") ? "Update":"Save";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Role Name</div>
            <form name="roleAdd" id="roleAdd" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditRole" />
				<input type="hidden" name="role_id" value="<?php echo $role_id; ?>" />
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
                        <input type="text" class="inp_txt required" id="txtRname" maxlength="50" name="txtRname" value="<?php echo $roleName; ?>">
                    </div>
                    <div class="clear"></div>					                    
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddRole" class="buttonsub" value="<?php echo $buttonName;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'role_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

