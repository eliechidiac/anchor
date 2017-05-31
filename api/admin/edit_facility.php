<?php
@include('admin_auth.php');

extract($_POST);

if(!$name || !$rate || !$from || !$till){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	UPDATE facilities
	SET opening_hours = "' . $_POST['from'] . '-' . $_POST['till'] . '", rate = "' . $_POST['rate'] . '"
	WHERE name = "' . $_POST['name'] . '"
	';

	$connection->query($query);

	$message = "Success";
}
?>

<html>
<head>
	<title>Edit Facility</title>
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
					<form action="facilities_dashboard.php" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>