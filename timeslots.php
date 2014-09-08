<?php 	
include('header.php'); 
$obj = new Timeslot();
$result = $obj->viewTimeslot();
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
	/*css for date range picker*/
	#example .k-timepicker {vertical-align: middle;} #example h3 { clear: both;} #example .code-sample { width: 60%; float:left; margin-bottom: 20px;} #example .output {width: 24%;	margin-left: 4%; float:left; }
</style>
<link rel="stylesheet" href="css/kendo.common.min.css" />
<link rel="stylesheet" href="css/kendo.default.min.css" />
<script src="js/kendo.all.min.js"></script>
<div id="content">
    <div id="main">
		 <div class="full_w green center">
		<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);} ?>
		</div>
		<div class="red" style="text-align:center; padding:5px;">
				<?php if(isset($_SESSION['error_msg']))
					echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
		</div>
        <div class="full_w">
            <div class="h_title">Timeslot</div>
            <form name="timetable" id="timetable" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addTimeslot" />
					<div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Timeslot <span class="redstar">*</span></h2>
                    </div>
                    <div class="custtd_left" style="margin-bottom:50px;">
					<div class="demo-section k-header" style="width: 600px; background:none;">
					<label for="start">Start time:</label>
					<input name="start_time" id="start" value="8:00 AM" />
					<label for="end" style="margin-left:3em">End time:</label>
					<input name="end_time" id="end" value="8:30 AM"/>
                    <input type="submit" name="btnGenrtTime" class="buttonsub" value="Add Timeslot" style="margin-left:10px;">
                    </div></div>
                    <div class="clear"></div>
                    <div>
					<table id="datatables" class="display">
					<thead>
					<tr>
						<th >ID</th>
						<th >Start Time</th>
						<th >End Time</th>
						<th >Timeslot</th>
						<th >Action</th>
					</tr>
					</thead>
					<tbody>
						<?php while ($data = $result->fetch_assoc()){ ?>
						<tr>
						<td class="align-center"><?php echo $data['id'] ?></td>
						<td><?php echo $data['start_time'] ?></td>
						<td><?php echo $data['end_time'] ?></td>
						<td><?php echo $data['timeslot_range'] ?></td>
						<td class="align-center" id="<?php echo $data['id'] ?>">
							<a href="#" class="table-icon delete" onClick="deleteTimeslot(<?php echo $data['id'] ?>)"></a>
						</td>
						</tr>
						<?php }?>
					</tbody>
					</table>
                    </div>
                </div>	
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script type="text/javascript">
/*js function for daterange picker */
$(document).ready(function() {
	function startChange() {
		var startTime = start.value();
		if (startTime) {
			startTime = new Date(startTime);
			end.max("8:00 PM");
			startTime.setMinutes(startTime.getMinutes() + this.options.interval);
			end.min(startTime);
			end.value(startTime);
		}
	}
	//init start timepicker
	var start = $("#start").kendoTimePicker({
		change: startChange
	}).data("kendoTimePicker");
	//init end timepicker
	var end = $("#end").kendoTimePicker().data("kendoTimePicker");
	//define min/max range
	start.min("8:00 AM");
	start.max("6:00 PM");
	//define min/max range
	end.min("8:00 AM");
	end.max("7:30 PM");
});
</script>



