<?php include('header.php'); 
$room_type=""; $room_name=""; $building_name=""; $roomId="";
$obj = new Classroom();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$roomId = base64_decode($_GET['edit']);
	$result = $obj->getDataByRoomID($roomId);
	while ($data = $result->fetch_assoc()){
			$room_type = $data['room_type'];
			$room_name = $data['room_name'];
			$building_name = $data['building_name'];
	}
}
$hiddenVal = ($room_name!="") ? "EditRoom":"Rooms";
$roomData = $obj->getAllRoomType(); 
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Classroom</div>
            <form action="" method="post">
                <input type="hidden" name="form_action" value="<?php echo $hiddenVal; ?>" />
				<input type="hidden" name="roomId" value="<?php echo $roomId; ?>" />
                <div class="custtable_left">
                    <div class="custtd_left red">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Room Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					
                        <select id="slctRmType" name="slctRmType" class="select1">
                            <?php
							while($data = $roomData->fetch_assoc()){ ?>
									$room_type = $data['room_type'];
									$room_name = $data['id'];
									<option value="<?php echo $data['id']; ?>"><?php echo $data['room_type']; ?></option>
							<?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtRmName" maxlength="50" name="txtRmName">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Building<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctBuilding" name="slctBuilding" class="select1">
                            <option value="" selected="selected">--Select Building--</option>
                            <option value="XYZ">XYZ</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3>
                            <span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnAddRoom" class="buttonsub" value="<?php echo $buttonName = ($room_name!="") ? "Update Room":"Add Room" ?>">
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

