<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Generate Timetable</div>
            <form action="" method="post">
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtAName" maxlength="50" name="txtAName">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" id="fromGenrtTmtbl" name="fromGenrtTmtbl" size="13">
                        To:<input type="text" id="toGenrtTmtbl" name="toGenrtTmtbl" size="12">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnGenrtTimetbl" class="buttonsub" value="Generate Timetable">
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
