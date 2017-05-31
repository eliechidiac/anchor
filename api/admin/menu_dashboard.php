<?php
@include('admin_auth.php');
@include('../common/connection.php');

if( $_GET['type'] != "all" ){
	$query = '
	SELECT *
	FROM foods
	WHERE type = "' . $_GET['type'] . '"
	';
} else {
	$query = '
	SELECT *
	FROM foods
	ORDER BY type ASC
	';
}

$types_query = '
SELECT SUBSTRING(COLUMN_TYPE,5)
FROM information_schema.COLUMNS
WHERE 
TABLE_NAME = "foods" AND 
COLUMN_NAME = "type"
';

$types = explode(",", str_replace('\'', '', str_replace(')', '', str_replace('(', '', $connection->query($types_query)->fetchAll()[0][0]))));

$suppliers_names_query = '
SELECT company_name
FROM food_suppliers
';

$suppliers_names = [];

foreach ($connection->query($suppliers_names_query)->fetchAll() as $supplier_name){
	array_push($suppliers_names, $supplier_name[0]);
}

$suppliers_query = '
SELECT *
FROM food_suppliers
';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Restaurant Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/api/menu.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="mt20">
					<h2>Items on the Menu</h2>
					<div class="pull-left mt20">
						<form action="menu_dashboard.php?type=all" method="POST">
							<input type="hidden" name="password" value="cmps277">
							<input class="btn navigation-btn <?php if($_GET['type'] == 'all'){ echo 'selected'; } ?>" type="submit" value="All">
						</form>
					</div>
					<?php
					foreach ($types as $type) {
						if($_GET['type'] == $type){
							echo '<div class="pull-left mt20 ml10"><form action="menu_dashboard.php?type=' . $type . '" method="POST"><input type="hidden" name="password" value="cmps277"><input class="btn navigation-btn selected" type="submit" value="' . ucfirst($type) . '"></form></div>';
						}else{
							echo '<div class="pull-left mt20 ml10"><form action="menu_dashboard.php?type=' . $type . '" method="POST"><input type="hidden" name="password" value="cmps277"><input class="btn navigation-btn" type="submit" value="' . ucfirst($type) . '"></form></div>';
						}
					}
					?>
					<div class="clearfix"></div>
					<?php if($connection->query($query)->fetchAll()) { ?>
					<table class="table-striped mt20">
						<tr>
							<td class="table-title">Name</td>
							<?php if( $_GET['type'] != "drinks" ){ echo '<td class="table-title">Description</td>'; } ?>
							<td class="table-title">Price</td>
							<?php if( $_GET['type'] == "all" ){ echo '<td class="table-title">Type</td>'; } ?>
							<td class="table-title">Food Supplier</td>
							<td class="table-title">Edit</td>
							<td class="table-title">Delete</td>
						</tr>
						<?php
						foreach ($connection->query($query) as $row) {
							echo '<tr>';
							echo '<td class="table-element">' . $row['name'] . '</td>';
							if( $_GET['type'] != "drinks" ){
								echo '<td class="table-element">' . $row['description'] . '</td>';
							}
							echo '<td class="table-element">' . $row['price'] . '</td>';
							if( $_GET['type'] == "all" ){
								echo '<td class="table-element">' . $row['type'] . '</td>';
							}
							echo '<td class="table-element">' . $row['food_supplier'] . '</td>';
							echo '<td class="table-element text-align: center;"><form action="get_item.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="name" value="' . $row['name'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';
							echo '<td class="table-element text-align: center;"><form action="remove_item.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="name" value="' . $row['name'] . '"><input class="btn action-btn" type="submit" value="Delete"></form></td>';
							echo '</tr>';
						}
					} else {
						echo '<h2>No items found!</h2>';
					}
					?>
				</table>
				<h2>Food Suppliers</h2>
				<table class="table-striped mt20">
					<tr>
						<td class="table-title">Company Name</td>
						<td class="table-title">Phone Number</td>
						<td class="table-title">Email</td>
						<td class="table-title">Address</td>
						<td class="table-title">Edit</td>
					</tr>
					<?php
					foreach ($connection->query($suppliers_query) as $row) {
						echo '<tr>';
						echo '<td class="table-element">' . $row['company_name'] . '</td>';
						echo '<td class="table-element">' . $row['phone_number'] . '</td>';
						echo '<td class="table-element">' . $row['email'] . '</td>';
						echo '<td class="table-element">' . $row['address'] . '</td>';
						echo '<td class="table-element text-align: center;"><form action="get_supplier.php" method="POST">' . '<input type="hidden" name="password" value="cmps277"><input type="hidden" name="company_name" value="' . $row['company_name'] . '"><input class="btn action-btn" type="submit" value="Edit"></form></td>';					
						echo '</tr>';
					}
					?>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add an Item to the Menu</h2>
							<form action="add_item.php" method="POST">
								<input required class="form-control mt10" type="text" name="name" placeholder="Name">
								<textarea class="form-control mt10" type="text" name="description" placeholder="Description"></textarea>
								<input required class="form-control mt10" type="number" step="0.1" name="price" placeholder="Price">
								<select name="food_supplier" class="form-control mt10">
									<?php
									foreach ($suppliers_names as $supplier_name) {
										echo '<option value="' . $supplier_name . '">' . $supplier_name . '</option>';
									}
									?>
								</select>
								<select name="type" class="form-control mt10">
									<?php
									foreach ($types as $type) {
										echo '<option value="' . $type . '">' . ucfirst($type) . '</option>';
									}
									?>
								</select>
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Item">
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add a Food Type</h2>
							<form action="add_type.php" method="POST">
								<input required class="form-control mt10" type="text" name="type" placeholder="Type">
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Type">
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mt20">
							<h2>Add a Food Supplier</h2>
							<form action="add_supplier.php" method="POST">
								<input required class="form-control mt10" type="text" name="company_name" placeholder="Company Name">
								<input required class="form-control mt10" type="email" name="email" placeholder="Email">
								<input required class="form-control mt10" type="text" name="phone_number" placeholder="Phone Number">
								<input required class="form-control mt10" type="text" name="address" placeholder="Address">
								<input type="hidden" name="password" value="cmps277">
								<input class="btn navigation-btn mt10" type="submit" value="Add Food Supplier">
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