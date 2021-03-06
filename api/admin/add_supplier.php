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
	INSERT INTO food_suppliers
	(company_name, phone_number, address, email)
	VALUES ("' . ucfirst($company_name) . '","' . $phone_number . '","' . $address . '","' . $email . '")
	';

	try{ 
		$connection->query($query);
		$message = "Success";
	} 
	catch(PDOException $exception){  
		if($exception->getCode() == 23000){
			$message = "<h2>Food Supplier Already Exists</h2>";
		} else{
			$message = "<h2>Error: " . $exception->getCode() . "</h2>";
		}
	}
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