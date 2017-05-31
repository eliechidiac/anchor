<?php
@include('admin_auth.php');
@include('../common/connection.php');

if($_GET['status'] == 'all'){
	$query = '
	SELECT r.*, ro.number AS room_number, p.*, b.status
	FROM bookings AS b
	JOIN reservations AS r ON b.reservation_number = r.number
	JOIN rooms AS ro ON ro.number = b.room_number
	JOIN guests AS g ON g.person_email = b.guest_person_email
	JOIN persons AS p ON p.email = g.person_email
	';
} else if($_GET['status'] == 'pending'){
	$query = '
	SELECT r.*, ro.number AS room_number, p.*, b.status
	FROM bookings AS b
	JOIN reservations AS r ON b.reservation_number = r.number
	JOIN rooms AS ro ON ro.number = b.room_number
	JOIN guests AS g ON g.person_email = b.guest_person_email
	JOIN persons AS p ON p.email = g.person_email
	WHERE b.status = "pending"
	';
} else if($_GET['status'] == 'complete'){
	$query = '
	SELECT r.*, ro.number AS room_number, p.*, b.status
	FROM bookings AS b
	JOIN reservations AS r ON b.reservation_number = r.number
	JOIN rooms AS ro ON ro.number = b.room_number
	JOIN guests AS g ON g.person_email = b.guest_person_email
	JOIN persons AS p ON p.email = g.person_email
	WHERE b.status = "complete"
	';
} else if($_GET['status'] == 'removed'){
	$query = '
	SELECT r.*, ro.number AS room_number, p.*, b.status
	FROM bookings AS b
	JOIN reservations AS r ON b.reservation_number = r.number
	JOIN rooms AS ro ON ro.number = b.room_number
	JOIN guests AS g ON g.person_email = b.guest_person_email
	JOIN persons AS p ON p.email = g.person_email
	WHERE b.status = "removed"
	';
} else if($_GET['status'] == 'active'){
	$query = '
	SELECT r.*, ro.number AS room_number, p.*, b.status
	FROM bookings AS b
	JOIN reservations AS r ON b.reservation_number = r.number
	JOIN rooms AS ro ON ro.number = b.room_number
	JOIN guests AS g ON g.person_email = b.guest_person_email
	JOIN persons AS p ON p.email = g.person_email
	WHERE b.status = "active"
	';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservations Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="mt20">
					<h2>Reservations</h2>
					<div class="pull-left mt20">
						<form action="reservations_dashboard.php?status=all" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['status'] == 'all'){ echo 'selected'; } ?>" type="submit" value="All">
						</form>
					</div>
					<div class="pull-left mt20 ml10">
						<form action="reservations_dashboard.php?status=pending" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['status'] == 'pending'){ echo 'selected'; } ?>" type="submit" value="Pending">
						</form>
					</div>
					<div class="pull-left mt20 ml10">
						<form action="reservations_dashboard.php?status=complete" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['status'] == 'complete'){ echo 'selected'; } ?>" type="submit" value="Complete">
						</form>
					</div>
					<div class="pull-left mt20 ml10">
						<form action="reservations_dashboard.php?status=removed" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['status'] == 'removed'){ echo 'selected'; } ?>" type="submit" value="Removed">
						</form>
					</div>
					<div class="pull-left mt20 ml10">
						<form action="reservations_dashboard.php?status=active" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['status'] == 'active'){ echo 'selected'; } ?>" type="submit" value="Active">
						</form>
					</div>
					<div class="clearfix"></div>
					<?php if($connection->query($query)->fetchAll()) { ?>
					<table class="table-striped mt20">
						<tr>
							<td class="table-title">Reservation Number</td>
							<td class="table-title">Room Number</td>
							<td class="table-title">Guest Name</td>
							<td class="table-title">Guest Phone Number</td>
							<td class="table-title">Guest Email</td>
							<td class="table-title">Status</td>
							<td class="table-title">Check In Date</td>
							<td class="table-title">Check out Date</td>
							<td class="table-title">Pick Up Location</td>
							<td class="table-title">Payment Method</td>
							<td class="table-title">Edit</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							$statuses = ['pending', 'active', 'removed', 'complete'];
							$action_string = '<td class="table-element text-align: center;">';
							$first = true;

							if($row['status'] == 'removed' || $row['status'] == 'complete'){
								$statuses = ['removed', 'complete'];
							}

							foreach ($statuses as $status) {
								if($first){
									if($status == $row['status']){
										$action_string .= '<form action="edit_reservation.php" method="POST"><input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input type="hidden" name="number" value="' . $row['number'] . '"><input type="hidden" name="status" value="' . $status . '"><input disabled class="btn action-btn" type="submit" value="Set as ' . ucfirst($status) . '"></form>';
									} else {
										$action_string .= '<form action="edit_reservation.php" method="POST"><input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input type="hidden" name="number" value="' . $row['number'] . '"><input type="hidden" name="status" value="' . $status . '"><input class="btn action-btn" type="submit" value="Set as ' . ucfirst($status) . '"></form>';
									}
								} else {
									if($status == $row['status']){
										$action_string .= '<form action="edit_reservation.php" method="POST"><input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input type="hidden" name="number" value="' . $row['number'] . '"><input type="hidden" name="status" value="' . $status . '"><input disabled class="btn action-btn mt10" type="submit" value="Set as ' . ucfirst($status) . '"></form>';
									} else {
										$action_string .= '<form action="edit_reservation.php" method="POST"><input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input type="hidden" name="number" value="' . $row['number'] . '"><input type="hidden" name="status" value="' . $status . '"><input class="btn action-btn mt10" type="submit" value="Set as ' . ucfirst($status) . '"></form>';
									}
								}

								$first = false;
							}

							$action_string .= '</td>';

							echo '<tr>';
							echo '<td class="table-element">' . $row['number'] . '</td>';
							echo '<td class="table-element">' . $row['room_number'] . '</td>';
							echo '<td class="table-element">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
							echo '<td class="table-element">' . $row['phone_number'] . '</td>';
							echo '<td class="table-element">' . $row['email'] . '</td>';
							echo '<td class="table-element">' . $row['status'] . '</td>';
							echo '<td class="table-element">' . $row['checkin_date'] . '</td>';
							echo '<td class="table-element">' . $row['checkout_date'] . '</td>';
							echo '<td class="table-element">' . $row['pickup_location'] . '</td>';
							echo '<td class="table-element">' . $row['payment_method'] . '</td>';
							echo $action_string;
							echo '</tr>';
						}
					} else {
						echo '<h2>No reservations found!</h2>';
					}
					?>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20 mb10">
							<form action="../../admin_dashboard.php" method="POST">
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn" type="submit" value="Admin Dashboard">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>