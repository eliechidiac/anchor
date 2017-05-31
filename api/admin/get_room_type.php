<?php
@include('admin_auth.php');

extract($_POST);

if(!$type){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	SELECT *
	FROM room_types
	WHERE type = "' . $_POST['type'] . '"';

	$type = $connection->query($query)->fetchAll()[0];
}
?>

<html>
<head>
	<title>Edit Room Type</title>
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
								<form action="edit_room_type.php" method="POST">
									<div class="pull-left mt10">Type</div>
									<input disabled required class="form-control mt10" type="text" placeholder="Type" value="<?php echo $type['type']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Capacity</div>
									<input required class="form-control mt10" type="number" name="capacity" placeholder="Capacity" value="<?php echo $type['capacity']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Price</div>
									<input required class="form-control mt10" type="number" name="price" placeholder="Price" value="<?php echo $type['price']; ?>"">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Description</div>
									<textarea required class="form-control mt10" type="text" name="description" placeholder="Description"><?php echo $type['description']; ?></textarea>
									<div class="clearfix"></div>
									<div class="pull-left mt10">Information</div>
									<textarea required class="form-control mt10" type="text" name="info_list" placeholder="Information - Seperate the information using a coma ','"><?php echo $type['info_list']; ?></textarea>
									<input type="hidden" name="type" value="<?php echo $type['type']; ?>">
									<input type="hidden" name="password" value="cmps277">
									<input class="btn navigation-btn mt10" type="submit" value="Submit">
								</form>
							</div>
						</div>
					</div>
					<form class ="mt20" action="rooms_dashboard.php?type=all" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>