$(document).ready(function () {
    units = function () {
        $.ajax({
            url: '/get-scheduled-payment-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="scheduled_payment_type"]').empty();

                $('select[name="scheduled_payment_type"]').append(
                    '<option value=""> Select a Scheduled Payment Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="scheduled_payment_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    units();
});
