<?php 
include('header.php'); 
require_once('config.php');
global $db;
$subjectName=""; $subjectCode=""; $sessionNum=""; $subjectCode="";$caseNum=""; $technicalNotes="";
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$subjectId = base64_decode($_GET['edit']);
	echo $subjectId;
	$obj = new Subjects();
	$result = $obj->getDataBySubjectID($subjectId);
	$row = $result->fetch_assoc();
}
$subjectName = isset($_GET['edit']) ? $row['subject_name'] : (isset($_POST['txtSubjName'])? $_POST['txtSubjName']:'');
$subjectCode = isset($_GET['edit']) ? $row['subject_code'] : (isset($_POST['txtSubjCode'])? $_POST['txtSubjCode']:'');
//$areaName = isset($_GET['edit']) ? $row['subject_name'] : (isset($_POST['txtSubjName'])? $_POST['txtSubjName']:'');
//$programName = isset($_GET['edit']) ? $row['subject_code'] : (isset($_POST['txtAreaCode'])? $_POST['txtSubjCode']:'');
$sessionNum = isset($_GET['edit']) ? $row['session_no.'] : (isset($_POST['txtSessionNum'])? $_POST['txtSessionNum']:'');
$caseNum = isset($_GET['edit']) ? $row['case_no.'] : (isset($_POST['txtCaseNum'])? $_POST['txtCaseNum']:'');
$technicalNotes = isset($_GET['edit']) ? $row['technical_notes'] : (isset($_POST['txtTechNotes'])? $_POST['txtTechNotes']:'');
//$roomType = isset($_GET['edit']) ? $row['room_id'] : (isset($_POST['slctClsType'])? $_POST['slctClsType']:'');
//$roomName = isset($_GET['edit']) ? $row['subject_name'] : (isset($_POST['slctRoom'])? $_POST['slctRoom']:'');
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Subject</div>
            <form name="subjectForm" id="subjectForm" action="postdata.php" method="post">
			<input type="hidden" name="form_action" value="addEditSubject" />
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
					         <?php 
					          $area_qry="select * from area";
					          $area_result= mysqli_query($db, $area_qry);
					          while ($area_data = mysqli_fetch_assoc($area_result)){?>
					          <option value="<?php echo $area_data['area_code']?>"><?php echo $area_data['area_name'];?></option>
					     <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required">
                            <option value="" selected="selected">--Select Program--</option>
                             <?php 
					          $program_qry="select * from  program";
					          $program_result= mysqli_query($db, $program_qry);
					          while ($program_data = mysqli_fetch_assoc($program_result)){?>
					          <option value="<?php echo $program_data['program_name']?>"><?php echo $program_data['program_name'];?></option>
					     	 <?php } ?>
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
                        <select id="slctClsType" name="slctClsType[]"  class="selectMultiple"  multiple="multiple" >
                              <?php 
					          $room_type_qry="select * from  room_type";
					          $room_type_result= mysqli_query($db, $room_type_qry);
					          while ($room_type_data = mysqli_fetch_assoc($room_type_result)){?>
					          <option value="<?php echo $room_type_data['id'].'#'.$room_type_data['room_type']?>"><?php echo $room_type_data['room_type'];?></option>
					     	 <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Choose Room</h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctRoom" name="slctRoom[]"  class="selectMultiple"  multiple="multiple">
						    
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
