<?php
@include('admin_auth.php');

extract($_POST);

if(!$email){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '
	DELETE FROM works
	WHERE employee_person_email = "' . $_POST['email'] . '"
	';

	$connection->query($query);

	$query = '
	DELETE FROM cleans
	WHERE employee_person_email = "' . $_POST['email'] . '"
	';

	$connection->query($query);

	$query = '
	DELETE FROM employees
	WHERE person_email = "' . $_POST['email'] . '"
	';

	$connection->query($query);
	$message = "Success";
}
?>

<html>
<head>
	<title>Delete Employee</title>
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
					<form action="employees_dashboard.php" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>