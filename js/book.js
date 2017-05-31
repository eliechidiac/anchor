(function() {
    "use strict";

    var ajax = new XMLHttpRequest();

    $('.book-rooms-button').on('click', function(event) {
        openBook(event);
    });

    $('#bookPopup-btn').on('click', function(event) {
        bookNow();
    });

    var openBook = function(event) {
        event.preventDefault();
        var $el = $(event.currentTarget);
        var room_type = $el.data('room-type');
        $('#room_type').val(room_type);
        $('#bookPopup').modal('show');
    }

    var bookNow = function() {
        var first_name = $('#first_name').val(),
        last_name = $('#last_name').val(),
        address = $('#address').val(),
        phone_number = $('#phone_number').val(),
        email = $('#email').val(),
        credit_card_number = $('#credit_card_number').val(),
        checkin_date = $('#checkin_date').val(),
        checkout_date = $('#checkout_date').val(),
        room_type = $('#room_type').val(),
        payment_method = $('#payment_method').val(),
        pickup_location = $('#pickup_location').val();

        if (!first_name || !last_name || !payment_method  || !address  || !phone_number || !email || !credit_card_number || !checkin_date || !checkout_date || !room_type) {
            return $('.bookPopup-error').html('Please fill in all the required fields.').show();
        }

        if (new Date(checkin_date) < new Date() || new Date(checkout_date) < new Date() || new Date(checkin_date) > new Date(checkout_date)) {
            return $('.bookPopup-error').html('Invalid date.').show();
        }

        if (!emailValid(email)) {
            return $('.bookPopup-error').html('Invalid email.').show();
        }

        if (phone_number != parseInt(phone_number)) {
            return $('.bookPopup-error').html('Invalid phone number.').show();
        }

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                var response = ajax.responseText;

                if (!response) {
                    return $('.bookPopup-error').html('No rooms of that type are available at the moment.').show();
                }

                $('.bookPopup-error').hide();
                $('#name').val('');
                $('#phone').val('');
                $('#email').val('');
                $('#date').val('');
                $('#bookPopup').modal('hide');
                $('#bookSuccessPopup').modal('show');
            }
        }

        if(pickup_location){
            ajax.open('POST', 'api/book.php?room_type=' + room_type + '&payment_method=' + payment_method + '&first_name=' + first_name.toLowerCase() + '&last_name=' + last_name.toLowerCase() + '&pickup_location=' + pickup_location + '&email=' + email + '&credit_card_number=' + credit_card_number + '&address=' + address + '&checkout_date=' + checkout_date + '&phone_number=' + phone_number + '&checkin_date=' + checkin_date, true);
        } else {
            ajax.open('POST', 'api/book.php?room_type=' + room_type + '&payment_method=' + payment_method + '&first_name=' + first_name.toLowerCase() + '&last_name=' + last_name.toLowerCase() + '&email=' + email + '&credit_card_number=' + credit_card_number + '&address=' + address + '&checkout_date=' + checkout_date + '&phone_number=' + phone_number + '&checkin_date=' + checkin_date, true);
        }

        ajax.send(null);
    }

    var emailValid = function(email) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(email);
    };

})();