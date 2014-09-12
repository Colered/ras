<?php
include('header.php');
$objP = new Programs();
$objS = new Subjects();
$objT = new Teacher();

$rel_teacher = $objT->getTeachers();
$rel_prog = $objP->getProgramListYearWise();
$rel_subject = $objS->getSubjects();

?>

<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher Activity</div>
			<form name="frmTactivity" id="frmTactivity" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="edit_teacher_activity" />
			  <?php if(isset($_GET['edit'])){?>
					<input type="hidden" name="form_edit_id" value="<?php echo $_GET['edit'];?>" />
			  <?php } ?>
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program:</h2>
                    </div>
                    <div class="txtfield">
					   program name
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject</h2>
                    </div>
                    <div class="txtfield">
					  Subject name
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
						<h2>Session:</h2>
					</div>
					<div class="txtfield">
                       Session name
					</div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Teacher <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield" style="float:left">
                        <select id="slctTeacher" name="slctTeacher[]" class="selectMultiple" size="10" multiple="multiple" required="true">
                        <?php
							while($row = $rel_teacher->fetch_assoc()){
								echo '<option value="'.$row['id'].'">'.$row['teacher_name'].' ('.$row['email'].')</option>';
							}
						?>
                        </select>
                    </div>
                    <div style="float:left;padding:133px 0px 0px 20px;"><input class="buttonsub" type="button" value="Add" name="btnTeacherAct" id="btnTeacherAct"></div>
                    <div id="ajaxload_actDiv" style="padding-top:130px;float:right;display:none;"><img src="images/loading2.gif"  /><div class="wait-text">Please Wait...</div></div>
                    <div class="clear"></div>

					<div id="activityReset" style="display:none;padding-left:10px;"><input class="buttonsub" type="button" value="Reset" name="btnTeacherActReset" id="btnTeacherActReset" onclick="reset_reserved_flag();"></div>
                    <div id="activityAddMore"></div>
                    <div><br /><br /><br /><br /></div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="Edit Activity">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'teacher_activity_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

