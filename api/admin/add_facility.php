<?php
@include('admin_auth.php');

extract($_POST);
echo $from;
if(!$name || !$rate || $from < 0 || $till < 0){
	$message = "<h2>Missing Data</h2>";
}

if(is_numeric($rate) != 1){
	$message = "<h2>Invalid Rate</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	INSERT INTO facilities
	VALUES ("' . ucfirst($name) . '","' . $from . '-' . $till . '","' . $rate . '")
	';

	try{ 
		$connection->query($query);
		$message = "Success";
	} 
	catch(PDOException $exception){  
		if($exception->getCode() == 23000){
			$message = "<h2>Facility Already Exists</h2>";
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