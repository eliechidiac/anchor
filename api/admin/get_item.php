<?php
@include('admin_auth.php');

extract($_POST);

if(!$name){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

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

	$query = '	
	SELECT *
	FROM foods
	WHERE name = "' . $_POST['name'] . '"';

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
								<form action="edit_item.php" method="POST">
									<input required class="form-control mt10" type="text" name="name" placeholder="Name" value="<?php echo $item['name']; ?>">
									<textarea class="form-control mt10" type="text" name="description" placeholder="Description"><?php echo $item['description']; ?></textarea>
									<input required class="form-control mt10" type="number" step="0.1" name="price" placeholder="Price" value="<?php echo $item['price']; ?>"">
									<select name="food_supplier" class="form-control mt10">
										<?php
										foreach ($suppliers_names as $supplier_name) {
											if($supplier_name == $item['food_supplier']){
												echo '<option value="' . $supplier_name . '" selected>' . $supplier_name . '</option>';
											} else {
												echo '<option value="' . $supplier_name . '">' . $supplier_name . '</option>';
											}
										}
										?>
									</select>
									<select name="type" class="form-control mt10">
										<?php
										foreach ($types as $type) {
											if($type == $item['type']){
												echo '<option value="' . $type . '" selected>' . ucfirst($type) . '</option>';
											} else {
												echo '<option value="' . $type . '">' . ucfirst($type) . '</option>';
											}
										}
										?>
									</select>
									<input type="hidden" name="original_name" value="<?php echo $item['name']; ?>">
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