<?php
@include('common/connection.php');

if( !$_GET['room_type'] || !$_GET['first_name'] || !$_GET['last_name'] || !$_GET['credit_card_number'] || !$_GET['email'] || !$_GET['address'] || !$_GET['phone_number'] || !$_GET['checkin_date'] || !$_GET['checkout_date'] ){
	return var_dump(false);
}

if( !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) ){
	return var_dump(false);
}

if( !is_numeric($_GET['phone_number']) ){
	return var_dump(false);
}

if( !is_numeric($_GET['credit_card_number']) ){
	return var_dump(false);
}

if ( new DateTime($_GET['checkin_date']) < new DateTime() || new DateTime($_GET['checkout_date']) < new DateTime() || new DateTime($_GET['checkout_date']) < new DateTime($_GET['checkin_date']) ){
	return var_dump(false);
}

$room_query = '	
SELECT r.number
FROM rooms AS r
WHERE room_type = "' . $_GET['room_type'] . '" AND NOT EXISTS (SELECT b.room_number
FROM bookings AS b
WHERE b.room_number = r.number AND (b.status = "active" OR b.status = "pending")) 
';

$room_number = $connection->query($room_query)->fetch()[0];

if( $room_number ){
	$person_query = '
	SELECT *
	FROM persons
	WHERE email = "' . $_GET['email'] . '"
	';

	if($connection->query($person_query)->fetch()){
		$person_edit_query = '	
		UPDATE persons
		SET first_name = "' . ucfirst($_GET['first_name']) . '", last_name = "' . ucfirst($_GET['last_name']) . '", address = "' . $_GET['address'] . '", phone_number = "' . $_GET['phone_number'] . '"
		WHERE email = "' . $_GET['email'] . '"';

		$connection->query($person_edit_query);

		$guest_query = '
		SELECT *
		FROM guests
		WHERE person_email = "' . $_GET['email'] . '"
		';

		if($connection->query($guest_query)->fetch()){
			$guest_edit_query = '	
			UPDATE guests
			SET credit_card_number = "' . ucfirst($_GET['credit_card_number']) . '"
			WHERE person_email = "' . $_GET['email'] . '"';

			$connection->query($guest_edit_query);
		} else {
			$guest_create_query = '	
			INSERT INTO guests
			(credit_card_number, person_email)
			VALUES ("' . $_GET['credit_card_number'] . '","' . $_GET['email'] . '")
			';

			$connection->query($guest_create_query);
		}
	} else {
		$person_create_query = '	
		INSERT INTO persons
		VALUES ("' . ucfirst($_GET['first_name']) . '","' . ucfirst($_GET['last_name']) . '","' . $_GET['phone_number'] . '","' . $_GET['address'] . '","' . $_GET['email'] . '")
		';

		$connection->query($person_create_query);

		$guest_create_query = '	
		INSERT INTO guests
		(credit_card_number, person_email)
		VALUES ("' . $_GET['credit_card_number'] . '","' . $_GET['email'] . '")
		';

		$connection->query($guest_create_query);
	}

	$reservation_query = '	
	INSERT INTO reservations
	(pickup_location, checkin_date, checkout_date, payment_method)
	VALUES ("' . $_GET['pickup_location'] . '","' . $_GET['checkin_date'] . '","' . $_GET['checkout_date'] . '","' . $_GET['payment_method'] . '");
	LAST_INSERT_ID();
	';

	$connection->query($reservation_query);
	$reservation_number = $connection->lastInsertId();

	$book_query = '	
	INSERT INTO bookings
	(reservation_number, guest_person_email, room_number, status)
	VALUES ("' . $reservation_number . '","' . $_GET['email'] . '","' . $room_number . '","pending")
	';

	$connection->query($book_query);

	$set_person_active_query = '
	UPDATE guests
	SET active_booking_number = "' . $reservation_number . '"
	WHERE person_email = "' . $_GET['email'] . '"';
	
	$connection->query($set_person_active_query);

	return var_dump(true);
}

return var_dump(false);
?>