<?php
$page = explode('.php', explode('/', $_SERVER[REQUEST_URI])[2])[0];

if( !$page || $page === 'index' ){
	$page = 'home';
}

$id = $page . '-body';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Anchor Beach Resort</title>
	<link rel="stylesheet" type="text/css" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/book.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" type="text/css" href="css/restaurant.css">
	<link rel="stylesheet" type="text/css" href="css/beach.css">
	<link rel="stylesheet" type="text/css" href="css/contact.css">
</head>
<body id="<?=$id?>">
	<div class="navigation-bar">
		<div class="col-sm-5 navigation-bar-logo">
			<img src="images/logo.png">
		</div>
		<a href="index.php">
			<div class="col-sm-offset-1 col-sm-1 navigation-bar-links <?php if( $page === 'home' ){ ?> selected <?php } ?>">
				Home
			</div>
		</a>

		<a href="beach.php">
			<div class="col-sm-1 navigation-bar-links <?php if( $page === 'beach' ){ ?> selected <?php } ?>">
				Beach
			</div>
		</a>

		<a href="restaurant.php">
			<div class="col-sm-1 navigation-bar-links <?php if( $page === 'restaurant' ){ ?> selected <?php } ?>">
				Restaurant
			</div>
		</a>

		<a href="book.php">
			<div class="col-sm-1 navigation-bar-links <?php if( $page === 'book' ){ ?> selected <?php } ?>">
				Book
			</div>
		</a>
		<a href="contact.php">
			<div class="col-sm-1 navigation-bar-links <?php if( $page === 'contact' ){ ?> selected <?php } ?>">
				Contact
			</div>
		</a>
	</div>