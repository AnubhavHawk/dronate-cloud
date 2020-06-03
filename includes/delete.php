<?php
	if(isset($_REQUEST['id']))
	{
		include("db_connection.php");
		if($_REQUEST['type'] == 'donate')
		{
			$id = "info_id";
			$table = "donate_info";
		}
		else
		{
			$id = "request_id";
			$table = "request_info";
		}
		$sql = "DELETE FROM $table WHERE $id = ".$_REQUEST['id'];
		$result = $conn->query($sql);
		if($result)
			echo "Removed successfully";
		else
			echo "Failed to remove";
	}
?>