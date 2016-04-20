<?php 
include('header.php');
$user = getPermissions('special_activity');
if(isset($_GET['edit']) && $_GET['edit']!=""){
	if($user['edit'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
}else{
	if($user['add_role'] != '1')
	{
		echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
	}
}
$obj = new SpecialActivity();
$objTeach = new Teacher();
$obj2 = new Timeslot();
$teacherData = $objTeach->getTeachers();
$specialAvailData = $obj->getSpecialAvailRule();
$tslot_dropDwn = $obj2->getTimeSlotStartDateDropDwn();
$objTS = new Timeslot();
$tslot_dropDwn = $objTS->getTimeSlotStartDateDropDwn();
$disFDivCss = "style=''";
$special_act_id=$detail_grp=$act_date=$act_ad_hoc_fix_date=$special_act_name=$special_activity=$special_activity_type=$program_year_id=$cycle_id=$area_id=$room_id=$subject_id=$subject_val=$teacher_id=$start_time_id=$duration=$adhoc_start_date=$adhoc_end_date=$disabled=$ad_hoc_act_date_dd=$readonly=$special_sp_act_name=$one_time_edit=$rule_id_grp_str=$no_participants=$coordinator=$special_activity_category="";
$btnSubmit="Save";
$daysDBArr = array('0'=>'Mon','1'=>'Tue','2'=>'Wed','3'=>'Thu','4'=>'Fri','5'=>'Sat','6'=>'Sun');
$activity_filter_val = (isset($_POST['activity_color_filter']) && $_POST['activity_color_filter']!="")?$_POST['activity_color_filter']:'';
$options = '<option value="08:00 AM-09:00 AM">08:00 AM-09:00 AM</option>
			<option value="09:00 AM-10:00 AM">09:00 AM-10:00 AM</option>
			<option value="10:00 AM-11:00 AM">10:00 AM-11:00 AM</option>
			<option value="11:00 AM-12:00 PM">11:00 AM-12:00 PM</option>
			<option value="12:00 PM-01:00 PM">12:00 PM-01:00 PM</option>
			<option value="01:00 PM-02:00 PM">01:00 PM-02:00 PM</option>
			<option value="02:00 PM-03:00 PM">02:00 PM-03:00 PM</option>
			<option value="03:00 PM-04:00 PM">03:00 PM-04:00 PM</option>
			<option value="04:00 PM-05:00 PM">04:00 PM-05:00 PM</option>
			<option value="05:00 PM-06:00 PM">05:00 PM-06:00 PM</option>
			<option value="06:00 PM-07:00 PM">06:00 PM-07:00 PM</option>
			<option value="07:00 PM-08:00 PM">07:00 PM-08:00 PM</option>
			<option value="08:00 PM-09:00 PM">08:00 PM-09:00 PM</option>
			<option value="09:00 PM-10:00 PM">09:00 PM-10:00 PM</option>
			<option value="10:00 PM-11:00 PM">10:00 PM-11:00 PM</option>';
$option_duration='<option value="">--Select--</option>
                  <option value="15">00:15</option>
                  <option value="30">00:30</option>
                  <option value="45">00:45</option>
                  <option value="60">01:00</option>
                  <option value="75">01:15</option>
                  <option value="90">01:30</option>
                  <option value="105">01:45</option>
                  <option value="120">02:00</option>
                  <option value="135">02:15</option>
                  <option value="150">02:30</option>
                  <option value="165">02:45</option>
                  <option value="180">03:00</option>
                  <option value="195">03:15</option>
                  <option value="210">03:30</option>
                  <option value="225">03:45</option>
                  <option value="240">04:00</option>
                  <option value="255">04:15</option>
                  <option value="270">04:30</option>
                  <option value="285">04:45</option>
                  <option value="300">05:00</option>
                  <option value="315">05:15</option>
                  <option value="330">05:30</option>
                  <option value="345">05:45</option>
                  <option value="360">06:00</option>
                  <option value="375">06:15</option>
                  <option value="390">06:30</option>
                  <option value="405">06:45</option>
                  <option value="420">07:00</option>
                  <option value="435">07:15</option>
                  <option value="450">07:30</option>
                  <option value="465">07:45</option>
                  <option value="480">08:00</option>
				  <option value="495">08:15</option>
				  <option value="510">08:30</option>
				  <option value="525">08:45</option>
				  <option value="540">09:00</option>
				  <option value="555">09:15</option>
				  <option value="570">09:30</option>
				  <option value="585">09:45</option>
				  <option value="600">10:00</option>
				  <option value="615">10:15</option>
				  <option value="630">10:30</option>
				  <option value="645">10:45</option>
				  <option value="660">11:00</option>
				  <option value="675">11:15</option>
				  <option value="690">11:30</option>
				  <option value="705">11:45</option>
				  <option value="720">12:00</option>';			
	$name="";
	$teachId = ""; $decodeTeachId=$ad_hoc_fix_date="";
	$mappedruleids = array();
	if(isset($_GET['edit']) && $_GET['edit']!=""){
		$special_act_id = base64_decode($_GET['edit']);
		$one_time_edit="1";
		$detail = $obj->specialActivityDetail($special_act_id);
		$act_date =(isset($detail['act_date']) && $detail['act_date']!="")? $detail['act_date'] :"";
		$act_ad_hoc_fix_date =(isset($detail['act_date']) && $detail['act_date']!="")? $detail['act_date'] :"";
		$special_act_name =(isset($detail['special_activity_name']) && $detail['special_activity_name']!="")? $detail['special_activity_name'] :"";
		$special_activity =(isset($detail['reserved_flag']) && $detail['reserved_flag']!="")? $detail['reserved_flag'] :"";
		$special_activity_type =(isset($detail['special_activity_type']) && $detail['special_activity_type']!="")? $detail['special_activity_type'] :"";
		$program_year_id =(isset($detail['program_year_id']) && $detail['program_year_id']!="")? $detail['program_year_id'] :"";
		$cycle_id =(isset($detail['cycle_id']) && $detail['cycle_id']!="")? $detail['cycle_id'] :"";
		$special_activity_category =(isset($detail['special_activity_category']) && $detail['special_activity_category']!="")? $detail['special_activity_category'] :"";
		$area_id =(isset($detail['area_id']) && $detail['area_id']!="")? $detail['area_id'] :"";
		$room_id =(isset($detail['room_id']) && $detail['room_id']!="")? $detail['room_id'] :"";
		$subject_id =(isset($detail['subject_id']) && $detail['subject_id']!="")? $detail['subject_id'] :"";
		$subject_val=(isset($detail['subject_id']) && $detail['subject_id']==0)? "N/A": "";
		$teacher_id =(isset($detail['teacher_id']) && $detail['teacher_id']!="")? $detail['teacher_id'] :"";
		$start_time_id =(isset($detail['start_time']) && $detail['start_time']!="")? $detail['start_time'] :"";
		$duration =(isset($detail['duration']) && $detail['duration']!="")? $detail['duration'] :"";
		$no_participants = (isset($detail['adhoc_participants']) && $detail['adhoc_participants']!="")? $detail['adhoc_participants'] :"";
		$coordinator = (isset($detail['adhoc_coordinator']) && $detail['adhoc_coordinator']!="")? $detail['adhoc_coordinator'] :"";
		$adhoc_start_date =(isset($detail['adhoc_start_date']) && $detail['adhoc_start_date']!="" && $detail['act_date']=="0000-00-00")? $detail['adhoc_start_date'] :"";
		$adhoc_end_date =(isset($detail['adhoc_end_date']) && $detail['adhoc_end_date']!="" && $detail['act_date']=="0000-00-00")? $detail['adhoc_end_date'] :"";
		$disabled =(isset($special_act_id) && $special_act_id!="")? 'disabled="disabled"' :"";
		$readonly =(isset($special_act_id) && $special_act_id!="")? 'readonly="readonly"' :"";
		if(isset($detail['reserved_flag']) && $detail['reserved_flag']=="5" && $detail['adhoc_start_date']=="0000-00-00"){
			$ad_hoc_act_date_dd="1";
		}else if(isset($detail['reserved_flag']) && $detail['reserved_flag']=="5"){
			$ad_hoc_act_date_dd="2";
		}else{
			$ad_hoc_act_date_dd="";
		}
		$btnSubmit =(isset($_GET['edit']) && $_GET['edit']!="")? "Update" :"Save";
	}
	$rule_id_gr_uni_arr=array();
	if(isset($_GET['gp_Edit']) && $_GET['gp_Edit']!=""){
		$special_sp_act_name = base64_decode($_GET['gp_Edit']);
		$detail_grp = $obj->getSpecialActivityDetailGrpEditOne($special_sp_act_name);
		$detail_grp1 = $obj->getSpecialActivityDetailOnGrpEdit($special_sp_act_name);
		$detail_grp2 = $obj->getSpecialActivityDetailOnGrpEdit($special_sp_act_name);
		$special_act_name =(isset($detail_grp['special_activity_name']) && $detail_grp['special_activity_name']!="")? $detail_grp['special_activity_name'] :"";
		$special_activity =(isset($detail_grp['reserved_flag']) && $detail_grp['reserved_flag']!="")? $detail_grp['reserved_flag'] :"";
		$special_activity_type =(isset($detail_grp['special_activity_type']) && $detail_grp['special_activity_type']!="")? $detail_grp['special_activity_type'] :"";
		if($special_activity_type==1){
			$act_date =(isset($detail_grp['act_date']) && $detail_grp['act_date']!="")? $detail_grp['act_date'] :"";
			if($detail_grp['reserved_flag']==5){
				$act_ad_hoc_fix_date =(isset($detail_grp['act_date']) && $detail_grp['act_date']!="")? $detail_grp['act_date'] :"";
			}else{$act_ad_hoc_fix_date="";}
			$duration =(isset($detail_grp['duration']) && $detail_grp['duration']!="")? $detail_grp['duration'] :"";
			$adhoc_start_date =(isset($detail_grp['adhoc_start_date']) && $detail_grp['adhoc_start_date']!="" && $detail_grp['act_date']=="0000-00-00")? $detail_grp['adhoc_start_date'] :"";
			$adhoc_end_date =(isset($detail_grp['adhoc_end_date']) && $detail_grp['adhoc_end_date']!="" && $detail_grp['act_date']=="0000-00-00")? $detail_grp['adhoc_end_date'] :"";
			$start_time_id =(isset($detail_grp['start_time']) && $detail_grp['start_time']!="")? $detail_grp['start_time'] :"";
		}else{
			$act_date=$duration=$act_ad_hoc_fix_date=$adhoc_start_date=$adhoc_end_date=$start_time_id="";
		}
		$no_participants = (isset($detail_grp['adhoc_participants']) && $detail_grp['adhoc_participants']!="")? $detail_grp['adhoc_participants'] :"";
			$special_activity_category =(isset($detail_grp['special_activity_category']) && $detail_grp['special_activity_category']!="")? $detail_grp['special_activity_category'] :"";

		$coordinator = (isset($detail_grp['adhoc_coordinator']) && $detail_grp['adhoc_coordinator']!="")? $detail_grp['adhoc_coordinator'] :"";
		$program_year_id =(isset($detail_grp['program_year_id']) && $detail_grp['program_year_id']!="")? $detail_grp['program_year_id'] :"";
		$cycle_id =(isset($detail_grp['cycle_id']) && $detail_grp['cycle_id']!="")? $detail_grp['cycle_id'] :"";
		$area_id =(isset($detail_grp['area_id']) && $detail_grp['area_id']!="")? $detail_grp['area_id'] :"";
		$room_id =(isset($detail_grp['room_id']) && $detail_grp['room_id']!="")? $detail_grp['room_id'] :"";
		$subject_id =(isset($detail_grp['subject_id']) && $detail_grp['subject_id']!="")? $detail_grp['subject_id'] :"";
		$subject_val=(isset($detail_grp['subject_id']) && $detail_grp['subject_id']==0)? "N/A": "";
		$teacher_id =(isset($detail_grp['teacher_id']) && $detail_grp['teacher_id']!="")? $detail_grp['teacher_id'] :"";
		$disabled =(isset($special_sp_act_name) && $special_sp_act_name!="")? 'disabled="disabled"' :"";
		$readonly =(isset($special_sp_act_name) && $special_sp_act_name!="")? 'readonly="readonly"' :"";
		if(isset($detail_grp['reserved_flag']) && $detail_grp['reserved_flag']=="5" && $detail_grp['adhoc_start_date']=="0000-00-00"){
		$ad_hoc_act_date_dd="1";
		}else if(isset($detail_grp['reserved_flag']) && $detail_grp['reserved_flag']=="5"){
			$ad_hoc_act_date_dd="2";
		}else{
			$ad_hoc_act_date_dd="";
		}
		$rule_id_gr_arr=array();
		while($data_grp_rule_id = $detail_grp2->fetch_assoc()){
		 		$rule_id_gr_arr[]=$data_grp_rule_id['special_activity_rule_id'];
		}
		if(count($rule_id_gr_arr)>0){
		 	$rule_id_gr_uni_arr = array_unique($rule_id_gr_arr);
			$rule_id_grp_str=implode(',',$rule_id_gr_uni_arr);
		}
		 $btnSubmit =(isset($_GET['gp_Edit']) && $_GET['gp_Edit']!="")? "Update" :"Save";
	}	
?>
<div id="content">
    <div id="main">
		<?php if (isset($_SESSION['succ_msg'])) {
  			  echo '<div class="full_w green center">' . $_SESSION['succ_msg'] . '</div>';
    		  unset($_SESSION['succ_msg']);
		} ?>
        <div class="custtd_left red">
		<?php if (isset($_SESSION['error_msg']))
    			echo $_SESSION['error_msg']; unset($_SESSION['error_msg']);
		?>
		</div>
		<div class="clear"></div>
        <div class="full_w">
            <div class="h_title">Recess Activity / Group Meetings / Ad-hoc Activity</div>
			<form name="specialActivityForm" id="specialActivityForm" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="addEditSpecialActivity" />
				<input type="hidden" id="special_act_id" name="special_act_id" value="<?php echo $special_act_id; ?>" />
				<input type="hidden" id="special_sp_act_name" name="special_sp_act_name" value="<?php echo $special_sp_act_name; ?>" />
                <input type="hidden" id="ad_hoc_act_date_dd" name="ad_hoc_act_date_dd" value="<?php echo $ad_hoc_act_date_dd; ?>" />
				<input type="hidden" id="one_time_edit" name="one_time_edit" value="<?php echo $one_time_edit; ?>" />
                <input type="hidden" id="rule_id_grp" name="rule_id_grp" value="<?php echo $rule_id_grp_str; ?>" />
                <div class="custtable_left">
				<div class="custtd_left red">
					<?php if(isset($_SESSION['error_msg']))
						echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
				</div>
				<div class="clear"></div>
                <div class="custtable_left">
				<!-- new -->
				<div class="addSubDiv">
                            <div class="custtd_left">
                                <h2 class="blod-text">Activity Name<span class="redstar">*</span></h2>
                  </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt" id="txtActName" maxlength="120" name="txtActName" size="120" style="width:450px;" value="<?php echo $special_act_name;?>" <?php //echo $readonly;?>>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left">
                                <h2 class="blod-text">Choose Activity Type<span class="redstar">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="special_activity" name="special_activity" class="select1" onchange="specialActivity();" <?php echo $disabled;?>> 
									<option value="" selected="selected">--Select--</option>
									<option value="3" <?php if($special_activity == '3'){echo  'selected="selected"'; }?>>Recess Activities</option>
									<option value="4" <?php if($special_activity == '4'){echo  'selected="selected"'; }?>>Group Meetings</option>
									<option value="5" <?php if($special_activity == '5'){echo  'selected="selected"'; }?>>Adhoc Activities</option>
								</select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="special_activity" value="<?php echo $special_activity;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left actType">
                                <h2 class="blod-text">Choose Activity Frequency<span class="redstar spanActivityType">*</span></h2>
                            </div>
							<?php if(isset($_GET['gp_Edit']) && $_GET['gp_Edit']!=""){ ?>
							
                            <div class="txtfield actType">
                                <select id="special_activity_type" name="special_activity_type" class="select1" onchange="specialActivity();" <?php echo $disabled;?>> 
									<option value="" selected="selected">--Select--</option>
									<option value="1" <?php if($special_activity_type == '1'){echo  'selected="selected"'; }?>>One Time Activity</option>
									<option value="2" <?php if($special_activity_type == '2'){echo  'selected="selected"'; }?>>Periodic Activity</option>
								</select>
								<?php if($disabled!=""){?>
									<input type="hidden" id="special_activity_type" name="special_activity_type" value="<?php echo $special_activity_type;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left otAct divDuration <?php if($special_activity_type == '1'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
							
                    		<div class="txtfield otAct <?php if($special_activity_type == '1'){ echo "showotBlock";}else{ echo "";} ?>" >
                       			Duration:<span class="redstar spanDuration">*</span><select name="duration" id="duration" class="activity_row_chk" >
                                        	<?php echo $option_duration;?>
                                    	  </select>
									<script type="text/javascript">
                                        jQuery('#duration').val("<?php echo $duration; ?>");
                                    </script>
							</div>
							<div class="txtfield otAct divDateSingle <?php if($special_activity_type == '1'){ echo "showotBlock";}else{ echo "";} ?>">
								 Date:<input type="text" size="12" id="oneTimeDate"  name="oneTimeDate" class="txtfield" value="<?php 
								 if($special_activity_type == '1' || $special_activity_type == '2')
								 	{ echo $act_date;}else{ echo "";} ?>"/>
							</div> 
							<div class="txtfield otAct divTs <?php if($special_activity_type == '1' ){ echo "showotBlock";}else{ echo "";} ?>"> 
                                  Start Time:<select id="ot_tslot_id"  name="ot_tslot_id" >
                                        		<option value="">--Select--</option>
												<?php echo $tslot_dropDwn;?>
											</select>
									 <script type="text/javascript">
                                        jQuery('#ot_tslot_id').val("<?php echo $start_time_id; ?>");
                                    </script>
                    		</div>
                    		<div class="clear"></div>
							<div class="custtd_left otAct div-ad-hoc-label  <?php if(($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2') && $special_activity_type == '1'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
                    		<div class="txtfield otAct div-ad-hoc-date-slct <?php if(($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2') && $special_activity_type == '1'){ echo "showotBlock";}else{ echo "";} ?>" >
									Activity Date:<span class="redstar spanAdHocDate">*</span>
								 	<select id="ad_hoc_date_slct" name="ad_hoc_date_slct"   onchange="adHocDateShowHide();">
											<option value="" selected="selected">-Select-</option>
											<option value="1" <?php if($ad_hoc_act_date_dd == '1' && $special_activity_type == '1' ){echo  'selected="selected"'; }?>>Fixed Date</option>
											<option value="2" <?php if($ad_hoc_act_date_dd == '2' && $special_activity_type == '1'){echo  'selected="selected"'; }?>>Range Date</option>
									</select>
							</div>
							<div class="txtfield otAct div-ad-hoc-fixed " >
								    Date:<span class="redstar spanAdHocDate">*</span>
									<input type="text" size="12" id="ad_hoc_fix_date"  name="ad_hoc_fix_date" class="txtfield" value="<?php echo $act_ad_hoc_fix_date;?>"/>
							</div>
							<div class="txtfield otAct div-ad-hoc-range" >
									From:<input type="text" size="12" id="fromADHocDate"  name="fromADHocDate" value="<?php echo $adhoc_start_date; ?>"/>
                        			To:<input type="text" size="12" id="toADHocDate" name="toADHocDate" value="<?php echo $adhoc_end_date; ?>"/>
							</div>		
							<div class="clear"></div> 
							<?php }else{?>
                            <div class="txtfield actType">
							    <select id="special_activity_type" name="special_activity_type" class="select1" onchange="specialActivity();" <?php echo $disabled;?>> 
									<option value="" selected="selected">--Select--</option>
									<option value="1" <?php if($special_activity_type == '1' || $special_activity_type == '2'){echo  'selected="selected"'; }?>>One Time Activity</option>
									<option value="2">Periodic Activity</option>
								</select>
								<?php if($disabled!="" && isset($_GET['edit'])){?>
									<input type="hidden" id="special_activity_type" name="special_activity_type" value="<?php echo $special_activity_type;?>" />
								<?php }?>
							</div>
                            <div class="clear"></div>
							<div class="custtd_left otAct divDuration <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
							
                    		<div class="txtfield otAct <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       			Duration:<span class="redstar spanDuration">*</span><select name="duration" id="duration" class="activity_row_chk" >
                                        	<?php echo $option_duration;?>
                                    	  </select>
									<script type="text/javascript">
                                        jQuery('#duration').val("<?php echo $duration; ?>");
                                    </script>
							</div>
							<div class="txtfield otAct divDateSingle <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>">
								 Date:<input type="text" size="12" id="oneTimeDate"  name="oneTimeDate" class="txtfield" value="<?php 
								 if($special_activity_type == '1' || $special_activity_type == '2')
								 	{ echo $act_date;}else{ echo "";} ?>"/>
							</div> 
							<div class="txtfield otAct divTs <?php if($special_activity_type == '1' || $special_activity_type == '2'){ echo "showotBlock";}else{ echo "";} ?>"> 
                                  Start Time:<select id="ot_tslot_id"  name="ot_tslot_id" >
                                        		<option value="">--Select--</option>
												<?php echo $tslot_dropDwn;?>
											</select>
									 <script type="text/javascript">
                                        jQuery('#ot_tslot_id').val("<?php echo $start_time_id; ?>");
                                    </script>
                    		</div>
                    		<div class="clear"></div>
							<div class="custtd_left otAct div-ad-hoc-label  <?php if($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
                       		</div>
                    		<div class="txtfield otAct div-ad-hoc-date-slct <?php if($ad_hoc_act_date_dd == '1' || $ad_hoc_act_date_dd == '2'){ echo "showotBlock";}else{ echo "";} ?>" >
									Activity Date:<span class="redstar spanAdHocDate">*</span>
								 	<select id="ad_hoc_date_slct" name="ad_hoc_date_slct"   onchange="adHocDateShowHide();">
											<option value="" selected="selected">-Select-</option>
											<option value="1" <?php if($ad_hoc_act_date_dd == '1'){echo  'selected="selected"'; }?>>Fixed Date</option>
											<option value="2" <?php if($ad_hoc_act_date_dd == '2'){echo  'selected="selected"'; }?>>Range Date</option>
									</select>
							</div>
							<div class="txtfield otAct div-ad-hoc-fixed" >
								    Date:<span class="redstar spanAdHocDate">*</span>
									<input type="text" size="12" id="ad_hoc_fix_date"  name="ad_hoc_fix_date" class="txtfield" value="<?php echo $act_ad_hoc_fix_date;?>"/>
							</div>
							<div class="txtfield otAct div-ad-hoc-range" >
									From:<input type="text" size="12" id="fromADHocDate"  name="fromADHocDate" value="<?php echo $adhoc_start_date; ?>"/>
                        			To:<input type="text" size="12" id="toADHocDate" name="toADHocDate" value="<?php echo $adhoc_end_date; ?>"/>
							</div>		
							<div class="clear"></div> 
							<?php }?>
							
							<div class="custtd_left">
                                <h2>Choose Program<span class="redstar spanPrgm">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctProgram" name="slctProgram" class="select1 required" onchange="getCycleByProgId(this)" <?php echo $disabled;?>>
                                    <option value="" selected="selected">--Select Program--</option>
                                    <?php
                                    $program_qry = "select * from program_years";
                                    $program_result = mysqli_query($db, $program_qry);
                                    while ($program_data = mysqli_fetch_assoc($program_result)) {
                                        $program_year_detail = $program_data['name'] . ' ' . $program_data['start_year'] . ' ' . $program_data['end_year'];
                                        $selected = (trim($program_year_id) == trim($program_data['id'])) ? ' selected="selected"' : '';
                                        ?>
                                        <option value="<?php echo $program_data['id']; ?>" <?php echo $selected; ?>><?php echo $program_data['name']; ?></option>
<?php } ?>
                                </select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="slctProgram" value="<?php echo $program_year_id;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Cycle<span class="redstar spanCycle">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctCycle" name="slctCycle" class="select1 required" <?php echo $disabled;?> onchange="getSubjectByProgIDAndCycleID();">
                                    <option value="" selected="selected">--Select Cycle--</option>
                                    <?php
									if(isset($program_year_id) && $program_year_id!=""){
										$cycle_query="select * from cycle where program_year_id='".$program_year_id."'";
										$cycleDataall = mysqli_query($db, $cycle_query);
										$cycleData = array();
											while ($cycleDatas = mysqli_fetch_assoc($cycleDataall)){
												$cycleData[] = $cycleDatas['id'];
											}
									}
									if (count($cycleData) > 0) {
                                        for ($i = 0; $i < count($cycleData); $i++) {
										    $selected = (trim($cycle_id) == trim($cycleData[$i])) ? ' selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $cycleData[$i]; ?>" <?php echo $selected; ?>><?php echo $i + 1; ?></option>
										<?php }
									} ?>
                                </select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="slctCycle" value="<?php echo $cycle_id;?>" />
								<?php }?>
                            </div>
							
							<div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Activity Category<span class="redstar spanCycle">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="special_activity_category" name="special_activity_category" class="select1 required" >
                                    <option value="1" <?php if($special_activity_category=="1"){echo "selected=selected"; } ?> >Actividad</option>
									<option value="2" <?php if($special_activity_category=="2"){echo "selected=selected"; } ?> >Uso de Espacio</option>
									<option value="3" <?php if($special_activity_category == "3"){echo "selected=selected"; } ?> >Centro de investigaci&oacute;n</option>
									<option value="4" <?php if($special_activity_category=="4"){echo "selected=selected"; } ?> >Otros</option>
                                </select>
                            </div>
                            <div class="clear"></div>
							<div class="custtd_left">
                                <h2>No. of Participants</h2>
                            </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt" id="participantsNo" maxlength="100" name="participantsNo" value="<?php echo $no_participants;?>">
                            </div>
							<div class="clear"></div>
							<div class="custtd_left">
                                <h2>Coordinator</h2>
                            </div>
                            <div class="txtfield">
                                <input type="text" class="inp_txt" id="coordinator" maxlength="100" name="coordinator" value="<?php echo $coordinator;?>">
                            </div>
							<div class="clear"></div>
                            <div class="custtd_left">
                                <h2>Choose Area <span class="redstar spanArea">*</span></h2>
                            </div>
                            <div class="txtfield ">
                                <select id="slctArea" name="slctArea" class="select1 required" <?php //echo $disabled;?>>
                                    <option value="" selected="selected">--Select Area--</option>
									<?php
									$areaId = "";
									$area_qry = "select * from area";
									$area_result = mysqli_query($db, $area_qry);
									while ($area_data = mysqli_fetch_assoc($area_result)) {
										$selected = (trim($area_id) == trim($area_data['id'])) ? ' selected="selected"' : '';
										?>
													<option value="<?php echo $area_data['id'] ?>" <?php echo $selected;?>><?php echo $area_data['area_name']; ?></option>
									<?php } ?>
                                </select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="slctArea" value="<?php echo $area_id;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
							 <div class="custtd_left">
                                <h2>Choose Room <span class="redstar spanRoom">*</span></h2>
                            </div>
							<div class="txtfield">
                                <select id="slctRoom" name="slctRoom" class="select1 required" <?php //echo $disabled;?>>
                                    <option value="" selected="selected">--Select Room--</option>
									<option value="0" <?php if($room_id==0 && $room_id!=""){echo 'selected="selected"';}?>>N/A</option>
                                <?php
								$roomId = "";
								$room_qry = "select * from room";
								$room_result = mysqli_query($db, $room_qry);
								while ($room_data = mysqli_fetch_assoc($room_result)) {
									$selected = (trim($room_id) == trim($room_data['id'])) ? ' selected="selected"' : '';
									?>
										<option value="<?php echo $room_data['id'] ?>" <?php echo $selected;?>><?php echo $room_data['room_name']; ?></option>
							<?php } ?>
                                </select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="slctRoom" value="<?php echo $room_id;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" >
                                <h2>Subject Name<span class="redstar spanSubject">*</span></h2>
                            </div>
                            <div class="txtfield">
                                <select id="slctSubjectName" name="slctSubjectName" class="select1 required" <?php //echo $disabled; ?> >
                                    <option value="" selected="selected">--Select Subject--</option>
                                    <option value="0" <?php if($subject_id==0 &&$subject_id!="" ){echo ' selected="selected"';}?>>N/A</option>
									<?php
									$subjectData = $subjectNameData=array();
									if(isset($subject_id) && $subject_id!="" && $program_year_id!="" && $cycle_id!=""){
										$subject_query="select * from subject where program_year_id='".$program_year_id."' and cycle_no='".$cycle_id."'";
										$subjectDataall = mysqli_query($db, $subject_query);
											while ($subjectDatas = mysqli_fetch_assoc($subjectDataall)){
												$subjectData[] = $subjectDatas['id'];
												$subjectNameData[] = $subjectDatas['subject_name'];
											}
									}
									if (count($subjectData) > 0) {
                                        for ($i = 0; $i < count($subjectData); $i++) {
										    $selected = (trim($subject_id) == trim($subjectData[$i])) ? ' selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $subjectData[$i]; ?>" <?php echo $selected; ?>><?php echo  $subjectNameData[$i]; ?></option>
										<?php }
									} ?>
                                </select>
								<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
									<input type="hidden" name="slctSubjectName" value="<?php echo $subject_id;?>" />
								<?php }?>
                            </div>
                            <div class="clear"></div>
                            <div class="custtd_left" style="display:none;">
                                <h2>Subject Code <span class="redstar spanSubCode">*</span></h2>
                            </div>
                            <div class="txtfield" style="display:none;">
                                <input type="text" class="inp_txt" id="txtSubjCode" maxlength="50" name="txtSubjCode" value="<?php echo $subject_val;?>" <?php echo $disabled;?>>
                            </div>
                            <div class="clear"></div>
                  </div>
				<!-- end -->
                    <div class="custtd_left">
                        <h2>Teacher <span class="redstar spanSubCode">*</span></h2>
                    </div>
                    <div class="txtfield">
					 <select id="slctTeacher" name="slctTeacher" class="select1 required" <?php //echo $disabled;?> >
						<option value="" >--Select--</option>
						<?php while($data = $teacherData->fetch_assoc()){ 
							$selected = (trim($teacher_id) == trim($data['id'])) ? ' selected="selected"' : '';?>
									<option value="<?php echo $data['id']; ?>" <?php echo $selected;?> ><?php echo $data['teacher_name']; ?><?php if($data['email'] !=""){echo ' ('.$data['email'].')'; } ?></option>
						<?php } ?>
					</select>
					<?php if($disabled!="" && isset($_GET['gp_Edit'])){?>
							<input type="hidden" name="slctTeacher" value="<?php echo $teacher_id;?>" />
					<?php }?>
                    </div>
                    <div class="clear"></div>
					<h4 style="color:#999999">Note: Each non-mandatory field in the above form are just for information purpose only and will not be used by the timetable allocation algorithm.</h4><br />
					<div class="clear"></div>
					<div class="scheduleBlockSpAct" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
					<div class="custtd_left">
                        <span style="font-size:14px"><b>Create A New Rule(optional):</b></span>
                    </div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Schedule Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt" id="txtSchd" maxlength="50" name="txtSchd">
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromSpecialAval" name="fromSpecialAval" />
                        To:<input type="text" size="12" id="toSpcialAval" name="toSpcialAval" />
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Occurring<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <select id="c1chWeek1" name="c1chWeek1" class="select1 required" onchange="showCycleDetails(this.value);">
                            <option value="1w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '1w') echo 'selected = "selected"';?>>Weekly</option>
                            <option value="2w" <?php if(isset($occurrence['0']) && $occurrence['0'] == '2w') echo 'selected = "selected"';?>>Bi Weekly</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left" id="custtd_leftc1w1">
                        <h2>Days and Timeslot 1st<span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield" >
						<div id="c1week1">
							<div class="tmSlotc1w1">
								<input type="checkbox" id="Mon1C1W1" name="day[]"  value="Mon1C1W1" class="special_days"/><span class="dayName"> Mon </span>
								<div id="sp-act-ts-mon-w1">
									<div>Duration</div>
									<select name="duration-sp-mon" id="duration-sp-mon-w1" class="cls-duration-sp-mon" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-mon-w1" name="Mon[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w1">
							<input type="checkbox" id="Tue1C1W1" name="day[]"  value="Tue1C1W1" class="special_days"/><span class="dayName"> Tue </span>
								<div id="sp-act-ts-tue-w1">
									<div>Duration</div>
									<select name="duration-sp-tue" id="duration-sp-tue-w1" class="cls-duration-sp-tue" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-tue-w1" name="Tue[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w1">
							<input type="checkbox" id="Wed1C1W1" name="day[]"  value="Wed1C1W1" class="special_days"/><span class="dayName"> Wed </span>
								<div id="sp-act-ts-wed-w1">
									<div>Duration</div>
									<select name="duration-sp-wed" id="duration-sp-wed-w1" class="cls-duration-sp-wed" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-wed-w1" name="Wed[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w1">
							<input type="checkbox" id="Thu1C1W1" name="day[]"  value="Thu1C1W1" class="special_days"/><span class="dayName"> Thu </span>
								<div id="sp-act-ts-thu-w1">
									<div>Duration</div>
									<select name="duration-sp-thu" id="duration-sp-thu-w1" class="cls-duration-sp-thu" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-thu-w1" name="Thu[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w1">
							<input type="checkbox" id="Fri1C1W1" name="day[]"  value="Fri1C1W1" class="special_days"/><span class="dayName"> Fri </span>
								<div id="sp-act-ts-fri-w1">
									<div>Duration</div>
									<select name="duration-sp-fri" id="duration-sp-fri-w1" class="cls-duration-sp-fri" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-fri-w1" name="Fri[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w1">
							<input type="checkbox" id="Sat1C1W1" name="day[]"  value="Sat1C1W1" class="special_days"/><span class="dayName"> Sat </span>
								<div id="sp-act-ts-sat-w1">
									<div>Duration</div>
									<select name="duration-sp-sat" id="duration-sp-sat-w1" class="cls-duration-sp-sat" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-sat-w1" name="Sat[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>		
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left" id="custtd_leftc1w2" style="display:none;">
                        <h2>Days and Timeslot 2nd<span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield" >
						<div id="c1week2" style="display:none;">
							<div class="tmSlotc1w2">
								<input type="checkbox" id="Mon2C1W2" name="day[]"  value="Mon2C1W2" class="special_days"/><span class="dayName"> Mon </span>
								<div id="sp-act-ts-mon-w2">
									<div>Duration</div>
									<select name="duration-sp-mon" id="duration-sp-mon-w2" class="cls-duration-sp-mon" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-mon-w2" name="Mon[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w2">
							<input type="checkbox" id="Tue2C1W2" name="day[]"  value="Tue2C1W2" class="special_days"/><span class="dayName"> Tue </span>
								<div id="sp-act-ts-tue-w2">
									<div>Duration</div>
									<select name="duration-sp-tue" id="duration-sp-tue-w2" class="cls-duration-sp-tue" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-tue-w2" name="Tue[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w2">
							<input type="checkbox" id="Wed2C1W2" name="day[]"  value="Wed2C1W2" class="special_days"/><span class="dayName"> Wed </span>
								<div id="sp-act-ts-wed-w2">
									<div>Duration</div>
									<select name="duration-sp-wed" id="duration-sp-wed-w2" class="cls-duration-sp-wed" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-wed-w2" name="Wed[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w2">
							<input type="checkbox" id="Thu2C1W2" name="day[]"  value="Thu2C1W2" class="special_days"/><span class="dayName"> Thu </span>
								<div id="sp-act-ts-thu-w2">
									<div>Duration</div>
									<select name="duration-sp-thu" id="duration-sp-thu-w2" class="cls-duration-sp-thu" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-thu-w2" name="Thu[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w2">
							<input type="checkbox" id="Fri2C1W2" name="day[]"  value="Fri2C1W2" class="special_days"/><span class="dayName"> Fri </span>
								<div id="sp-act-ts-fri-w2">
									<div>Duration</div>
									<select name="duration-sp-fri" id="duration-sp-fri-w2" class="cls-duration-sp-fri" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-fri-w2" name="Fri[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>
							</div>
							<div class="tmSlotc1w2">
							<input type="checkbox" id="Sat2C1W2" name="day[]"  value="Sat2C1W2" class="special_days"/><span class="dayName"> Sat </span>
								<div id="sp-act-ts-sat-w2">
									<div>Duration</div>
									<select name="duration-sp-sat" id="duration-sp-sat-w2" class="cls-duration-sp-sat" >
									   <?php echo $option_duration;?>
									</select>
									<div>Start Time</div>
									<select id="ts-sp-sat-w2" name="Sat[]" class="slctSpTs">
										  <option value="">--Select--</option>
										  <?php echo $tslot_dropDwn;?>
									</select>
								</div>		
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Add Exception</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" size="12" id="exceptnSpecialActAval" />
                    </div>
					<div class="addbtnException">
					    <input type="button" name="btnAddMore" class="btnSpecialActAvailExcep" value="Add">
                     </div>
                    <div class="clear"></div>					 
					<div class="divException" style="margin-left: 200px;">
					</div>
					<div class="custtable_left div-arrow-img" style="cursor:pointer">
					<input type="button" name="saveRule" class="buttonsub" value="Create Rule" onclick="createSpecialAvailRule();">
                   <!-- <img src="images/arrow.png" id="arrow-img" class="arrow-img"  onclick="createTeachAvailRule();"/>-->
                	</div>
					<div class="clear"></div>
					</div>
                </div>
			<div class="clear"></div>
			<div class="scheduleBlockSpAct" style="border:1px solid #CCCCCC; padding:20px; 20px 20px 20px; margin-bottom:10px; width:1200px">
				<div>
					<span style="font-size:14px"><b>Select A Rule For Recess Activity / Group Meetings/ Ad-hoc Activity :</b></span>
				</div>
				<div >
                    <ul id="rules" name="rules" class="rule">
                       <table width="1200" border="1" >
					   <?php
					    $count = 0;
					   	while($data = $specialAvailData->fetch_assoc()){
							$rule_id=$data['id'];
							if($count%6 == 0){ echo "<tr>"; }  ?>
								<td class="sched-data"><div style="word-wrap: break-word; overflow-y: scroll; height: 140px;"><li style="min-height:20px;" class="main-title"><input type="checkbox" name="ruleval[]" value="<?php echo $data['id']; ?>"  class="rule__listed_ckb" <?php if(in_array($data['id'], $rule_id_gr_uni_arr)) { echo "checked"; } ?>  /><b>&nbsp;<?php echo $data['rule_name']; ?></b>
								<span style="padding-left:10px; cursor:pointer; padding-top:5px;"><img alt="Delete Rule" style="margin-bottom:-3px;" onclick="deleteRuleSpecialActivity(<?php echo $rule_id; ?>);" src="images/delete-rule.png" /></span>
								</li>
								<span>From <?php echo $data['start_date']; ?> to <?php echo $data['end_date']; ?></span><br/>
								<span>Occurrence: <?php if($data['occurrence'] == '1w') echo 'Weekly';else if($data['occurrence'] == '2w') echo 'Biweekly';else echo 'N/A'; ?></span>
								<ul class="listing">
									<?php //get the day and timeslot
									$week1=$week2='';
									$tsobj = new Timeslot();
									if($data['week1']!='' &&  count(unserialize($data['week1']))>0){
										foreach(unserialize($data['week1']) as $key=> $value)
										{
											$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
											$week1 = $week1." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
										}
									}
									if(count(unserialize($data['week2']))>0)
									{
										if($data['occurrence'] == '2w'){
											foreach(unserialize($data['week2']) as $key=> $value)
											{
												$tsobj = new Timeslot();
												$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
												$week2 = $week2." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
											}
										}
									}
									?>
									<?php if($data['week1']!=''){?>
									<li><b>Week1:</b><br/><?php echo $week1;?></li>
									<?php } if($data['occurrence'] == '2w'){?>
									<li><b>Week2:</b><br/><?php echo $week2;?></li>
									<?php } ?>
								</ul>
								<?php 
								$exceptionDates = $obj->getExceptionDate($rule_id);
								if(count($exceptionDates)>0){
									echo '<strong>Exception Date:</strong> <br>';
									$i=0;
									$totalVal =  count($exceptionDates)-1;
									foreach($exceptionDates as $value){
										if($i%2==0){
											echo $value;
											if($totalVal != $i)
												echo " , ";
										}else{
											echo $value.'<br>';
										}
										$i++;
									}
								} ?>
								</div>
								</td>
						<?php $count++; } ?>
						</tr>
						</table>
                    </ul>
                </div>
			</div>
			<div class="clear"></div>
			<div style="float:right;">
					<div class="txtfield" >
                        <input type="submit" name="btnSave" class="buttonsub" value="<?php echo $btnSubmit;?>">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'special_activity_view.php';">
                    </div>
			</div>		
			<div class="clear"></div>
					<div class="special_act_list">
					<?php 
					if(isset($_GET['gp_Edit']) && $_GET['gp_Edit']!=""){?>
					<table id="datatables" class="display tblSpActivity">
						<thead>
							<tr>
								<!--<th><input type="checkbox" id="ckbCheckAllActivity" value="Select all" title="Select All"/></th>-->
								<th>ID</th>
								<th>Special Activity Name</th>
								<th>Activity Name</th>
								<th>Activity Type</th>
								<th>Program</th>
								<th>Subject</th>
								<th>Teacher</th>
								<th>Class Room</th>
								<th>Date</th>
								<th>Timeslot</th>
								<th>Action</th>
							</tr>
						</thead>
                	<tbody>
					<tbody>
						 <?php
						 	$timeslot_arr=array();
							 while($data_grp = $detail_grp1->fetch_assoc()){
							 	$timeslot_arr=explode(',',$data_grp['timeslot_id']);
						   		$min_ts_id = $timeslot_arr[0];
						   		$max_ts_id = $timeslot_arr[count($timeslot_arr)-1];
								$timeslot = $objTeach->getTimeslotById($min_ts_id,$max_ts_id)
						 ?>
							<tr>
								<td><?php echo $data_grp['id']; ?></td>
								<td><?php echo $data_grp['special_activity_name']; ?></td>
								<td><?php echo $data_grp['name']; ?></td>
								<td><?php if($data_grp['reserved_flag']==3){echo "Recess";}
										  if($data_grp['reserved_flag']==4){echo "Group";}
										  if($data_grp['reserved_flag']==5){echo "Ad -Hoc";}?></td>
								<td><?php echo $data_grp['program_name']; ?></td>
								<td><?php if($data_grp['subject_id']==0){echo "N/A";}else{echo $data_grp['subject_name']; }?></td>
								<td><?php echo $data_grp['teacher_name']; ?></td>
								<td><?php if($data_grp['room_id']==0){echo "N/A";}else{echo $data_grp['room_name']; }?></td>
								<?php if($data_grp['act_date']=='0000-00-00' && ($data_grp['adhoc_start_date']!="0000-00-00" || $data_grp['adhoc_start_date']!="")){?>
								<td><?php echo $data_grp['adhoc_start_date'].' to '.$data_grp['adhoc_end_date']; ?></td>
								<?php }else{ ?>
									<td><?php echo $data_grp['act_date']; ?></td>
								<?php }?>
								<td><?php echo $timeslot; ?></td>
								<td id="<?php echo $data_grp['id'];?>"><a href="special_activity.php?edit=<?php echo base64_encode($data_grp['id'])?>" class="table-icon edit" title="Edit"></a><a class="table-icon delete" onClick="deleteSpecialActivityListing('<?php echo $data_grp['id']; ?>')"></a></td>
								</tr>
						<?php }?>	
				</tbody>
            	</table>
					<?php }?>
					 </div>
					
			 </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
