<?php
include('header.php');
$obj=new Timetable();
$result=$obj->viewTimetable();
$daysArr = array('0'=>'Mon','1'=>'Tue','2'=>'Wed','3'=>'Thu','4'=>'Fri','5'=>'Sat','6'=>'Sun');

?>
<script src="js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#datatables').dataTable({
		"sPaginationType":"full_numbers",
		"aaSorting":[[0, "asc"]],
		"bJQueryUI":true
	});
})
</script>
<style type="text/css">
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content">
    <div id="main">
	<?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
        <div class="full_w">
            <div class="h_title">Timetable View</div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
						<th >Year</th>
						<th >Day</th>
						<th >Date</th>
						<th >Hours</th>
                        <th >Company</th>
                        <th >Program</th>
						<th >Subject</th>
						<th >Area</th>
						<th >Session</th>
                        <th >Teacher</th>
						<th >Applicant</th>
                        <th >Classroom</th>
                        <th >Activity</th>
					</tr>
                    </tr>
                </thead>
                <tbody>
                <?php
                     while ($data = $result->fetch_assoc()){
						 $day = date('w', strtotime($data['date']));
						 $final_day = $day - 1;
                         $ttYear=$obj->getTimetableYear($data['tt_id']);
						 $ttDetail=$ttYear->fetch_assoc();
                ?>
					<tr>
                        <td class="align-center"><?php echo $data['id']; ?></td>
						<td class="align-center"><?php echo $ttDetail['start_date'].' to '.$ttDetail['end_date'] ; ?></td>
						<td class="align-center"><?php echo $daysArr[$final_day];?></td>
						<td class="align-center"><?php echo $data['date']; ?></td>
						<td class="align-center"><?php echo $data['timeslot']; ?></td>
						<td class="align-center">
						   <?php
							$program_year=$obj->getProgramYear($data['program_year_id']);
							$programYearDeatil=$program_year->fetch_assoc();
							$program=$obj->gerProgram($programYearDeatil['program_id']);
							$programDeatil=$program->fetch_assoc();
							echo $programDeatil['company'];
							//echo "NA";
							?>
						</td>
						<td class="align-center"><?php echo $programDeatil['program_name']; ?></td>
						<td class="align-center">
							<?php
							$subject=$obj->getSubject($data['subject_id']);
							$subjectDeatil=$subject->fetch_assoc();
							echo $subjectDeatil['subject_name']; ?>
						</td>
						<td class="align-center">
							<?php
							$area=$obj->getArea($subjectDeatil['area_id']);
							$areaDeatil=$area->fetch_assoc();
							echo $areaDeatil['area_name'];?>
						</td>
						<td class="align-center">
							<?php
							$session=$obj->getSession($data['session_id']);
							$sessionDeatil=$session->fetch_assoc();
							echo $sessionDeatil['session_name'];
							?>
						</td>
						<td class="align-center">
							<?php
							$teacher=$obj->getTeacher($data['teacher_id']);
							$teacherDeatil=$teacher->fetch_assoc();
							echo $teacherDeatil['teacher_name'];
							?>
						</td>
						<td class="align-center"><?php echo "NA"; ?></td>
						<td class="align-center">
							<?php
							$room=$obj->getClassroom($data['room_id']);
							$roomDeatil=$room->fetch_assoc();
							echo $roomDeatil['room_name'];
							?>
						</td>
						<td class="align-center"><?php echo $obj->getFielldVal('teacher_activity','name','id',$data['activity_id']);?></td>
                    </tr>
					<?php }?>
                </tbody>
            </table>
			 <?php if(isset($_SESSION['error_msg'])){ ?>
				<div><span class="red"><?php echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
