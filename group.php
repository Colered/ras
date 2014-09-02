<?php
include('header.php');
$objP = new Programs();
$result = $objP->getProgramListData();

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
			  <input type="hidden" name="form_action" value="add_edit_student_group" />
			  <?php if(isset($_GET['edit'])){?>
				<input type="hidden" name="form_edit_id" value="<?php echo $_GET['edit'];?>" />
			  <?php } ?>
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Program<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctProgram" name="slctProgram" class="select1 required">
                        <option value="" selected="selected">--Select Program--</option>
                        <?php
							while($row = $result->fetch_assoc()){
								echo '<option value="'.$row['id'].'">'.$row['program_name'].'</option>';
							}
                        ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Group Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtGrp" maxlength="50" name="txtGrp">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddRoom" class="buttonsub" value="<?php echo $button_save;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href='group_view.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

