<?php
@include('admin_auth.php');

extract($_POST);

if(!$first_name || !$last_name || !$salary || !$phone_number || !$address || !$email || !$from || !$till){
	$message = "<h2>Missing Data</h2>";
}

if(!$message){
	@include('../common/connection.php');

	$query = '	
	UPDATE persons
	SET first_name = "' . ucfirst($_POST['first_name']) . '", last_name = "' . ucfirst($_POST['last_name']) . '", address = "' . $_POST['address'] . '", phone_number = "' . $_POST['phone_number'] . '"
	WHERE email = "' . $_POST['email'] . '"';

	$connection->query($query);

	$query = '	
	UPDATE employees
	SET working_hours = "' . $_POST['from'] . '-' . $_POST['till'] . '", salary = "' . $_POST['salary'] . '", manager_employee_person_email = "' . $_POST['manager'] . '"
	WHERE person_email = "' . $_POST['email'] . '"';

	$connection->query($query);

	$rooms_numbers = explode(',', $_POST['rooms_numbers']);

	foreach ($rooms as $room){
		if(in_array($room, $rooms_numbers) == false){
			$query = '	
			INSERT INTO cleans
			VALUES ("' . $_POST['email'] . '","' . $room . '")
			';

			try{ 
				$connection->query($query);
			} 
			catch(PDOException $exception){  
				if($exception->getCode() == 23000){
					$message = "<h2>Employee Already Cleans the Room</h2>";
				} else{
					$message = "<h2>Error: " . $exception->getCode() . "</h2>";
				}
			}
		}
	}

	foreach ($rooms_numbers as $room){
		if(in_array($room, $rooms) == false){
			$query = '
			DELETE FROM cleans
			WHERE room_number = "' . $room . '" AND employee_person_email = "' . $email . '"
			';

			$connection->query($query);
		}
	}

	$facilities_names = explode(',', $_POST['facilities_names']);

	foreach ($facilities as $facility){
		if(in_array($facility, $facilities_names) == false){
			$query = '	
			INSERT INTO works
			VALUES ("' . $_POST['email'] . '","' . $facility . '")
			';

			try{ 
				$connection->query($query);
			} 
			catch(PDOException $exception){  
				if($exception->getCode() == 23000){
					$message = "<h2>Employee Already Works in the Facility</h2>";
				} else{
					$message = "<h2>Error: " . $exception->getCode() . "</h2>";
				}
			}
		}
	}

	foreach ($facilities_names as $faciliy_name){
		if(in_array($faciliy_name, $facilities) == false){
			$query = '
			DELETE FROM works
			WHERE facility_name = "' . $faciliy_name . '" AND employee_person_email = "' . $email . '"
			';

			$connection->query($query);
		}
	}

	$message = "Success";
}
?>

<html>
<head>
	<title>Edit Employee</title>
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
					<form action="employees_dashboard.php" method="POST">
						<input type="hidden" name="password" value="cmps277">
						<input class="btn navigation-btn" type="submit" value="Ok">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>