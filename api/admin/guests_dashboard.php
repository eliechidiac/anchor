<?php
@include('admin_auth.php');
@include('../common/connection.php');
if( $_POST['name'] ){
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	WHERE concat_ws(\' \', p.first_name , p.last_name) LIKE "%' . $_POST['name'] . '%"
	';
} else if( $_POST['email'] ){
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	WHERE p.email LIKE "%' . $_POST['email'] . '%"
	';
} else if( $_POST['booking_number'] ){
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	WHERE g.active_booking_number = "' . $_POST['booking_number'] . '"
	';
} else if( $_GET['status'] && $_GET['status'] == 'active' ){
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	WHERE g.active_booking_number IS NOT NULL
	';
} else if( $_GET['status'] && $_GET['status'] == 'inactive' ){
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	WHERE g.active_booking_number IS NULL
	';
} else {
	$query = '
	SELECT *
	FROM guests AS g
	JOIN persons AS p ON g.person_email = p.email
	';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Guests Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="mt20">
					<h2>Guests</h2>
					<div class="row">
						<div class="col-md-8">
							<h3>Search by Name</h3>
							<form action="guests_dashboard.php" method="POST">
								<div class="pull-left">
									<input required class="form-control mt10" type="text" name="name" placeholder="Name">
								</div>
								<div class="pull-left ml10">
									<input class="btn navigation-btn mt10" type="submit" value="Search">
								</div>
								<div class="clearfix"></div>
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<h3>Search by Email</h3>
							<form action="guests_dashboard.php" method="POST">
								<div class="pull-left">
									<input required class="form-control mt10" type="email" name="email" placeholder="Email">
								</div>
								<div class="pull-left ml10">
									<input class="btn navigation-btn mt10" type="submit" value="Search">
								</div>
								<div class="clearfix"></div>
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<h3>Search by active Booking Number</h3>
							<form action="guests_dashboard.php" method="POST">
								<div class="pull-left">
									<input required class="form-control mt10" type="text" name="booking_number" placeholder="Booking Number">
								</div>
								<div class="pull-left ml10">
									<input class="btn navigation-btn mt10" type="submit" value="Search">
								</div>
								<div class="clearfix"></div>
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<form action="guests_dashboard.php?status=active" method="POST">
								<input class="form-control navigation-btn mt20 <?php if($_GET['status'] && $_GET['status'] == 'active'){ echo "selected"; }?>" type="submit" value="Active Guests">
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
						<div class="col-md-3">
							<form action="guests_dashboard.php?status=inactive" method="POST">
								<input class="form-control navigation-btn mt20 <?php if($_GET['status'] && $_GET['status'] == 'inactive'){ echo "selected"; }?>" type="submit" value="Inactive Guests">
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
						<div class="col-md-3">
							<form action="guests_dashboard.php" method="POST">
								<input class="form-control navigation-btn mt20" type="submit" value="Clear Search">
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
					</div>
					<?php if($connection->query($query)->fetchAll()) { ?>
					<table class="table-striped mt20">
						<tr>
							<td class="table-title">First Name</td>
							<td class="table-title">Last Name</td>
							<td class="table-title">Phone Number</td>
							<td class="table-title">Address</td>
							<td class="table-title">Email</td>
							<td class="table-title">Active Booking Number</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							echo '<tr>';
							echo '<td class="table-element">' . $row['first_name'] . '</td>';
							echo '<td class="table-element">' . $row['last_name'] . '</td>';
							echo '<td class="table-element">' . $row['phone_number'] . '</td>';
							echo '<td class="table-element">' . $row['address'] . '</td>';
							echo '<td class="table-element">' . $row['email'] . '</td>';
							echo '<td class="table-element">' . $row['active_booking_number'] . '</td>';
							echo '</tr>';
						}
					} else {
						echo '<h2>No Guests found!</h2>';
					}
					?>
				</table>
			</div>
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