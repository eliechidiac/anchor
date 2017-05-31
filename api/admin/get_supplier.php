<?php
@include('admin_auth.php');

extract($_POST);

if(!$company_name){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	SELECT *
	FROM food_suppliers
	WHERE company_name = "' . $_POST['company_name'] . '"';

	$item = $connection->query($query)->fetchAll()[0];
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
								<form action="edit_supplier.php" method="POST">
									<input disabled required class="form-control mt10" type="text" placeholder="Company Name" value="<?php echo $item['company_name']; ?>">
									<input required class="form-control mt10" type="email" name="email" placeholder="Email" value="<?php echo $item['email']; ?>">
									<input required class="form-control mt10" type="text" name="phone_number" placeholder="Phone Number" value="<?php echo $item['phone_number']; ?>">
									<input required class="form-control mt10" type="text" name="address" placeholder="Address" value="<?php echo $item['address']; ?>">
									<input type="hidden" name="company_name" value="<?php echo $item['company_name']; ?>">
									<input type="hidden" name="password" value="cmps277">
									<input class="btn navigation-btn mt10" type="submit" value="Submit">
								</form>
							</div>
						</div>
					</div>
					<form class ="mt20" action="menu_dashboard.php?type=all" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>