<?php
include('header.php');
$obj=new Timetable();
$objP=new Programs();
$result=$obj->getTimetablesData();
?>
<div id="content">
    <div id="main">
        <div class="full_w" >
            <div class="h_title">Manage Timetable</div>
            <form action="" method="post">
                <div>
					<?php $user = getPermissions('generate_timetable');
						if($user['view'] != '0'){?>								
							<div class="custtd_left1">
								<a href="generate_timetable.php" class="buttonsub" >Generate Timetable</a>
							</div>
					<?php } ?>
					<?php $user = getPermissions('calendar_view');
						if($user['view'] != '0'){?>								
							<div class="custtd_right">
								<!--<a href="#"><input type="button" name="btnArea" class="buttonsub" value="Edit"></a>-->
								<a href="month.php" class="buttonsub" >Calendar View</a>
							</div>
					<?php } ?>
					<?php $user = getPermissions('timetable_view');
						if($user['view'] != '0'){?>								
							 <div class="custtd_right">
								<a href="timetable_view.php" class="buttonsub" >Table View</a>
							 </div>
					<?php } ?>             
                   
                    <div class="custtd_left1">
                        <!--<a href="#"> <input type="button" name="btnTeacher" class="buttonsub" value="Save"></a>-->
                    </div>
                    <div class="custtd_right">
                        <!--<a href="#"><input type="button" name="btnClsrm" class="buttonsub" value="Publish"></a>-->
                    </div>
                    <div class="custtd_right">
                        <!--<a href="#"><input type="button" name="btnBuilding" class="buttonsub" value="Delete"></a>-->
                    </div>
                    <div class="clear"></div>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th >Published</th>
                                    <th >Timetable</th>
									<th >Programs</th>
									<th >Date Range</th>
                                    <th >Created On</th>
                                    <th >Last Edit</th>
									<?php $user = getPermissions('generate_timetable');
										  if($user['view'] != '0' || $user['delete_role'] != '0'){?>
											<th >Action</th>
									<?php } ?>
                                </tr>
                            </thead>
                            <tbody>
								<?php 
								$count = 0;
								while ($data = $result->fetch_assoc()){
									$program_names = array();
									$program_array = explode(",",$data['programs']);
									foreach($program_array as $program_id)
									{
										$programs = $objP->getProgramDataByPrgmYrID($program_id);
										$pgm_names = $programs->fetch_assoc();	
										$program_names[] = $pgm_names['name'];
									}
									$program_list = implode(" , ",$program_names);
									
								?>
                                <tr>
                                    <td class="align-center"><input checked="checked" type="radio" id="radio" name="radio"  /></td>
                                    <td class="align-center"><?php echo $data['timetable_name']; ?></td>
									<td class="align-center"><?php echo $program_list; ?></td>
									<td class="align-center"><?php echo $data['start_date']." to ".$data['end_date']; ?></td>
                                    <td class="align-center"><?php echo $data['date_add']; ?></td>
                                    <td class="align-center"><?php echo $data['date_update']; ?></td>
									<?php if($user['view'] != '0' || $user['delete_role'] != '0'){?>
											<td class="align-center edit-tt" id="<?php echo $data['id'] ?>">
												 <?php if($user['view'] != '0'){?>	
														<a href="generate_timetable.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
												<?php } ?>
												<?php if($user['delete_role'] != '0'){?>											
														<a href="#" class="table-icon delete" onClick="deleteTimetable(<?php echo $data['id'] ?>)"></a>	
												<?php } ?>									 	
											</td>
									<?php } ?>
                                </tr>
								<?php $count++; } 
								if($count==0){ ?>
								 <tr>
                                    <td class="align-center red" colspan="5">No timetable exists, please generate a new timetable.</td>
                                   
                                </tr>
								
								
								<?php }
								?>
                            </tbody>
                        </table>
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

