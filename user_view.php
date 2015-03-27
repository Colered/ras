<?php 	
include('header.php'); 
$user = getPermissions('users');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$objU = new Users();
$result = $objU->userDetail();
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
</style>
<div id="content">
    <div id="main">
		<div class="full_w green center">
		<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);} ?>
		</div>
        <div class="full_w">
            <div class="h_title">Users
			<?php if($user['add_role'] != '0'){?>
			<a href="user_add.php" class="gird-addnew" title="Add New User">Add New</a>
			<?php } ?>
			</div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Username</th>
                        <th >Email </th>
                        <th >User Type</th>
						<th width ="70">Action</th>
					</tr>
                </thead>
                <tbody>
				<?php while ($data = $result->fetch_assoc()){ 
					if($data['role_id']!=1){
				?>
					<tr>
                        <td class="align-center"><?php echo $data['id'] ;?></td>
                        <td><?php echo $data['username']; ?></td>
                        <td><?php echo $data['email'] ;?></td>
                        <td><?php 
								 $sql="select name from role where id='".$data['role_id']."'";
								 $q_res = mysqli_query($db, $sql);
								 $userType = $q_res->fetch_assoc();
								 echo $userType['name']; 
						 ?></td>
						 <td class="align-center" id="<?php echo $data['id']; ?>">
						   <?php if($data['is_active']==1){?>
						 	<div style="float:left; width:20px;"><img id="status-user<?php echo $data['id'];?>" src="images/status-active.png"  class="status-user-cls" onClick="setUserStatus(<?php echo $data['id']; ?>)" title="Desable" /></div>
							<?php }else{ ?>
							<div style="float:left; width:20px;"><img id="status-user<?php echo $data['id'];?>" src="images/status-deactive.png"  class="status-user-cls" onClick="setUserStatus(<?php echo $data['id']; ?>)" title="Enable" /></div>
							<?php }?>
							<?php if($user['edit'] != '0'){?>
							<a href="user_add.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
							<?php }?>
							<?php if($user['delete_role'] != '0'){?>
							<a href="#" class="table-icon delete" onClick="deleteUser(<?php echo $data['id']; ?>)"></a>
							<?php }?>
                        </td>
                    </tr>
				<?php } 
				   }?>
                </tbody>
            </table>
			<?php if(isset($_SESSION['error_msg'])){?>
				<div><span class="red"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></span></div>
			<?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>