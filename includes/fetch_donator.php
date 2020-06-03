<?php
	if(isset($_REQUEST['city']))
	{
		include("db_connection.php");
		$don_sql = "SELECT * FROM donate_info WHERE city = '".$_REQUEST['city']."'";
		$result = $conn->query($don_sql);
		$time = date('Y-m-d H:i:s');
		$out = array();
		while($row = $result->fetch_assoc())
		{
			if((strtotime($time) - strtotime($row['entry_time']))/(60*60) < 10)
				$out[] = $row;
			else
			{
				// delete that donator record
				$del_sql = "DELETE FROM donate_info WHERE info_id = ".$row['info_id'];
				// echo $del_sql;

				$conn->query($del_sql);
			}
		}
		print_r(json_encode($out));
	}
	else
	{
		echo "Failed";
	}

?>