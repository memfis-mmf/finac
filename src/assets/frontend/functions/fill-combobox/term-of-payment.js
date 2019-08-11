$(document).ready(function () {
    payment_terms = function () {
        $.ajax({
            url: '/get-payment-term/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="payment_term"]').empty();

                $('select[name="payment_term"]').append(
                    '<option value=""> Select a Payment Term</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="payment_term"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    payment_terms();
});
