$(document).ready(function () {
    customer = function () {
        $.ajax({
            url: '/get-customers/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="customer"]').empty();

                $('select[name="customer"]').append(
                    '<option value=""> Select a Customer </option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="customer"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    customer();
});
