$(document).ready(function () {
    reading = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="reading"]').empty();

                $('select[name="reading"]').append(
                    '<option value=""> Select a Reading Level</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="reading"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    reading();
});
