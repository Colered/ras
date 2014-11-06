<?php
include('header-main.php');
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){
	header('Location: timetable_dashboard.php');
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Login</div>
            <form action="postdata.php" method="post" autocomplete="off">
				<input type="hidden" name="form_action" value="Login" />
                <div class="custtable_left">
                    <img src="images/lock.jpg" id="lock-img" class="lock-img" />
                </div>
                <div class="custtable_left " >
					<div class="custtd_left error">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2 class="dotted-line">UserName<span class="redstar">*</span></h2>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1">
                        <input type="text" class="inp_txt alphanumeric" id="txtUName" maxlength="50" name="txtUName" autocomplete="off" >
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2 class="dotted-line">Password<span class="redstar">*</span></h2>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1">
                        <input type="password" class="inp_txt" id="txtPwd" maxlength="50" name="txtPwd" autocomplete="off" >
                    </div>
                    <div class="clear"></div>
					 <div class="txtfield1">
                       <a href="forgot.php">Forgot Password</a>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1">
                        <input type="submit" name="login" class="buttonsub" value="Login">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

