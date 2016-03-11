<?php 	
include('header.php'); 
$user = getPermissions('areas');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$obj = new Areas();
$result = $obj->viewArea();
include_once('datatable_js.php');
?>
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
            <div class="h_title">Areas View
			<?php if($user['add_role'] != '0'){?>
			<a href="areas.php" class="gird-addnew" title="Add New Area">Add New</a>
			<?php } ?>
			</div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Area Name</th>
                        <th >Area Code </th>
                        <th >Area Color</th>
						<th >Add Date</th>
						<th >Update Date</th>
						<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
                        <th >Action</th>
						<?php } ?>
                    </tr>
                </thead>
                <tbody>
				<?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['id'] ?></td>
                        <td><?php echo $data['area_name'] ?></td>
                        <td><?php echo $data['area_code'] ?></td>
                        <td><div style="width:50px; height:20px; background-color:<?php echo $data['area_color'] ?>"> </div></td>
						<td><?php echo $data['date_add'] ?></td>
						<td><?php echo $data['date_update'] ?></td>
						<?php if($user['edit'] != '0' || $user['delete_role'] != '0'){?>
							<td class="align-center" id="<?php echo $data['id'] ?>">
								<?php if($user['edit'] != '0'){?>
									<a href="areas.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
								<?php } ?>
								<?php if($user['delete_role'] != '0'){?>
									<a href="#" class="table-icon delete" onClick="deleteArea(<?php echo $data['id'] ?>)"></a>
								<?php } ?>
							</td>
						<?php } ?>
                    </tr>
				<?php }?>
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