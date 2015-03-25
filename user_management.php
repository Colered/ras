<?php include('header.php'); 
$userId="";
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
                        <input type="text" class="inp_txt" id="txtUserName" name="txtUserName"  maxlength="50">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Password <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="password" class="inp_txt" id="txtUserPwd"  name="txtUserPwd" maxlength="50">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Email <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtUserEmail" name="txtUserEmail" maxlength="50" >
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>User Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctUserType" name="slctUserType" class="select1">
						    <option value="" selected="selected">--Select Type--</option>
							<option value="2">Admin</option>
							<option value="3">Read Only</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddUser" class="buttonsub" value="Save">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'user_management_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
