<?php

	include("db_connection.php");
	$sql = "SELECT DISTINCT city FROM donate_info UNION SELECT DISTINCT city FROM request_info";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			echo '<div style="display:inline-block; text-transform:capitalize; margin-left:10px;"><a href="#" class="city-link">'.$row['city'].'</a></div>';
		}
	}
?>