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
}		
$role_rows=$objU->getRoleData($role_id);
$check_arr = array();
while($data = $role_rows->fetch_assoc())
{
	$check_arr[] = $data;
}
$add_desable_arr=array('1','2','3','4','13','17','20','21','22','23','24','25','26','27');
$edit_desable_arr=array('1','2','3','4','13','17','20','21','22','23','24','25','26','27');
$del_desable_arr=array('1','3','4','13','20','21','22','23','24','25','26','27');

//echo '<pre>';
//print_r($check_arr);
?>
<div id="content">
    <div id="main">
	   <div id="msg" class="green center" style="height:18px"></div>
		<div class="full_w">
            <div class="h_title">Manage Permissions</div>
            <form name="roleForm" id="roleForm" action="postdata.php" method="post">
			    <div class="">
					<div class="custtd_left">
                        <h2>Role<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					  <select id="slctUserType" name="slctUserType" class="select1" onchange="setAllPermission();">
						    <option value="" selected="selected">--Select Type--</option>
							<?php while($userDataType = $result->fetch_assoc()){
								$selected = $userDataType['id']==$role_id ?"selected":'';
							?>		
							<option value="<?php echo $userDataType['id'];?>" <?php echo $selected;?>><?php echo $userDataType['name'];?></option>
							<?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
					<?php if($role_id!=""){ ?>
					<div class="custtd_left">
                        <h2>Permissions</h2>
                    </div>
                    <div class="">
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
										<th width="50">All</th>
									</tr>
							 </thead>
							 <tbody>
							 <?php for($i=0;$i<count($check_arr);$i++)
							 {
							 ?>
								  <tr>
									<td align="center"><?php echo $check_arr[$i]['page_name'];?></td>
									<td align="center"><input type="checkbox" id="add<?php echo $check_arr[$i]['page_id']?>" name="page<?php echo $check_arr[$i]['page_id']?>[]" value="add-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['add_role']==1){echo "checked";}  ?> <?php if(in_array($check_arr[$i]['page_id'],$add_desable_arr)){echo 'disabled';} ?>/></td>
									<td align="center"><input type="checkbox" id="edit<?php echo $check_arr[$i]['page_id']?>" name="page<?php echo $check_arr[$i]['page_id']?>[]"  value="edit-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['edit']==1){echo "checked";} ?>  <?php if(in_array($check_arr[$i]['page_id'],$edit_desable_arr)){echo "disabled";}  ?>/></td>
									<td align="center"><input type="checkbox" id="delete<?php echo $check_arr[$i]['page_id']?>" name="page<?php echo $check_arr[$i]['page_id']?>[]"  value="delete-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['delete_role']==1){echo "checked";} ?> <?php if(in_array($check_arr[$i]['page_id'],$del_desable_arr)){echo "disabled";}  ?>/></td>
									<td align="center"><input type="checkbox" id="view<?php echo $check_arr[$i]['page_id']?>" name="page<?php echo $check_arr[$i]['page_id']?>[]"  value="view-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['view']==1){echo "checked";} ?>  /></td>
									<td align="center"><input type="checkbox" id="clone<?php echo $check_arr[$i]['page_id']?>" name="page<?php echo $check_arr[$i]['page_id']?>[]" value="clone-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['clone']==1){echo "checked";} ?> <?php if($check_arr[$i]['page_id']!='12'){echo "disabled";} ?>  /></td>
									<td align="center"><input type="checkbox" id="all<?php echo $check_arr[$i]['page_id']?>" name="all<?php echo $check_arr[$i]['page_id']?>" value="all-<?php echo $check_arr[$i]['page_id']?>" class="cls-permission <?php echo "cls-permission".$check_arr[$i]['page_id']?>" <?php if($check_arr[$i]['all_check']==1){echo "checked";} ?>  /></td>
								  </tr>					 
								  <?php } ?>
								 </tbody> 
							</table>
						 </div>
					</div>
					<?php }?>
					<div class="clear"></div>
                  </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
