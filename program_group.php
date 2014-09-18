<?php
include('header.php');
$objP = new Programs();
$rel_prog = $objP->getProgramListYearWise();
$groupRel = $objP->getGroupsList();
if(isset($_GET['edit']) && $_GET['edit']!=''){
    $programId = base64_decode($_GET['edit']);
    // set the value
    $button_save = 'Edit Group';
}else{
    // set the value
    $button_save = 'Add Group';
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Student Group</div>
            <form name="frmSgroup" id="frmSgroup" action="postdata.php" method="post">
			  <input type="hidden" name="form_action" value="add_edit_program_group" />
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required" onChange="showGroups(this.value);">
                        <option value="" selected="selected">--Select Program--</option>
                        <?php
							while($row = $rel_prog->fetch_assoc()){
							    $selectedProg = (isset($programId) && $programId==$row['id']) ? 'selected' : '';
								echo '<option value="'.$row['id'].'" '.$selectedProg.'>'.$row['name'].' '.$row['start_year'].' '.$row['end_year'].'</option>';
							}
                        ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Group Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctSgroups" name="slctSgroups[]" class="selectMultiple required" multiple="multiple">
						 <?php
							  while($row = $groupRel->fetch_assoc()){
							  		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						      }
						 ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddRoom" class="buttonsub" value="<?php echo $button_save;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='program_group_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php if(isset($programId) && $programId!=''){?>
	<script type="text/javascript">
		showGroups('<?php echo $programId;?>');
	</script>
<?php } ?>
<?php include('footer.php'); ?>