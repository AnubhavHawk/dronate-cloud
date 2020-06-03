<?php
	if(isset($_REQUEST['city'])){
		include('db_connection.php');
		$description = mysqli_real_escape_string($conn, $_REQUEST['description']);
		if($_REQUEST['city'] == '')
			$city = 'undefined';
		else
			$city = $_REQUEST['city'];
		$sql = "INSERT INTO request_info(latitude, longitutde, city, description) VALUES('".$_REQUEST['lat']."', '".$_REQUEST['long']."', '".strtolower($city)."', '$description')";
		$result = $conn->query($sql);
		if($result)
			echo "We have noted your marked location. Someone will reach out to there shortly";
		else
			echo "Failed adding information, please try again";
	}
	else
	{
		echo "access denied";
	}
?>