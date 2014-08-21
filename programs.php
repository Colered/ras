<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Program</div>
            <form action="" method="post" class="form-align">
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtPrgmName" maxlength="50" name="txtPrgmName">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Type <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctPrgmType" name="slctPrgmType" class="select1">
                            <option value="" selected="selected">--Select Program--</option>
                            <option value="1 Year Program">1 Year Program</option>
                            <option value="2 Year Program">2 Year Program</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Program Duration <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromPrgm" />
                        To:<input type="text" size="12" id="toPrgm" />
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>No. of Cycle<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctNumCycle" name="slctNumcycle" class="select1">
                            <option value="" selected="selected">--Select Cycles--</option>
                            <option value="1">1 </option>
                            <option value="2">2 </option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2> <input type="checkbox" id="cycle1" name="cycle1"  /> 1st cycle<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <div class="cylcebox">
                            <h3>Start Week</h3>
                            <select id="years" name="years" class="select">
                                <option value="" selected="selected">--Select Week--</option>
                                <option value="week1">week1</option>
                                <option value="week2">week1</option>
                                <option value="week3">week3</option>
                                <option value="week4">week4</option>
                            </select>
                        </div>
                        <div class="cylcebox">
                            <h3>End Week</h3>
                            <select id="month" name="month" class="select">
                                <option value="" selected="selected">--Select Week--</option>
                                <option value="week1">week1</option>
                                <option value="week2">week1</option>
                                <option value="week3">week3</option>
                                <option value="week4">week4</option>
                            </select>
                        </div>
                        <div class="cylcebox">
                            <h3>Days</h3>
                            <select id="slctDays" name="slctDays" class="ts-avail" multiple="multiple">
                                <option value="Mon">Mon</option>
                                <option value="Tue">Tue</option>
                                <option value="Wed">Wed</option>
                                <option value="Thu">Thu</option>
                                <option value="Fri">Fri</option>
                                <option value="Sat">Sat</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2> <input type="checkbox" id="cycle1" name="cycle1"  /> 2nd cycle<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <div class="cylcebox">
                            <h3>Start Week</h3>
                            <select id="years" name="years" class="select">
                                <option value="" selected="selected">--Select Week--</option>
                                <option value="week1">week1</option>
                                <option value="week2">week1</option>
                                <option value="week3">week3</option>
                                <option value="week4">week4</option>
                            </select>
                        </div>
                        <div class="cylcebox">
                            <h3>End Week</h3>
                            <select id="month" name="month" class="select">
                                <option value="" selected="selected">--Select Week--</option>
                                <option value="week1">week1</option>
                                <option value="week2">week1</option>
                                <option value="week3">week3</option>
                                <option value="week4">week4</option>
                            </select>
                        </div>
                        <div class="cylcebox">
                            <h3>Days</h3>
                            <select id="slctDays" name="slctDays" class="ts-avail" multiple="multiple">
                                <option value="Mon">Mon</option>
                                <option value="Tue">Tue</option>
                                <option value="Wed">Wed</option>
                                <option value="Thu">Thu</option>
                                <option value="Fri">Fri</option>
                                <option value="Sat">Sat</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAddProgram" class="buttonsub" value="Add Program">
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

