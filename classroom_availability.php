<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Classroom Availability</div>
            <form action="postdata.php" method="post" class="form-align" id="form-clsrm-avail">
				<input type="hidden" name="form_action" value="addEditClassAvailability" />
                <div class="custtable_left">
                    <div class="custtd_left">
                        <h2>Room Type <span class="redstar">*</span></h2>
                    </div>
					<div class="txtfield">
						<select id="slctRmType" name="slctRmType[]"  class="selectMultiple inp_txt">
					 		  <option value="">--Select Room Type--</option>
                              <?php 
					          $room_type_qry="select * from  room_type";
					          $room_type_result= mysqli_query($db, $room_type_qry);
					          while ($room_type_data = mysqli_fetch_assoc($room_type_result)){?>
					          <option value="<?php echo $room_type_data['id'].'#'.$room_type_data['room_type']?>"><?php echo $room_type_data['room_type'];?></option>
					     	 <?php } ?>
                        </select>
					</div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Room Name <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                         <select id="slctRmName" name="slctRmName" class="select1 inp_txt">
						  	<option value="">--Select Room--</option>
                         </select>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Time Interval <span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        From:<input type="text" size="12" id="fromTmDuratn" />
                        To:<input type="text" size="12" id="toTmDuratn" />
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Days<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield" >
					    <div class="tmSlot">
						<?php 
							  $timslot='';
							  $obj=new Classroom_Availability();
							  $result=$obj->getTimeslot();
							  while ($data = $result->fetch_assoc()){
							  $timslot.='<option>'.$data['timeslot_range'].'</option>';
							  }
						?>
                        <input type="checkbox" id="mon" name="day[]"  value="mon" class="days"/> Mon &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="tsMon" name="tsAvailability[]" class="ts-avail-mon tmsloteCls" multiple="multiple">
                           <?php echo $timslot;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="tue" name="day[]"  value="tue" class="days"/> Tue &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="tsTue" name="tsAvailability[]" class="ts-avail-tue tmsloteCls" multiple="multiple">
                            <?php echo $timslot;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="wed" name="day[]"  value="wed" class="days"/> Wed &nbsp;&nbsp;&nbsp;&nbsp;
						 <select id="tsWed" name="tsAvailability[]" class="ts-avail-wed tmsloteCls" multiple="multiple">
                           <?php echo $timslot;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="thu" name="day[]"  value="thu" class="days"/> Thu &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						 <select id="tsThu" name="tsAvailability[]" class="ts-avail-thu tmsloteCls" multiple="multiple">
                            <?php echo $timslot;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="fri" name="day[]"  value="fri" class="days"/> Fri &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						 <select id="tsFri" name="tsAvailability[]" class="ts-avail-fri tmsloteCls" multiple="multiple">
                            <?php echo $timslot;?>
                        </select>
						</div>
						<div class="tmSlot">
                        <input type="checkbox" id="sat" name="day[]"  value="sat" class="days"/> Sat 
						 <select id="tmSat" name="tsAvailability[]" class="ts-avail-sat tmsloteCls" multiple="multiple">
                            <?php echo $timslot;?>
                        </select>
						</div>
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Exception.<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" size="12" id="exceptnClsAval" />
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnSave" class="buttonsub" value="Save">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'classroom_availability_view.php';">
                    </div>
                </div>	
                <div class="custtable_left div-arrow-img">
                    <img src="images/arrow.png" id="arrow-img" class="arrow-img" />
                </div>
                <div class="custtable_left divRule">
					<div class="divRulecls">
                   	 	<select id="rules" name="rules" multiple="multiple" size="6" class="rule">
                        </select>
						<input type="hidden" id="countRule"  name="countRule" value=""></input>
					</div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

