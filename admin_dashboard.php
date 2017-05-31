<?php @include('api/admin/admin_auth.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/api/common.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="mt20">
					<form action="api/admin/reservations_dashboard.php?status=all" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Hotel Reservations">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<div class="mt10">
					<form action="api/admin/rooms_dashboard.php?type=all" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Hotel Rooms">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<div class="mt10">
					<form action="api/admin/menu_dashboard.php?type=all" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Restaurant Dashboard">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<div class="mt10">
					<form action="api/admin/facilities_dashboard.php?type=all" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Facilities Dashboard">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<div class="mt10">
					<form action="api/admin/guests_dashboard.php" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Hotel Guests">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<div class="mt10">
					<form action="api/admin/employees_dashboard.php" method="POST">
						<input class="form-control navigation-btn" type="submit" value="Hotel Employees">
						<input type="hidden" name="password" value="cmps277">
					</form>
				</div>
				<a href="/anchor">
					<div class="mt10">
						<input class="form-control navigation-btn" type="submit" value="Exit">
					</div>
				</a>
			</div>
		</div>
	</div>
</body>
</html>
