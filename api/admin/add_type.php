<?php
@include('admin_auth.php');

extract($_POST);

if(!$type){
	$message = "<h2>Missing Data</h2>";
}

@include('../common/connection.php');

$types_query = '
SELECT SUBSTRING(COLUMN_TYPE,5)
FROM information_schema.COLUMNS
WHERE 
TABLE_NAME = "foods" AND 
COLUMN_NAME = "type"
';

$types = str_replace(')', '', $connection->query($types_query)->fetchAll()[0][0]);

if(substr_count($types, strtolower($_POST['type']))){
	$message = 'Type Already Exists';
}

if(!$message){
	$types = $types . ",'" . strtolower($_POST['type']) . "')";

	$query = '
	ALTER TABLE foods
	CHANGE type
	type 
	ENUM' . $types;

	$connection->query($query);
	$message = 'Success';
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