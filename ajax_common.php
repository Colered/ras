<?php
require_once('config.php');
$codeBlock = trim($_POST['codeBlock']);
switch ($codeBlock) {
    case "del_area":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_area_query="delete from area where id='".$_POST['id']."'";
			$qry = mysqli_query($db, $del_area_query);
			$rowcount = mysqli_affected_rows($db);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
        break;

        case "del_teacher":
			if(isset($_POST['id'])){
				$id = $_POST['id'];
				$del_query="delete from teacher where id='".$_POST['id']."'";
				$qry = mysqli_query($db, $del_query);
				$rowcount = mysqli_affected_rows($db);
				if(mysqli_affected_rows($db)>0)
					echo 1;
				else
					echo 0;
			}
        break;
}
?>
