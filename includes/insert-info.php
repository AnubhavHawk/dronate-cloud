<?php
	print_r($_REQUEST);
	include('db_connection.php');
	$description = mysqli_real_escape_string($conn, $_REQUEST['description']);
	if($_REQUEST['city'] == '')
		$city = "undefined";
	else
		$city = $_REQUEST['city'];
	$sql = "INSERT INTO donate_info(user_name, latitude, longitutde, user_mobile, user_email, city, description) VALUES('".$_REQUEST['name']."', '".$_REQUEST['lat']."', '".$_REQUEST['long']."', ".$_REQUEST['mobile'].", '".$_REQUEST['email']."', '".strtolower($city)."', '$description')";
	$result = $conn->query($sql);
	if($result)
		header("location:../index.php?s=s");
	else
		header("location:../index.php?s=f");
?>