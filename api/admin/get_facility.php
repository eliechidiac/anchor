<?php
@include('admin_auth.php');

extract($_POST);

if(!$name){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '
	SELECT *
	FROM facilities
	WHERE name  = "' . $_POST['name'] . '"';

	$facility = $connection->query($query)->fetchAll()[0];
}
?>

<html>
<head>
	<title>Edit Facility</title>
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
								<form action="edit_facility.php" method="POST">
									<input disabled class="form-control mt10" type="text" placeholder="Name" value="<?php echo $facility['name']; ?>">
									<div class="pull-left mt10">Rate</div>
									<div class="clearfix"></div>
									<input required class="form-control mt10" type="number" name="rate" placeholder="Rate" value="<?php echo $facility['rate']; ?>">
									<div class="pull-left mt10">Opening Hours</div>
									<div class="clearfix"></div>
									<div class="row">
										<div class="col-md-6">
											<div class="pull-left">From</div>
											<select name="from" class="form-control mt10">
												<?php
												for($i = 0; $i < 24; $i++){
													if($i == (int)explode('-', $facility['opening_hours'])[0]){
														echo '<option selected value="' . $i . '">' . $i . '</option>';
													} else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-6">
											<div class="pull-left">Till</div>
											<select name="till" class="form-control mt10">
												<?php
												for($i = 0; $i < 24; $i++){
													if($i == (int)explode('-', $facility['opening_hours'])[1]){
														echo '<option selected value="' . $i . '">' . $i . '</option>';
													} else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
									<input type="hidden" name="name" value="<?php echo $facility['name']; ?>">
									<input type="hidden" name="password" value="cmps277">
									<input class="btn navigation-btn mt10" type="submit" value="Submit">
								</form>
							</div>
						</div>
					</div>
					<form class ="mt20" action="facilities_dashboard.php" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>