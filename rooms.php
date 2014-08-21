<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Classroom</div>
            <form action="" method="post">
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Room Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctRmType" name="slctRmType" class="select1">
                            <option value="" selected="selected">--Select Type--</option>
                            <option value="HA">HA</option>
                            <option value="PA">PA</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtRmName" maxlength="50" name="txtRmName">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Building<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctBuilding" name="slctBuilding" class="select1">
                            <option value="" selected="selected">--Select Building--</option>
                            <option value="XYZ">XYZ</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3>
                            <span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAddRoom" class="buttonsub" value="Add Room">
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

