<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">User Management</div>
            <form action="" method="post">
                <div class="custtable_left">
                    <div class="custtd_left ">
                        <h2>Username<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtUname" maxlength="50" name="txtUname">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Password <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtPwd" maxlength="50" name="txtPwd">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Email <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtEmail" maxlength="50" name="txtEmail">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Roles<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctRole" name="slctRole" class="select1">
                            <option value="" selected="selected">--Select Roles--</option>
                            <option value="XYZ">XYZ</option>
                        </select>
                    </div>
                    <div class="txtfield">
                        <a href="roles_management.php" id="addNewRole" name="addNewRole">Add New Role</a>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAddUser" class="buttonsub" value="Add User">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
