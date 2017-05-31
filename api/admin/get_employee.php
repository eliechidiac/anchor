<?php
@include('admin_auth.php');

extract($_POST);

if(!$email){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	SELECT number
	FROM rooms';

	$rooms = [];

	foreach ($connection->query($query) as $row){
		array_push($rooms, $row[0]);
	}

	$query = '	
	SELECT name
	FROM facilities';

	$facilities = [];

	foreach ($connection->query($query) as $row){
		array_push($facilities, $row[0]);
	}

	$employees_query = '	
	SELECT p.email, p.first_name, p.last_name
	FROM employees AS e
	JOIN persons AS p ON e.person_email = p.email
	WHERE p.email  <> "' . $_POST['email'] . '"';

	$query = '
	SELECT e.*, p.*, m.email AS manager_email, m.first_name AS manager_first_name, m.last_name AS manager_last_name, GROUP_CONCAT(DISTINCT w.facility_name) facilities_names, GROUP_CONCAT(DISTINCT c.room_number) rooms_numbers
	FROM employees AS e
	JOIN persons AS p ON e.person_email =  p.email
	LEFT JOIN persons AS m ON e.manager_employee_person_email =  m.email
	LEFT JOIN works AS w ON p.email =  w.employee_person_email
	LEFT JOIN cleans AS c ON p.email =  c.employee_person_email
	WHERE p.email  = "' . $_POST['email'] . '"';

	$employee = $connection->query($query)->fetchAll()[0];
}
?>

<html>
<head>
	<title>Edit Item</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="12">
				<div class="mt20 center">
					<h2><?php if($message){ echo $message; } else { echo 'Edit'; }?></h2>
					<div class="row">
						<div class="col-md-offset-3 col-md-6">
							<div class="mt20">
								<form action="edit_employee.php" method="POST">
									<div class="pull-left">First Name</div>
									<input required class="form-control mt10" type="text" name="first_name" placeholder="First Name" value="<?php echo $employee['first_name']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Last Name</div>
									<input required class="form-control mt10" type="text" name="last_name" placeholder="Last Name" value="<?php echo $employee['last_name']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Phone Number</div>
									<input required class="form-control mt10" type="text" name="phone_number" placeholder="Phone Number" value="<?php echo $employee['phone_number']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Address</div>
									<textarea class="form-control mt10" type="text" name="address" placeholder="Address"><?php echo $employee['address']; ?></textarea>
									<div class="clearfix"></div>
									<div class="pull-left mt10">Email</div>
									<input disabled class="form-control mt10" type="text" placeholder="Email" value="<?php echo $employee['email']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Salary</div>
									<input required class="form-control mt10" type="text" name="salary" placeholder="Salary" value="<?php echo $employee['salary']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Working Hours</div>
									<div class="clearfix"></div>
									<div class="row">
										<div class="col-md-6">
											<div class="pull-left">From</div>
											<select name="from" class="form-control mt10">
												<?php
												for($i = 0; $i < 24; $i++){
													if($i == (int)explode('-', $employee['working_hours'])[0]){
														echo '<option selected value="' . $i . '">' . $i . '</option>';
													} else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
												?>
											</select>
											<div class="clearfix"></div>
										</div>
										<div class="col-md-6">
											<div class="pull-left">Till</div>
											<select name="till" class="form-control">
												<?php
												for($i = 0; $i < 24; $i++){
													if($i == (int)explode('-', $employee['working_hours'])[1]){
														echo '<option selected value="' . $i . '">' . $i . '</option>';
													} else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
												?>
											</select>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="pull-left mt10">Manager</div>
									<select name="manager" class="form-control mt10">
										<option value=""></option>
										<?php
										foreach ($connection->query($employees_query) as $row) {
											if($row['email'] == $employee['manager_email']){
												echo '<option selected value="' . $row['email'] . '">' . $row['first_name'] . '</option>';
											} else {
												echo '<option value="' . $row['email'] . '">' . $row['first_name'] . '</option>';
											}
										}
										?>
									</select>
									<div class="clearfix"></div>
									<div class="pull-left mt10">Cleans</div>
									<select multiple name="rooms[]" class="form-control mt10">
										<?php
										foreach ($rooms as $room) {
											if(strpos($employee['rooms_numbers'], $room) !== false){
												echo '<option selected value="' . $room . '">' . $room . '</option>';
											} else {
												echo '<option value="' . $room . '">' . $room . '</option>';
											}
										}
										?>
									</select>
									<div class="clearfix"></div>
									<div class="pull-left mt10">Works In</div>
									<select multiple name="facilities[]" class="form-control mt10">
										<?php
										foreach ($facilities as $facility) {
											if(strpos($employee['facilities_names'], $facility) !== false){
												echo '<option selected value="' . $facility . '">' . $facility . '</option>';
											} else{
												echo '<option value="' . $facility . '">' . $facility . '</option>';
											}
										}
										?>
									</select>
									<input type="hidden" name="rooms_numbers" value="<?php echo $employee['rooms_numbers']; ?>">
									<input type="hidden" name="facilities_names" value="<?php echo $employee['facilities_names']; ?>">
									<input type="hidden" name="email" value="<?php echo $employee['email']; ?>">
									<input type="hidden" name="password" value="cmps277">
									<input class="btn navigation-btn mt10" type="submit" value="Submit">
								</form>
							</div>
						</div>
					</div>
					<form class ="mt20" action="employees_dashboard.php" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>