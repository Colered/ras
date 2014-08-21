<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher</div>
            <form action="" method="post" >
                <div class="custtable_left" >
                    <div class="custtd_left">
                        <h2>Professor Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtPname" maxlength="50" name="txtPname">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Address<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <textarea style="height:40px;" class="inp_txt" id="txtAreaAddress" cols="20" rows="2" name="txtAreaAddress"></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Date of Birth<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" id="dob" size="12">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Joining Date<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" id="doj" size="12">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Gender<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="radio" name="sex" value="male" class="radiobutt">Male
                        <input type="radio" name="sex" value="female" class="radiobutt">Female
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Desigation</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtDegination" maxlength="20" name="txtDegination">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Qualification <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtQualification" maxlength="50" name="txtQualification">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Experience <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="years" name="years" class="select">
                            <option value="" selected="selected">--Select Years--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <select id="month" name="month" class="select">
                            <option value="" selected="selected">--Select Month--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
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
                        <h2>Username <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtUname" maxlength="50" name="txtUname">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAdd" class="buttonsub" value="Add Professor">
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

