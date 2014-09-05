<?php
include('header.php');
$objP = new Programs();
$objS = new Subjects();
$objT = new Teacher();
$rel_teacher = $objT->getTeachers();
$rel_prog = $objP->getProgramListData();
$rel_subject = $objS->getSubjects();

?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher Activity</div>
            <form action="" method="post">
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<select id="slctProgram" name="slctProgram" class="select1 required" onChange="showSubjects(this.value);">
					<option value="" selected="selected">--Select Program--</option>
					<?php
						while($row = $rel_prog->fetch_assoc()){
							$selectedProg = (isset($programId) && $programId==$row['id']) ? 'selected' : '';
							echo '<option value="'.$row['id'].'" '.$selectedProg.'>'.$row['program_name'].'</option>';
						}
					?>
					</select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Subject <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<select id="slctSubject" name="slctSubject" class="select1">
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
						<h2>Session<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
					<select id="slctProgram" name="slctProgram" class="select1 required" onChange="showSubjects(this.value);">
					<option value="" selected="selected">--Select Program--</option>
					<?php
						while($row = $rel_prog->fetch_assoc()){
							$selectedProg = (isset($programId) && $programId==$row['id']) ? 'selected' : '';
							echo '<option value="'.$row['id'].'" '.$selectedProg.'>'.$row['program_name'].'</option>';
						}
					?>
					</select>
					</div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Teacher <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctTeacher" name="slctTeacher" class="selectMultiple" size="10" multiple>
                        <?php
							while($row = $rel_teacher->fetch_assoc()){
								echo '<option value="'.$row['id'].'">'.$row['teacher_name'].'</option>';
							}
						?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAdd" class="buttonsub" value="Add Activity">
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

