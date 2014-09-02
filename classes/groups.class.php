<?php
class Groups extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Group*/
	public function addGroup() {
			//check if the group name exists
			$area_query="select id, name from group_master where name='".$_POST['txtGname']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Group Name already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new group
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO group_master VALUES ('', '".$_POST['txtGname']."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New Group has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the group";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing group*/
	public function viewGroup() {
			$area_query="select * from group_master order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any group exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	}

	/*function for fetch data using group ID*/
	public function getDataByGroupID($id) {
			$area_query="select * from group_master where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Group*/
	public function updateGroup() {
			//check if the building name exists
			$area_query="select id, name from group_master where name='".$_POST['txtGname']."' and id !='".$_POST['groupId']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Group Name already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update group_master Set name = '".$_POST['txtGname']."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['groupId']."'")) {
   					$message="Group has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the Group";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
}
