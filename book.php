<?php 

@include('api/common/connection.php');

$query = '
	SELECT *
	FROM room_types
	WHERE type = "Single Room"
';

$single_room = $connection->query($query)->fetchAll()[0];
$single_room['info_list'] = explode(',', $single_room['info_list']);

$query = '
	SELECT *
	FROM room_types
	WHERE type = "Double Room"
';

$double_room = $connection->query($query)->fetchAll()[0];
$double_room['info_list'] = explode(',', $double_room['info_list']);

$query = '
	SELECT *
	FROM room_types
	WHERE type = "Junior Suite"
';

$junior_suite = $connection->query($query)->fetchAll()[0];
$junior_suite['info_list'] = explode(',', $junior_suite['info_list']);

$query = '
	SELECT *
	FROM room_types
	WHERE type = "Family Suite"
';

$family_suite = $connection->query($query)->fetchAll()[0];
$family_suite['info_list'] = explode(',', $family_suite['info_list']);

$query = '
	SELECT *
	FROM room_types
	WHERE type = "Grand Suite"
';

$grand_suite = $connection->query($query)->fetchAll()[0];
$grand_suite['info_list'] = explode(',', $grand_suite['info_list']);

include("header.php") 

?>

<div id="book-container" class="container-fluid">
	<div class="row">
		<div class="book-title">
			Anchor Beach Resort Accomodation
		</div>
		<div class="col-sm-offset-1 col-sm-5">
			<div class="book-rooms">
				<div class="book-rooms-title single">
					<?php echo $single_room['type']; ?>
				</div>
				<div class="book-rooms-info">
					<p><?php echo $single_room['description']; ?></p>
					<ul>
						<?php
						foreach ($single_room['info_list'] as $info) {
							echo "<li>" . $info . "</li>";
						}
						?>
					</ul>
					<p>$<?php echo $single_room['price']; ?> per night (Paid at check in)</p>
				</div>
				<div data-room-type="<?php echo $single_room['type']; ?>" class="book-rooms-button">
					<div class="btn">Book Now</div>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="book-rooms">
				<div class="book-rooms-title double">
					<?php echo $double_room['type']; ?>
				</div>
				<div class="book-rooms-info">
					<p><?php echo $double_room['description']; ?></p>
					<ul>
						<?php
						foreach ($double_room['info_list'] as $info) {
							echo "<li>" . $info . "</li>";
						}
						?>
					</ul>
					<p>$<?php echo $double_room['price']; ?> per night (Paid at check in)</p>
				</div>
				<div data-room-type="<?php echo $double_room['type']; ?>" class="book-rooms-button">
					<div class="btn">Book Now</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-5">
			<div class="book-rooms">
				<div class="book-rooms-title junior">
					<?php echo $junior_suite['type']; ?>
				</div>
				<div class="book-rooms-info">
					<p><?php echo $junior_suite['description']; ?></p>
					<ul>
						<?php
						foreach ($junior_suite['info_list'] as $info) {
							echo "<li>" . $info . "</li>";
						}
						?>
					</ul>
					<p>$<?php echo $junior_suite['price']; ?> per night (Paid at check in)</p>
				</div>
				<div data-room-type="<?php echo $junior_suite['type']; ?>" class="book-rooms-button">
					<div class="btn">Book Now</div>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="book-rooms">
				<div class="book-rooms-title family">
					<?php echo $family_suite['type']; ?>
				</div>
				<div class="book-rooms-info">
					<p><?php echo $family_suite['description']; ?></p>
					<ul>
						<?php
						foreach ($family_suite['info_list'] as $info) {
							echo "<li>" . $info . "</li>";
						}
						?>
					</ul>
					<p>$<?php echo $family_suite['price']; ?> per night (Paid at check in)</p>
				</div>
				<div data-room-type="<?php echo $family_suite['type']; ?>" class="book-rooms-button">
					<div class="btn">Book Now</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10">
			<div class="book-rooms">
				<div class="book-rooms-title grand">
					<?php echo $grand_suite['type']; ?>
				</div>
				<div class="book-rooms-info">
					<p><?php echo $grand_suite['description']; ?></p>
					<ul>
						<?php
						foreach ($grand_suite['info_list'] as $info) {
							echo "<li>" . $info . "</li>";
						}
						?>
					</ul>
					<p>$<?php echo $grand_suite['price']; ?> per night (Paid at check in)</p>
				</div>
				<div data-room-type="<?php echo $grand_suite['type']; ?>" class="book-rooms-button">
					<div class="btn">Book Now</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php") ?>
