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
					<div style="width:700px;float:left;" >
						 <table width="200" border="1">
						  <thead>
								<tr>
									<th width="100">Pages</th>
									<th width="50">Add</th>
									<th width="50">Edit</th>
									<th width="50">Delete </th>
									<th width="50">View</th>
									<th width="50">Clone</th>
									<th width="50"><br/>All</th>
								</tr>
						 </thead>
						 <tbody>
							  <tr>
							  	<td align="center">Timetable Dashboard</td>
								<td align="center"><input type="checkbox" id="add1" name="add1" value="add-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit1" name="edit1"  value="edit-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete1" name="delete1" value="delete-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view1" name="view1" value="view-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone1" name="clone1"   value="clone-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all1" name="all1" value="all-1" class="cls-permission" <?php if(isset($check_arr['1']) && $check_arr['1']['view']==1 && $check_arr['1']['add_role']==1 && $check_arr['1']['edit']==1 && $check_arr['1']['delete_role']==1 && $check_arr['1']['view']==1 && $check_arr['1']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">Generate Timetable</td>
								<td align="center"><input type="checkbox" id="add2" name="add2" value="add-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit2" name="edit2"  value="edit-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete2" name="delete2" value="delete-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view2" name="view2" value="view-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone2" name="clone2"   value="clone-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all2" name="all2" value="all-2" class="cls-permission" <?php if(isset($check_arr['2']) && $check_arr['2']['view']==1 && $check_arr['2']['add_role']==1 && $check_arr['2']['edit']==1 && $check_arr['2']['delete_role']==1 && $check_arr['2']['view']==1 && $check_arr['2']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">Timetable View</td>
								<td align="center"><input type="checkbox" id="add3" name="add3" value="add-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit3" name="edit3"  value="edit-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete3" name="delete3" value="delete-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view3" name="view3" value="view-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone3" name="clone3"   value="clone-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all3" name="all3" value="all-3" class="cls-permission" <?php if(isset($check_arr['3']) && $check_arr['3']['view']==1 && $check_arr['3']['add_role']==1 && $check_arr['3']['edit']==1 && $check_arr['3']['delete_role']==1 && $check_arr['3']['view']==1 && $check_arr['3']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">Calender View</td>
								<td align="center"><input type="checkbox" id="add4" name="add4" value="add-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit4" name="edit4"  value="edit-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete4" name="delete4" value="delete-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view4" name="view4" value="view-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone4" name="clone4"   value="clone-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all4" name="all4" value="all-4" class="cls-permission" <?php if(isset($check_arr['4']) && $check_arr['4']['view']==1 && $check_arr['4']['add_role']==1 && $check_arr['4']['edit']==1 && $check_arr['4']['delete_role']==1 && $check_arr['4']['view']==1 && $check_arr['4']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">Location</td>
								<td align="center"><input type="checkbox" id="add5" name="add5" value="add-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit5" name="edit5"  value="edit-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete5" name="delete5" value="delete-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view5" name="view5" value="view-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone5" name="clone5"   value="clone-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all5" name="all5" value="all-5" class="cls-permission" <?php if(isset($check_arr['5']) && $check_arr['5']['view']==1 && $check_arr['5']['add_role']==1 && $check_arr['5']['edit']==1 && $check_arr['5']['delete_role']==1 && $check_arr['5']['view']==1 && $check_arr['5']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							    <td align="center">List Building</td>
								<td align="center"><input type="checkbox" id="add6" name="add6" value="add-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit6" name="edit6"  value="edit-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete6" name="delete6" value="delete-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view6" name="view6" value="view-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone6" name="clone6"   value="clone-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all6" name="all6" value="all-6" class="cls-permission" <?php if(isset($check_arr['6']) && $check_arr['6']['view']==1 && $check_arr['6']['add_role']==1 && $check_arr['6']['edit']==1 && $check_arr['6']['delete_role']==1 && $check_arr['6']['view']==1 && $check_arr['6']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							   <tr>
							  	<td align="center">List Room</td>
								<td align="center"><input type="checkbox" id="add7" name="add7" value="add-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit7" name="edit7"  value="edit-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete7" name="delete7" value="delete-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view7" name="view7" value="view-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone7" name="clone7"   value="clone-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all7" name="all7" value="all-7" class="cls-permission" <?php if(isset($check_arr['7']) && $check_arr['7']['view']==1 && $check_arr['7']['add_role']==1 && $check_arr['7']['edit']==1 && $check_arr['7']['delete_role']==1 && $check_arr['7']['view']==1 && $check_arr['7']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Classroom Availability</td>
								<td align="center"><input type="checkbox" id="add8" name="add8" value="add-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit8" name="edit8"  value="edit-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete8" name="delete8" value="delete-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view8" name="view8" value="view-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone8" name="clone8"   value="clone-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all8" name="all8" value="all-8" class="cls-permission" <?php if(isset($check_arr['8']) && $check_arr['8']['view']==1 && $check_arr['8']['add_role']==1 && $check_arr['8']['edit']==1 && $check_arr['8']['delete_role']==1 && $check_arr['8']['view']==1 && $check_arr['8']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Programs</td>
								<td align="center"><input type="checkbox" id="add9" name="add9" value="add-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit9" name="edit9"  value="edit-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete9" name="delete9" value="delete-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view9" name="view9" value="view-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone9" name="clone9"   value="clone-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all9" name="all9" value="all-9" class="cls-permission" <?php if(isset($check_arr['9']) && $check_arr['9']['view']==1 && $check_arr['9']['add_role']==1 && $check_arr['9']['edit']==1 && $check_arr['9']['delete_role']==1 && $check_arr['9']['view']==1 && $check_arr['9']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Program Cycles</td>
								<td align="center"><input type="checkbox" id="add10" name="add10" value="add-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit10" name="edit10"  value="edit-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete10" name="delete10" value="delete-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view10" name="view10" value="view-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone10" name="clone10"   value="clone-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all10" name="all10" value="all-10" class="cls-permission" <?php if(isset($check_arr['10']) && $check_arr['10']['view']==1 && $check_arr['10']['add_role']==1 && $check_arr['10']['edit']==1 && $check_arr['10']['delete_role']==1 && $check_arr['10']['view']==1 && $check_arr['10']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Areas</td>
								<td align="center"><input type="checkbox" id="add11" name="add11" value="add-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit11" name="edit11"  value="edit-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete11" name="delete11" value="delete-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view11" name="view11" value="view-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone11" name="clone11"   value="clone-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all11" name="all11" value="all-11" class="cls-permission" <?php if(isset($check_arr['11']) && $check_arr['11']['view']==1 && $check_arr['11']['add_role']==1 && $check_arr['11']['edit']==1 && $check_arr['11']['delete_role']==1 && $check_arr['11']['view']==1 && $check_arr['11']['clone']==1){echo "checked";} ?>/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Subjects</td>
								<td align="center"><input type="checkbox" id="add12" name="add12" value="add-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['add_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="edit12" name="edit12" value="edit-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['edit']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="delete12" name="delete12" value="delete-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['delete_role']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="view12" name="view12" value="view-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['view']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="clone12" name="clone12" value="clone-12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['clone']==1){echo "checked";}  ?>/></td>
								<td align="center"><input type="checkbox" id="all12" name="all12" class="cls-permission" <?php if(isset($check_arr['12']) && $check_arr['12']['view']==1 && $check_arr['12']['add_role']==1 && $check_arr['12']['edit']==1 && $check_arr['12']['delete_role']==1 && $check_arr['12']['view']==1 && $check_arr['12']['clone']==1){echo "checked";} ?>/></td>
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
