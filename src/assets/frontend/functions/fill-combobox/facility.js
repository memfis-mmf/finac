$(document).ready(function () {
    customer = function () {
        $.ajax({
            url: '/get-facilities/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="facility"]').empty();

                $('select[name="facility"]').append(
                    '<option value=""> Select a Facility </option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="facility"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    customer();
});
