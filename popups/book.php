<div id="bookPopup" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Booking</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="bookPopup-error alert alert-danger alert-error"></div>
					</div>	
				</div>
				<div class="row">
					<div class="col-sm-3 bookPopup-labels">First Name</div>
					<div class="col-sm-9"><input type="text" id="first_name" class="form-control" placeholder="First Name"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Last Name</div>
					<div class="col-sm-9"><input type="text" id="last_name" class="form-control" placeholder="LastN ame"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Email</div>
					<div class="col-sm-9"><input type="text" id="email" class="form-control" placeholder="Email"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Address</div>
					<div class="col-sm-9"><textarea id="address" class="form-control bookPopup-textarea" placeholder="Address"></textarea></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Pick Up Location</div>
					<div class="col-sm-9"><input type="text" id="pickup_location" class="form-control" placeholder="Pick Up Location"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Payment Method</div>
					<div class="col-sm-9">
						<select id="payment_method" class="form-control">
							<option value="cash">Cash</option>
							<option value="card">Card</option>
						</select>
					</div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Phone Number</div>
					<div class="col-sm-9"><input type="text" id="phone_number" class="form-control" placeholder="Phone Number"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Check In Date</div>
					<div class="col-sm-9"><input type="date" id="checkin_date" class="form-control"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Check Out Date</div>
					<div class="col-sm-9"><input type="date" id="checkout_date" class="form-control"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Credit Card</div>
					<div class="col-sm-9"><input type="text" id="credit_card_number" class="form-control"></div>
				</div>
				<div class="row bookPopup-rows">
					<div class="col-sm-3 bookPopup-labels">Room Type</div>
					<div class="col-sm-9">
						<select id="room_type" class="form-control" placeholder="Room Type">
							<option value="Single Room">Single Room</option>
							<option value="Double Room">Double Room</option>
							<option value="Junior Suite">Junior Suite</option>
							<option value="Family Suite">Family Suite</option>
							<option value="Grand Suite">Grand Suite</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-borderless" data-dismiss="modal">Cancel</button>
				<button id="bookPopup-btn" type="button" class="btn btn-success">Book</button>
			</div>
		</div>
	</div>
</div>