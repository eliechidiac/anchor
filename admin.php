<!DOCTYPE html>
<html>
<head>
	<title>Admin Authentication</title>
	<link rel="stylesheet" type="text/css" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/api/common.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<form action="admin_dashboard.php" method="POST" id="adminAccessForm">
					<input id="adminAccessPass" type="password" name="password" class="form-control mt20">
					<button class="form-control action-btn mt20" id="adminAccess">Admin Access</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>