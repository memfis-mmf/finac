$(document).ready(function () {
    customer = function () {
        $.ajax({
            url: '/get-employees-data/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="received-by"]').empty();

                $('select[name="received-by"]').append(
                    '<option value=""> Select a Received By </option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="received-by"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    customer();
});
