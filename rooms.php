<?php include('header.php'); 
$room_type=""; $room_name=""; $building_name=""; $roomId="";
$obj = new Classroom();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$roomId = base64_decode($_GET['edit']);
	$result = $obj->getDataByRoomID($roomId);
	/*while ($data = $result->fetch_assoc()){
			$room_type = $data['room_type'];
			$room_name = $data['room_name'];
			$building_name = $data['building_name'];
	}*/
	$row = $result->fetch_assoc();
}
$roomData = $obj->getAllRoomType();
$objBuld = new Buildings();  
$buildData = $objBuld->viewBuld();
$slctRmType = isset($_GET['edit']) ? $row['room_type_id'] : (isset($_POST['slctRmType'])? $_POST['slctRmType']:'');
$txtRmName = isset($_GET['edit']) ? $row['room_name'] : (isset($_POST['txtRmName'])? $_POST['txtRmName']:'');
$slctBuilding = isset($_GET['edit']) ? $row['building_id'] : (isset($_POST['slctBuilding'])? $_POST['slctBuilding']:'');

?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Classroom</div>
            <form name="roomsForm" id="roomsForm" action="postdata.php" method="post">
                <input type="hidden" name="form_action" value="addEditClassroom" />
				<input type="hidden" name="roomId" value="<?php echo $roomId; ?>" />
                <div class="custtable_left">
                    <div class="custtd_left red">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Room Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="slctRmType" name="slctRmType" class="select1 required">
							<?php if($roomData!=0){
								while($data = $roomData->fetch_assoc()){ ?>
										<option value="<?php echo $data['id']; ?>" <?php if($slctRmType == $data['id']){echo "selected"; }?>><?php echo $data['room_type']; ?></option>
							<?php }}else{ ?>
								<option value="">Not room type available</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtRmName" maxlength="50" name="txtRmName" value="<?php echo $txtRmName; ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Building<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
						<select id="slctBuilding" name="slctBuilding" class="select1 required">
                            <?php if($buildData!=0){
								while($data = $buildData->fetch_assoc()){ ?>
									<option value="<?php echo $data['id']; ?>"><?php echo $data['building_name']; ?></option>
							<?php }}else{ ?>
									<option value="">No Building Available</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3>
                            <span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="submit" name="btnAddRoom" class="buttonsub" value="<?php echo $buttonName = ($txtRmName!="") ? "Update Room":"Add Room" ?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'rooms_view.php';">
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

