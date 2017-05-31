<?php
@include('admin_auth.php');

extract($_POST);

if(!$type || !$capacity || !$description || !$info_list || !$price){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	UPDATE room_types
	SET capacity = "' . $_POST['capacity'] . '", description = "' . $_POST['description'] . '", price = "' . $_POST['price'] . '", info_list = "' . $_POST['info_list'] . '"
	WHERE type = "' . ucfirst($_POST['type']) . '"';

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
					<form action="rooms_dashboard.php?type=all" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>