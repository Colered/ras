<?php include('header.php'); 
$subjectName=""; 
/*if(isset($_GET['edit']) && $_GET['edit']!=""){
	$areaId = base64_decode($_GET['edit']);
	$obj = new Areas();
	$result = $obj->getDataByAreaID($areaId);
	while ($data = $result->fetch_assoc()){
			$areaName = $data['area_name'];
			$areaCode = $data['area_code'];
			$areaColor = $data['area_color'];
	}
}*/
$hiddenVal = ($subjectName!="") ? "EditSubject":"Subject";
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Subject</div>
            <form name="subjectForm" id="subjectForm" action="postdata.php" method="post">
			<input type="hidden" name="form_action" value="<?php echo $hiddenVal; ?>" />
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Subject Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtSubjName" maxlength="50" name="txtSubjName" value="">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject Code <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Area <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctArea" name="slctArea" class="select1 required">
                            <option value="" selected="selected">--Select Area--</option>
                            <option value="Area1">Area1</option>
                            <option value="Area2">Area2</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required">
                            <option value="" selected="selected">--Select Program--</option>
                            <option value="MBA">MBA</option>
                            <option value="MCA">MCA</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Session No.<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtSessionNum" maxlength="50" name="txtSessionNum" value="">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Case No.<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtCaseNum" maxlength="50" name="txtCaseNum" value="">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Technical Notes<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <textarea style="height:40px;" class="inp_txt required" id="txtTechNotes" cols="20" rows="2" name="txtTechNotes"></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Addtional Information:-</h2>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Classroom Type</h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctClsType" name="slctClsType"  class="selectMultiple"  multiple >
                            <option value="Normal Class Room">Normal Class Room</option>
                            <option value="External Class Room">External Class Room</option>
                            <option value="Salitas">Salitas</option>
                            <option value="Hall">Hall</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Room</h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctRoom" name="slctRoom"  class="selectMultiple"  multiple >
                            <option value="Room1">Room1</option>
                            <option value="Room2">Room2</option>
                            <option value="Room3">Room3</option>
                            <option value="Room4">Room4</option>
                            <option value="Room5">Room5</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddSubject" class="buttonsub" value="Add Subject">
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
