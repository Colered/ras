<?php
include('header.php');

if(isset($_GET['edit']) &&=='edit'){

    $result =  $db->query("select * from teacher where id='".base64_decode($_GET['id'])."'");
	$row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $button_save = 'Edit Professor';
}else{
    $button_save = 'Add Professor';
}

?>
<script type="text/javascript">
   $(document).ready(function() {
        $("#frmProff").submit(function(){

            if($.trim($("#txtPname").val())==""){
                alert('Please fill the professor name');
                $("#txtPname").focus();
                return false;
            }
			if($.trim($("#txtAreaAddress").val())==""){
				alert('Please fill the area address');
				$("#txtAreaAddress").focus();
				return false;
			}

            if($.trim($("#dob").val())==""){
                alert('Please fill the date of birth');
                $("#dob").focus();
                return false;
            }

            if($.trim($("#doj").val())==""){
				alert('Please fill the date of joining');
				$("#doj").focus();
				return false;
            }
            if (!$('input[name=sex]:checked').val()) {
               alert('Please choose the gender');
			   return false;
            }
            if($.trim($("#txtQualification").val())==""){
				alert('Please fill the qualification');
				$("#txtQualification").focus();
				return false;
            }

            if($.trim($("#txtEmail").val())==""){
				alert('Please fill the email');
				$("#txtEmail").focus();
				return false;
            }else if (!validateEmail($.trim($("#txtEmail").val()))) {
				alert('Email is not valid');
				$("#txtEmail").focus();
				return false;
	        }

	        if($.trim($("#txtUname").val())==""){
				alert('Please fill the username');
				$("#txtUname").focus();
				return false;
            }

        });
    });
</script>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Teacher</div>
            <form name="frmProff" id="frmProff" action="postdata.php" method="post">
              <input type="hidden" name="form_action" value="add_edit_professor" />
                <div class="custtable_left" >

                    <div class="custtd_left">
						<?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>

                    <div class="custtd_left">
                        <h2>Professor Name<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtPname" maxlength="50" name="txtPname" value="<?php echo ($_GET['act']=='edit')? $row['teacher_name']:$_POST['txtPname'];?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Address<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <textarea style="height:40px;" class="inp_txt" id="txtAreaAddress" cols="20" rows="2" name="txtAreaAddress"><?php echo ($_GET['act']=='edit')? $row['address']:$_POST['txtAreaAddress'];?></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Date of Birth<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" id="dob" name="dob" size="12" value="<?php echo ($_GET['act']=='edit')? $row['dob']:$_POST['dob'];?>" >
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Joining Date<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" id="doj" name="doj" size="12" value="<?php echo ($_GET['act']=='edit')? $row['doj']:$_POST['doj'];?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Gender<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="radio" name="sex" value="male" class="radiobutt">Male
                        <input type="radio" name="sex" value="female" class="radiobutt">Female
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Desigation</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtDegination" maxlength="20" name="txtDegination">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Qualification <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtQualification" maxlength="50" name="txtQualification" value="<?php echo ($_GET['act']=='edit') ? $row['qualification']:$_POST['txtQualification'];?>"/>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Experience <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="years" name="years" class="select">
						<option value="" selected="selected">--Select Years--</option>
						<?php
							for($i=1;$i<=50;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						?>
                        </select>
                        <select id="month" name="month" class="select">
						<option value="" selected="selected">--Select Month--</option>
						<?php
								for($i=1;$i<=11;$i++){
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
						?>
                        </select>
                    </div>
                    <div class="clear"></div>

                    <?php if($_GET['act']!='edit'){?>
							<div class="custtd_left">
								<h2>Email <span class="redstar">*</span></h2>
							</div>
							<div class="txtfield">
								<input type="text" class="inp_txt" id="txtEmail" maxlength="50" name="txtEmail">
							</div>
							<div class="clear"></div>
							<div class="custtd_left">
								<h2>Username <span class="redstar">*</span></h2>
							</div>
							<div class="txtfield">
								<input type="text" class="inp_txt" id="txtUname" maxlength="50" name="txtUname">
							</div>
							<div class="clear"></div>
                    <?php } ?>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub" value="<?php echo $button_save;?>">
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


