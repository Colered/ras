<?php include('header.php'); 
$user = getPermissions('roles');
if($user['view'] != '1')
{
 echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$userId=$role_id="";
$view =$add =$edit =$del =$clone =$all ='';
$objU=new Users();
$result = $objU->getUserType();
if(isset($_GET['rid']) && $_GET['rid']!=""){
	$role_id = $_GET['rid'];
	$role_rows=$objU->getRoleData($role_id);
	$check_arr = array();
while($data = $role_rows->fetch_assoc())
{
	$check_arr[$data['page_id']] = $data;
}
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Add User</div>
            <form name="roleForm" id="roleForm" action="postdata.php" method="post">
			    <div class="">
					<div class="custtd_left">
                        <h2>User Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					  <select id="slctUserType" name="slctUserType" class="select1"  onchange="setAllPermission()">
						    <option value="" selected="selected">--Select Type--</option>
							<?php while($userDataType = $result->fetch_assoc()){
								$selected = $userDataType['id']==$role_id ?"selected":'';
							?>		
							<option value="<?php echo $userDataType['id'];?>" <?php echo $selected;?>><?php echo $userDataType['name'];?></option>
							<?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Administrator Permission</h2>
                    </div>
                    <div class="txtfield">
					 <div class="clear"></div>
					<div style="width:700px;float:left;" >
						 <table width="200" border="1">
						  <thead>
								<tr>
									<th width="100" align="center">Pages</th>
									<th width="50" align="center">Add</th>
									<th width="50" align="center">Edit</th>
									<th width="50" align="center">Delete </th>
									<th width="50" align="center">View</th>
									<th width="50" align="center">Clone</th>
									<th width="50" align="center">All</th>
								</tr>
						 </thead>
						 <tbody>
							  <tr>
							  	<td align="left">Timetable Dashboard</td>
								<td align="center"><input type="checkbox" id="add1" name="add1" value="add-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit1" name="edit1"  value="edit-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete1" name="delete1" value="delete-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view1" name="view1" value="view-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone1" name="clone1"   value="clone-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all1" name="all1" value="all-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['view']==1 && $check_arr['1']['add_role']==1 && $check_arr['1']['edit']==1 && $check_arr['1']['delete_role']==1 && $check_arr['1']['view']==1 && $check_arr['1']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">Generate Timetable</td>
								<td align="center"><input type="checkbox" id="add2" name="add2" value="add-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit2" name="edit2"  value="edit-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete2" name="delete2" value="delete-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view2" name="view2" value="view-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone2" name="clone2"   value="clone-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all2" name="all2" value="all-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['view']==1 && $check_arr['2']['add_role']==1 && $check_arr['2']['edit']==1 && $check_arr['2']['delete_role']==1 && $check_arr['2']['view']==1 && $check_arr['2']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">Timetable View</td>
								<td align="center"><input type="checkbox" id="add3" name="add3" value="add-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit3" name="edit3"  value="edit-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete3" name="delete3" value="delete-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view3" name="view3" value="view-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone3" name="clone3"   value="clone-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all3" name="all3" value="all-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['view']==1 && $check_arr['3']['add_role']==1 && $check_arr['3']['edit']==1 && $check_arr['3']['delete_role']==1 && $check_arr['3']['view']==1 && $check_arr['3']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">Calender View</td>
								<td align="center"><input type="checkbox" id="add4" name="add4" value="add-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit4" name="edit4"  value="edit-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete4" name="delete4" value="delete-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view4" name="view4" value="view-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone4" name="clone4"   value="clone-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all4" name="all4" value="all-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['view']==1 && $check_arr['4']['add_role']==1 && $check_arr['4']['edit']==1 && $check_arr['4']['delete_role']==1 && $check_arr['4']['view']==1 && $check_arr['4']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">Location</td>
								<td align="center"><input type="checkbox" id="add5" name="add5" value="add-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit5" name="edit5"  value="edit-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete5" name="delete5" value="delete-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view5" name="view5" value="view-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone5" name="clone5"   value="clone-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all5" name="all5" value="all-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['view']==1 && $check_arr['5']['add_role']==1 && $check_arr['5']['edit']==1 && $check_arr['5']['delete_role']==1 && $check_arr['5']['view']==1 && $check_arr['5']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							    <td align="left">List Building</td>
								<td align="center"><input type="checkbox" id="add6" name="add6" value="add-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit6" name="edit6"  value="edit-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete6" name="delete6" value="delete-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view6" name="view6" value="view-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone6" name="clone6"   value="clone-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all6" name="all6" value="all-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['view']==1 && $check_arr['6']['add_role']==1 && $check_arr['6']['edit']==1 && $check_arr['6']['delete_role']==1 && $check_arr['6']['view']==1 && $check_arr['6']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">List Room</td>
								<td align="center"><input type="checkbox" id="add7" name="add7" value="add-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit7" name="edit7"  value="edit-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete7" name="delete7" value="delete-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view7" name="view7" value="view-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone7" name="clone7"   value="clone-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all7" name="all7" value="all-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['view']==1 && $check_arr['7']['add_role']==1 && $check_arr['7']['edit']==1 && $check_arr['7']['delete_role']==1 && $check_arr['7']['view']==1 && $check_arr['7']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">List Classroom Availability</td>
								<td align="center"><input type="checkbox" id="add8" name="add8" value="add-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit8" name="edit8"  value="edit-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete8" name="delete8" value="delete-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view8" name="view8" value="view-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone8" name="clone8"   value="clone-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all8" name="all8" value="all-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['view']==1 && $check_arr['8']['add_role']==1 && $check_arr['8']['edit']==1 && $check_arr['8']['delete_role']==1 && $check_arr['8']['view']==1 && $check_arr['8']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">List Programs</td>
								<td align="center"><input type="checkbox" id="add9" name="add9" value="add-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit9" name="edit9"  value="edit-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete9" name="delete9" value="delete-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view9" name="view9" value="view-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone9" name="clone9"   value="clone-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all9" name="all9" value="all-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['view']==1 && $check_arr['9']['add_role']==1 && $check_arr['9']['edit']==1 && $check_arr['9']['delete_role']==1 && $check_arr['9']['view']==1 && $check_arr['9']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">List Program Cycles</td>
								<td align="center"><input type="checkbox" id="add10" name="add10" value="add-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit10" name="edit10"  value="edit-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete10" name="delete10" value="delete-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view10" name="view10" value="view-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone10" name="clone10"   value="clone-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all10" name="all10" value="all-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['view']==1 && $check_arr['10']['add_role']==1 && $check_arr['10']['edit']==1 && $check_arr['10']['delete_role']==1 && $check_arr['10']['view']==1 && $check_arr['10']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">List Areas</td>
								<td align="center"><input type="checkbox" id="add11" name="add11" value="add-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit11" name="edit11"  value="edit-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete11" name="delete11" value="delete-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view11" name="view11" value="view-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone11" name="clone11"   value="clone-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all11" name="all11" value="all-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['view']==1 && $check_arr['11']['add_role']==1 && $check_arr['11']['edit']==1 && $check_arr['11']['delete_role']==1 && $check_arr['11']['view']==1 && $check_arr['11']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">List Subjects</td>
								<td align="center"><input type="checkbox" id="add12" name="add12" value="add-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit12" name="edit12" value="edit-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete12" name="delete12" value="delete-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view12" name="view12" value="view-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone12" name="clone12" value="clone-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all12" name="all12" value="all-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['view']==1 && $check_arr['12']['add_role']==1 && $check_arr['12']['edit']==1 && $check_arr['12']['delete_role']==1 && $check_arr['12']['view']==1 && $check_arr['12']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="left">View Timeslots</td>
								<td align="center"><input type="checkbox" id="add13" name="add13" value="add-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit13" name="edit13" value="edit-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete13" name="delete13" value="delete-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view13" name="view13" value="view-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone13" name="clone13" value="clone-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all13" name="all13" value="all-13" class="cls-permission" <?php if(isset($check_arr['13']) && $check_arr['13']['view']==1 && $check_arr['13']['add_role']==1 && $check_arr['13']['edit']==1 && $check_arr['13']['delete_role']==1 && $check_arr['13']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Teachers</td>
								<td align="center"><input type="checkbox" id="add14" name="add14" value="add-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit14" name="edit14" value="edit-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete14" name="delete14" value="delete-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view14" name="view14" value="view-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone14" name="clone14" value="clone-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all14" name="all14" value="all-14" class="cls-permission" <?php if(isset($check_arr['14']) && $check_arr['14']['view']==1 && $check_arr['14']['add_role']==1 && $check_arr['14']['edit']==1 && $check_arr['14']['delete_role']==1 && $check_arr['14']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Teacher Availability</td>
								<td align="center"><input type="checkbox" id="add15" name="add15" value="add-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit15" name="edit15" value="edit-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete15" name="delete15" value="delete-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view15" name="view15" value="view-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone15" name="clone15" value="clone-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all15" name="all15" value="all-15" class="cls-permission" <?php if(isset($check_arr['15']) && $check_arr['15']['view']==1 && $check_arr['15']['add_role']==1 && $check_arr['15']['edit']==1 && $check_arr['15']['delete_role']==1 && $check_arr['15']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Holidays</td>
								<td align="center"><input type="checkbox" id="add16" name="add16" value="add-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit16" name="edit16" value="edit-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete16" name="delete16" value="delete-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view16" name="view16" value="view-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone16" name="clone16" value="clone-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all16" name="all16" value="all-16" class="cls-permission" <?php if(isset($check_arr['16']) && $check_arr['16']['view']==1 && $check_arr['16']['add_role']==1 && $check_arr['16']['edit']==1 && $check_arr['16']['delete_role']==1 && $check_arr['16']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Teacher Activities</td>
								<td align="center"><input type="checkbox" id="add17" name="add17" value="add-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit17" name="edit17" value="edit-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete17" name="delete17" value="delete-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view17" name="view17" value="view-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone17" name="clone17" value="clone-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all17" name="all17" value="all-17" class="cls-permission" <?php if(isset($check_arr['17']) && $check_arr['17']['view']==1 && $check_arr['17']['add_role']==1 && $check_arr['17']['edit']==1 && $check_arr['17']['delete_role']==1 && $check_arr['17']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Special Activities</td>
								<td align="center"><input type="checkbox" id="add18" name="add18" value="add-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit18" name="edit18" value="edit-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete18" name="delete18" value="delete-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view18" name="view18" value="view-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone18" name="clone18" value="clone-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all18" name="all18" value="all-18" class="cls-permission" <?php if(isset($check_arr['18']) && $check_arr['18']['view']==1 && $check_arr['18']['add_role']==1 && $check_arr['18']['edit']==1 && $check_arr['18']['delete_role']==1 && $check_arr['18']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">View Users</td>
								<td align="center"><input type="checkbox" id="add19" name="add19" value="add-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit19" name="edit19" value="edit-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete19" name="delete19" value="delete-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view19" name="view19" value="view-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone19" name="clone19" value="clone-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all19" name="all19" value="all-19" class="cls-permission" <?php if(isset($check_arr['19']) && $check_arr['19']['view']==1 && $check_arr['19']['add_role']==1 && $check_arr['19']['edit']==1 && $check_arr['19']['delete_role']==1 && $check_arr['19']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Import Sessions</td>
								<td align="center"><input type="checkbox" id="add20" name="add20" value="add-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit20" name="edit20" value="edit-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete20" name="delete20" value="delete-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view20" name="view20" value="view-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone20" name="clone20" value="clone-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all20" name="all20" value="all-20" class="cls-permission" <?php if(isset($check_arr['20']) && $check_arr['20']['view']==1 && $check_arr['20']['add_role']==1 && $check_arr['20']['edit']==1 && $check_arr['20']['delete_role']==1 && $check_arr['20']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Teacher Payrate Report</td>
								<td align="center"><input type="checkbox" id="add21" name="add21" value="add-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit21" name="edit21" value="edit-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete21" name="delete21" value="delete-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view21" name="view21" value="view-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone21" name="clone21" value="clone-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all21" name="all21" value="all-21" class="cls-permission" <?php if(isset($check_arr['21']) && $check_arr['21']['view']==1 && $check_arr['21']['add_role']==1 && $check_arr['21']['edit']==1 && $check_arr['21']['delete_role']==1 && $check_arr['21']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Teacher Activity Report</td>
								<td align="center"><input type="checkbox" id="add22" name="add22" value="add-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit22" name="edit22" value="edit-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete22" name="delete22" value="delete-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view22" name="view22" value="view-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone22" name="clone22" value="clone-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all22" name="all22" value="all-22" class="cls-permission" <?php if(isset($check_arr['22']) && $check_arr['22']['view']==1 && $check_arr['22']['add_role']==1 && $check_arr['22']['edit']==1 && $check_arr['22']['delete_role']==1 && $check_arr['22']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Weekly Report</td>
								<td align="center"><input type="checkbox" id="add23" name="add23" value="add-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit23" name="edit23" value="edit-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete23" name="delete23" value="delete-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view23" name="view23" value="view-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone23" name="clone23" value="clone-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all23" name="all23" value="all-23" class="cls-permission" <?php if(isset($check_arr['23']) && $check_arr['23']['view']==1 && $check_arr['23']['add_role']==1 && $check_arr['23']['edit']==1 && $check_arr['23']['delete_role']==1 && $check_arr['23']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Change Password</td>
								<td align="center"><input type="checkbox" id="add24" name="add24" value="add-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit24" name="edit24" value="edit-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete24" name="delete24" value="delete-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view24" name="view24" value="view-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone24" name="clone24" value="clone-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all24" name="all24" value="all-24" class="cls-permission" <?php if(isset($check_arr['24']) && $check_arr['24']['view']==1 && $check_arr['24']['add_role']==1 && $check_arr['24']['edit']==1 && $check_arr['24']['delete_role']==1 && $check_arr['24']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Help Page</td>
								<td align="center"><input type="checkbox" id="add25" name="add25" value="add-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit25" name="edit25" value="edit-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete25" name="delete25" value="delete-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view25" name="view25" value="view-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone25" name="clone25" value="clone-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all25" name="all25" value="all-25" class="cls-permission" <?php if(isset($check_arr['25']) && $check_arr['25']['view']==1 && $check_arr['25']['add_role']==1 && $check_arr['25']['edit']==1 && $check_arr['25']['delete_role']==1 && $check_arr['25']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">About Us</td>
								<td align="center"><input type="checkbox" id="add26" name="add26" value="add-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit26" name="edit26" value="edit-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete26" name="delete26" value="delete-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view26" name="view26" value="view-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone26" name="clone26" value="clone-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all26" name="all26" value="all-26" class="cls-permission" <?php if(isset($check_arr['26']) && $check_arr['26']['view']==1 && $check_arr['26']['add_role']==1 && $check_arr['26']['edit']==1 && $check_arr['26']['delete_role']==1 && $check_arr['26']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="left">Roles</td>
								<td align="center"><input type="checkbox" id="add27" name="add27" value="add-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit27" name="edit27" value="edit-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete27" name="delete27" value="delete-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view27" name="view27" value="view-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone27" name="clone27" value="clone-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all27" name="all27" value="all-27" class="cls-permission" <?php if(isset($check_arr['27']) && $check_arr['27']['view']==1 && $check_arr['27']['add_role']==1 && $check_arr['27']['edit']==1 && $check_arr['27']['delete_role']==1 && $check_arr['27']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							 </tbody> 
						</table>
					</div>
					<div class="clear"></div>
                  </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
