<?php
@include('admin_auth.php');

if( !$_POST['id'] ){
	echo '<h1>An error has occrued. Please try again.</h1>';
	die;
}

@include('../common/connection.php');

$query = '
	DELETE FROM bookings
	WHERE id = "' . $_POST['id'] . '"
';

$connection->query($query);
?>

<html>
<head>
	<title>Cancel Booking</title>
	<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<h2>Success</h2>
	<form action="booking_dashboard.php" method="POST">
		<input type="hidden" name="password" value="cmps278">
		<input class="navigation-btn" type="submit" value="Ok">
	</form>
</body>
</html>