<?php
	include("includes/utility.php");
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Dronate | Drone-to-donate</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="shortcut icon" href="<?=baseurl()?>/assets/img/logo.png" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="<?=baseurl()?>/assets/css/style.css">
		<style>
			h4{
				font-family: helvetica, Arial, sans-serif!important;
			}
		</style>
	</head>
	<?php
	include("includes/navbar.php");
?>
<div class="row p-5 bg-light">
	<h5 class="col-12 text-center mb-5">
		~ If you are going out for some work, then you can find people donating food in your way and deliver it to people in need ~
	</h5>
	<div class="col-sm-12 col-md-4 p-4">
		<div class="shadow-sm rounded text-center p-3 bg-white">
			<h4><b>DONATE</b></h4>
			<img src="<?=baseurl()?>/assets/img/donate2.png" class="rounded-circle">
			<p>You can add the location of people who are willing to donate some food</p>
			<a class="btn btn-primary" href="<?=baseurl()?>/donate.php">Donate now</a>
		</div>
	</div>
	<div class="col-sm-12 col-md-4 p-4">
		<div class="shadow-sm rounded text-center p-3 bg-white">
			<h4><b>DELIVER</b></h4>
			<img src="<?=baseurl()?>/assets/img/delivery.png" class="rounded-circle">
			<p>You can pick food from donator's (green marker) and deliver it to people who are starving (red marker)</p>
			<a class="btn btn-primary" href="<?=baseurl()?>/">Deliver now</a>
		</div>
	</div>
	<div class="col-sm-12 col-md-4 p-4">
		<div class="shadow-sm rounded text-center p-3 bg-white">
			<h4><b>REQUEST</b></h4>
			<img src="<?=baseurl()?>/assets/img/question.png" class="rounded-circle">
			<p>If you know people who are starving. Then add their location so that someone can help them</p>
			<a class="btn btn-primary" href="<?=baseurl()?>/request.php">Request now</a>
		</div>
	</div>
</div>
<?php
	include("includes/bottom-scripts.php");
	include("includes/footer.php");
?>
