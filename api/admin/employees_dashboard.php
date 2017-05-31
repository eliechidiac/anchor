<?php
@include('admin_auth.php');
@include('../common/connection.php');
if( $_POST['name'] ){
	$query = '
	SELECT e.*, p.*, m.first_name AS manager_first_name, m.last_name AS manager_last_name, GROUP_CONCAT(DISTINCT w.facility_name) facilities_names, GROUP_CONCAT(DISTINCT c.room_number) rooms_numbers
	FROM employees AS e
	JOIN persons AS p ON e.person_email =  p.email
	LEFT JOIN persons AS m ON e.manager_employee_person_email =  m.email
	LEFT JOIN works AS w ON p.email =  w.employee_person_email
	LEFT JOIN cleans AS c ON p.email =  c.employee_person_email
	WHERE concat_ws(\' \', p.first_name , p.last_name) LIKE "%' . $_POST['name'] . '%"
	GROUP BY p.email DESC';
} else if( $_POST['email'] ){
	$query = '
	SELECT e.*, p.*, m.first_name AS manager_first_name, m.last_name AS manager_last_name, GROUP_CONCAT(DISTINCT w.facility_name) facilities_names, GROUP_CONCAT(DISTINCT c.room_number) rooms_numbers
	FROM employees AS e
	JOIN persons AS p ON e.person_email =  p.email
	LEFT JOIN persons AS m ON e.manager_employee_person_email =  m.email
	LEFT JOIN works AS w ON p.email =  w.employee_person_email
	LEFT JOIN cleans AS c ON p.email =  c.employee_person_email
	WHERE p.email LIKE "%' . $_POST['email'] . '%"
	GROUP BY p.email DESC';
} else {
	$query = '
	SELECT e.*, p.*, m.first_name AS manager_first_name, m.last_name AS manager_last_name, GROUP_CONCAT(DISTINCT w.facility_name) facilities_names, GROUP_CONCAT(DISTINCT c.room_number) rooms_numbers
	FROM employees AS e
	JOIN persons AS p ON e.person_email =  p.email
	LEFT JOIN persons AS m ON e.manager_employee_person_email =  m.email
	LEFT JOIN works AS w ON p.email =  w.employee_person_email
	LEFT JOIN cleans AS c ON p.email =  c.employee_person_email
	GROUP BY p.email DESC';
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
					<h2>Employees</h2>
					<div class="row">
						<div class="col-md-8">
							<h3>Search by Name</h3>
							<form action="employees_dashboard.php" method="POST">
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
							<form action="employees_dashboard.php" method="POST">
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
						<div class="col-md-3">
							<form action="employees_dashboard.php" method="POST">
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
							<td class="table-title">Working Hours</td>
							<td class="table-title">Manager</td>
							<td class="table-title">Cleans</td>
							<td class="table-title">Works In</td>
							<td class="table-title">Salary</td>
							<td class="table-title">Edit</td>
							<td class="table-title">Delete</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							echo '<tr>';
							echo '<td class="table-element">' . $row['first_name'] . '</td>';
							echo '<td class="table-element">' . $row['last_name'] . '</td>';
							echo '<td class="table-element">' . $row['phone_number'] . '</td>';
							echo '<td class="table-element">' . $row['address'] . '</td>';
							echo '<td class="table-element">' . $row['email'] . '</td>';
							echo '<td class="table-element">' . $row['working_hours'] . '</td>';
							echo '<td class="table-element">' . $row['manager_first_name'] . ' ' . $row['manager_last_name'] . '</td>';
							echo '<td class="table-element">' . str_replace(',', ', ', $row['rooms_numbers']) . '</td>';
							echo '<td class="table-element">' . str_replace(',', ', ', $row['facilities_names']) . '</td>';
							echo '<td class="table-element">' . $row['salary'] . '</td>';
							echo '<td class="table-element text-align: center;"><form action="get_employee.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';
							echo '<td class="table-element text-align: center;"><form action="remove_employee.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="email" value="' . $row['email'] . '"><input class="btn action-btn" type="submit" value="Delete"></form></td>';
							echo '</tr>';
						}
					} else {
						echo '<h2>No employees found!</h2>';
					}
					?>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add an Employee</h2>
							<form action="add_employee.php" method="POST">
								<input required class="form-control mt10" type="text" name="first_name" placeholder="First Name">
								<input required class="form-control mt10" type="text" name="last_name" placeholder="Last Name">
								<input required class="form-control mt10" type="email" name="email" placeholder="Email">
								<input required class="form-control mt10" type="" name="phone_number" placeholder="Phone Number">
								<textarea required class="form-control mt10" type="text" name="address" placeholder="Address"></textarea>
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Employee">
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