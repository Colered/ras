<?php
include('header.php');
$objP = new Programs();
$objS = new Subjects();
$objT = new Teacher();

$rel_teacher = $objT->getTeachers();
$rel_prog = $objP->getProgramListData();
$rel_subject = $objS->getSubjects();

if(isset($_GET['edit']) && $_GET['edit']!=''){
    // set the value
    $button_save = 'Edit Activity';
    $form_action = 'edit_teacher_activity';
}else{
    $button_save = 'Add Activity';
    $form_action = 'add_teacher_activity';
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher Activity</div>
			<form name="frmTactivity" id="frmTactivity" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="<?php echo $form_action;?>" />
			  <?php if(isset($_GET['edit'])){?>
					<input type="hidden" name="form_edit_id" value="<?php echo $_GET['edit'];?>" />
			  <?php } ?>
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<select id="slctProgram" name="slctProgram" class="select1 required" onChange="showSubjects(this.value);">
					<option value="" selected="selected">--Select Program--</option>
					<?php
						while($row = $rel_prog->fetch_assoc()){
							echo '<option value="'.$row['id'].'">'.$row['program_name'].'</option>';
						}
					?>
					</select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<select id="slctSubject" name="slctSubject" class="select1 required" onChange="showSessions(this.value);">
					<option value="" selected="selected">--Select Subject--</option>
					 <?php
						while($row = $rel_subject->fetch_assoc()){
							echo '<option value="'.$row['id'].'">'.$row['subject_name'].'</option>';
						}
					 ?>
					</select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
						<h2>Session</h2>
					</div>
					<div class="txtfield">
					<select id="slctSession" name="slctSession" class="select1">
					<option value="" selected="selected">--Select Session--</option>

					</select>
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
                    <!--<div style="float:left;padding:133px 0px 0px 20px;"><input class="buttonsub" type="button" value="Add" name="btnTeacherAct" id="btnTeacherAct"></div>-->
                    <div class="clear"></div>
                    <div id="activityAddMore"></div>
                    <div><br /><br /><br /><br /></div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="<?php echo $button_save;?>">
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

