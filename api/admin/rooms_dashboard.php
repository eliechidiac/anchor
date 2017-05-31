<?php
@include('admin_auth.php');
@include('../common/connection.php');
if( $_GET['type'] && $_GET['type'] != "all"){
	$query = '
	SELECT *
	FROM rooms
	WHERE room_type = "' . $_GET['type'] . '"
	';
} else {
	$query = '
	SELECT *
	FROM rooms
	';
}

$types_query = '
SELECT *
FROM room_types
';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rooms Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="mt20">
					<h2>Rooms</h2>
					<div class="pull-left mt20">
						<form action="rooms_dashboard.php?type=all" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['type'] == 'all'){ echo 'selected'; } ?>" type="submit" value="All">
						</form>
					</div>
					<?php
					foreach ($connection->query($types_query) as $row) {
						if($_GET['type'] == $row[0]){
							echo '<div class="pull-left mt20 ml10"><form action="rooms_dashboard.php?type=' . $row[0] . '" method="POST"><input type="hidden" name="password" value="cmps277"><input class="btn navigation-btn selected" type="submit" value="' . $row[0] . '"></form></div>';
						}else{
							echo '<div class="pull-left mt20 ml10"><form action="rooms_dashboard.php?type=' . $row[0] . '" method="POST"><input type="hidden" name="password" value="cmps277"><input class="btn navigation-btn" type="submit" value="' . $row[0] . '"></form></div>';
						}
					}
					?>
					<div class="clearfix"></div>
					<div class="clearfix"></div>
					<?php if($connection->query($query)->fetchAll()) { ?>
					<table class="table-striped mt20">
						<tr>
							<td class="table-title">Room Number</td>
							<td class="table-title">Phone Extension</td>
							<td class="table-title">Available</td>
							<td class="table-title">Type</td>
							<td class="table-title">Edit</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							echo '<tr>';
							echo '<td class="table-element">' . $row['number'] . '</td>';
							echo '<td class="table-element">' . $row['phone_extension'] . '</td>';
							if($row['is_available']){
								echo '<td class="table-element">Yes</td>';
							}else{
								echo '<td class="table-element">No</td>';
							}
							echo '<td class="table-element">' . $row['room_type'] . '</td>';
							echo '<td class="table-element text-align: center;"><form action="get_room.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="number" value="' . $row['number'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';
							echo '</tr>';
						}
					} else {
						echo '<h2>No items found!</h2>';
					}
					?>
				</table>
				<h2>Room Types</h2>
				<table class="table-striped mt20">
					<tr>
						<td class="table-title">Type</td>
						<td class="table-title">Capacity</td>
						<td class="table-title">Decription</td>
						<td class="table-title">Price</td>
						<td class="table-title">Info</td>
						<td class="table-title">Edit</td>
					</tr>
					<?php
					foreach ($connection->query($types_query) as $row) {
						echo '<tr>';
						echo '<td class="table-element">' . $row['type'] . '</td>';
						echo '<td class="table-element">' . $row['capacity'] . '</td>';
						echo '<td class="table-element">' . $row['description'] . '</td>';
						echo '<td class="table-element">' . $row['price'] . '</td>';
						echo '<td class="table-element">' . $row['info_list'] . '</td>';
						echo '<td class="table-element text-align: center;"><form action="get_room_type.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="type" value="' . $row['type'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';					
						echo '</tr>';
					}
					?>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add a Room</h2>
							<form action="add_room.php" method="POST">
								<input required class="form-control mt10" type="text" name="number" placeholder="Number">
								<select name="room_type" class="form-control mt10">
									<?php
									foreach ($connection->query($types_query) as $row) {
										echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
									}
									?>
								</select>
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Room">
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add a Room Type</h2>
							<form action="add_room_type.php" method="POST">
								<input required class="form-control mt10" type="text" name="type" placeholder="Type">
								<input required class="form-control mt10" type="number" name="capacity" placeholder="Capacity">
								<input required class="form-control mt10" type="number" name="price" placeholder="Price">
								<textarea required class="form-control mt10" type="text" name="description" placeholder="Description"></textarea>
								<textarea required class="form-control mt10" type="text" name="info_list" placeholder="Information - Seperate the information using a coma ','"></textarea>
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Room Type">
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20 mb10">
							<form action="../../admin_dashboard.php" method="POST">
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn" type="submit" value="Admin Dashboard">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>