$(document).ready(function () {
    customerLevel = function () {
        $.ajax({
            url: '/get-customer-level/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="customer-level"]').empty();

                $('select[name="customer-level"]').append(
                    '<option value=""> Select a Level</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="customer-level"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    customerLevel();
});
