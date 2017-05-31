<?php
@include('admin_auth.php');

extract($_POST);

if(!$number || !$status || !$email){
	$message = "<h2>Missing Data</h2>";
}


if(!$message){
	@include('../common/connection.php');

	$query = '
	UPDATE bookings
	SET status = "' . $_POST['status'] . '"
	WHERE reservation_number = "' . $_POST['number'] . '"';

	$connection->query($query);

	if($status == 'removed' || $status == 'complete'){
		$query = '
		UPDATE guests
		SET active_booking_number = NULL
		WHERE person_email = "' . $_POST['email'] . '"';

		$connection->query($query);
	}

	if($status == 'pending' || $status == 'active'){
		$query = '
		UPDATE guests
		SET active_booking_number = "' . $_POST['number'] . '"
		WHERE person_email = "' . $_POST['email'] . '"';
		$connection->query($query);
	}

	$message = "Success";
}
?>

<html>
<head>
	<title>Edit Room</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="12">
				<div class="mt20 center">
					<h2><?php echo $message; ?></h2>
					<form action="reservations_dashboard.php?status=all" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>