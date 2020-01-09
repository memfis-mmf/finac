$(document).ready(function () {
    employee = function () {
        $.ajax({
            url: '/get-employees',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select#employee').empty();

                $('select#employee').append(
                    '<option value=""> Select a Customer </option>'
                );

                $.each(data, function (key, value) {
                    $('select#employee').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    employee();
});
