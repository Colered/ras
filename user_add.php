<?php include('header.php'); 
$userId="";
$objU=new Users();
$result = $objU->getUserType();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$userId = base64_decode($_GET['edit']);
	$result_detail = $objU->getDataByUserID($userId);
	$row = $result_detail->fetch_assoc();
}
$role_id = (isset($_GET['edit']) && $_GET['edit']!="") ? $row['role_id']:(isset($_POST['slctUserType'])? $_POST['slctUserType']:'') ;
$uname = (isset($_GET['edit']) && $_GET['edit']!="") ? $row['username']:(isset($_POST['txtUserName'])? $_POST['txtUserName']:'');
$pwd = (isset($_GET['edit']) && $_GET['edit']!="") ? base64_decode($row['password']):(isset($_POST['txtUserPwd'])?  base64_decode($_POST['txtUserPwd']):'');
$email = (isset($_GET['edit']) && $_GET['edit']!="") ? $row['email']:(isset($_POST['txtUserEmail'])? $_POST['txtUserEmail']:'');
$button = (isset($_GET['edit']) && $_GET['edit']!="") ? "Update":"Save";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Add User</div>
            <form name="userMgmtForm" id="userMgmtForm" action="postdata.php" method="post">
			<input type="hidden" name="form_action" value="addEditUser" />
			<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
                <div class="custtable_left">
					<div class="custtd_left red">
						<?php if(isset($_SESSION['error_msg']))
							echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left ">
                        <h2>Username<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtUserName" name="txtUserName"  maxlength="50" value="<?php echo $uname;?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Password <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="password" class="inp_txt" id="txtUserPwd"  name="txtUserPwd" maxlength="50" value="<?php echo $pwd;?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Email <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtUserEmail" name="txtUserEmail" maxlength="50" value="<?php echo $email;?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>User Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					  <select id="slctUserType" name="slctUserType" class="select1">
						    <option value="" selected="selected">--Select Type--</option>
							<?php while($userDataType = $result->fetch_assoc()){
								$selected = $userDataType['id']==$role_id ?"selected":'';
							?>		
							<option value="<?php echo $userDataType['id'];?>" <?php echo $selected;?>><?php echo $userDataType['name'];?></option>
							<?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddUser" class="buttonsub" value="<?php echo $button;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'user_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
