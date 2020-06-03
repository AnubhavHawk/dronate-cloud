<?php

	if(isset($_REQUEST['city'])){
		include('db_connection.php');
		$description = mysqli_real_escape_string($conn, $_REQUEST['description']);
		$city = $_REQUEST['city'];
		$sql = "INSERT INTO donate_info(user_name, latitude, longitutde, user_mobile, user_email, city, description) VALUES('".$_REQUEST['name']."', '".$_REQUEST['lat']."', '".$_REQUEST['long']."', ".$_REQUEST['mobile'].", '".$_REQUEST['email']."', '".strtolower($city)."', '$description')";
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