<?php
@include('admin_auth.php');
@include('../common/connection.php');
if( $_POST['name'] ){
	$query = '
	SELECT *
	FROM facilities
	WHERE name LIKE "%' . $_POST['name'] . '%"
	';
} else {
	$query = '
	SELECT *
	FROM facilities
	';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Restaurant Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="mt20">
					<h2>Facilities</h2>
					<div class="row">
						<div class="col-md-8">
							<h3>Search by Name</h3>
							<form action="facilities_dashboard.php" method="POST">
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
						<div class="col-md-3">
							<form action="facilities_dashboard.php" method="POST">
								<input class="form-control navigation-btn mt20" type="submit" value="Clear Search">
								<input type="hidden" name="password" value="cmps277">
							</form>
						</div>
					</div>
					<?php if($connection->query($query)->fetchAll()) { ?>
					<table class="table-striped mt20">
						<tr>
							<td class="table-title">Facility Name</td>
							<td class="table-title">Opening Hours</td>
							<td class="table-title">Rate</td>
							<td class="table-title">Edit</td>
							<td class="table-title">Delete</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							echo '<tr>';
							echo '<td class="table-element">' . $row['name'] . '</td>';
							echo '<td class="table-element">' . $row['opening_hours'] . '</td>';
							echo '<td class="table-element">' . $row['rate'] . '</td>';
							echo '<td class="table-element text-align: center;"><form action="get_facility.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="name" value="' . $row['name'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';
							echo '<td class="table-element text-align: center;"><form action="remove_facility.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="name" value="' . $row['name'] . '"><input class="btn action-btn" type="submit" value="Delete"></form></td>';
							echo '</tr>';
						}
					} else {
						echo '<h2>No items found!</h2>';
					}
					?>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add a Facility</h2>
							<form action="add_facility.php" method="POST">
								<input required class="form-control mt10" type="text" name="name" placeholder="Name">
								<input required class="form-control mt10" type="number" name="rate" placeholder="Rate">
								<div class="pull-left mt10">Opening Hours</div>
								<div class="clearfix"></div>
								<div class="row">
									<div class="col-md-6">
										<div class="pull-left">From</div>
										<select name="from" class="form-control mt10">
											<?php
											for($i = 0; $i < 24; $i++){
												echo '<option value="' . $i . '">' . $i . '</option>';
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<div class="pull-left">Till</div>
										<select name="till" class="form-control mt10">
											<?php
											for($i = 0; $i < 24; $i++){
												echo '<option value="' . $i . '">' . $i . '</option>';
											}
											?>
										</select>
									</div>
								</div>
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Facility">
							</form>
						</div>
					</div>
				</div>
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