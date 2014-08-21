<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Area</div>
            <form action="" method="post">
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Area Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtAName" maxlength="50" name="txtAName">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Area Code<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtACode" maxlength="50" name="txtACode">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Area Color<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="color"  class="colorArea" id="txtAColor" name="txtAColor">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAddArea" class="buttonsub" value="Add Area">
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
