$(document).ready(function () {
    Recurrence = function () {
        $.ajax({
            url: '/get-recurrences/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="recurrence_id"]').empty();

                $('select[name="recurrence_id"]').append(
                    '<option value=""> Select a Recurrence</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="recurrence_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    Recurrence();
});
