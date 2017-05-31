<?php
@include('admin_auth.php');

extract($_POST);

if(!$number){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$types_query = '
	SELECT *
	FROM room_types
	';

	$query = '	
	SELECT *
	FROM rooms
	WHERE number = "' . $_POST['number'] . '"';

	$room = $connection->query($query)->fetchAll()[0];
}
?>

<html>
<head>
	<title>Edit Room</title>
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
								<form action="edit_room.php" method="POST">
									<div class="pull-left mt10">Number</div>
									<input disabled class="form-control mt10" type="text" placeholder="Number" value="<?php echo $room['number']; ?>">
									<div class="clearfix"></div>
									<div class="pull-left mt10">Phone Extension</div>
									<input disabled class="form-control mt10" type="text" name="phone_extension" placeholder="Phone Extension" value="<?php echo $room['phone_extension']; ?>">
									<div class="clearfix"></div>
									<select name="is_available" class="form-control mt10">
										<?php
										if($room['is_available']){
											echo '<option selected value="1">Available</option>';
											echo '<option value="0">Not Available</option>';
										} else {
											echo '<option value="1">Available</option>';
											echo '<option selected value="0">Not Available</option>';
										}
										?>
									</select>
									<div class="pull-left mt10">Type</div>
									<select name="room_type" class="form-control mt10">
										<?php
										foreach ($connection->query($types_query) as $row) {
											if($row[0] == $room['room_type']){
												echo '<option selected value="' . $row[0] . '">' . $row[0] . '</option>';
											} else {
												echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
											}
										}
										?>
									</select>
									<input type="hidden" name="number" value="<?php echo $room['number']; ?>">
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