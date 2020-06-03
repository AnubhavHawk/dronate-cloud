<?php
	if(isset($_REQUEST['city']))
	{
		include("db_connection.php");
		$req_sql = "SELECT * FROM request_info WHERE city = '".$_REQUEST['city']."' AND is_active = 1";
		$result = $conn->query($req_sql);
		while($row = $result->fetch_assoc())
		{
			$out[] = $row;
		}
		print_r(json_encode($out));
	}
	else
	{
		echo "Please select a city";
	}

?>