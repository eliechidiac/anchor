<?php
@include('admin_auth.php');

extract($_POST);

if(!$company_name || !$phone_number || !$address || !$email){
	$message = "<h2>Missing Data</h2>";
}

if(is_numeric($phone_number) != 1){
	$message = "<h2>Invalid Phone Number</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	UPDATE food_suppliers
	SET email = "' . $_POST['email'] . '", phone_number = "' . $_POST['phone_number'] . '", address = "' . $_POST['address'] . '"
	WHERE company_name = "' . ucfirst($_POST['company_name']) . '"';

	$connection->query($query);
	$message = "Success";
}
?>

<html>
<head>
	<title>Delete Item</title>
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
					<form action="menu_dashboard.php?type=all" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>