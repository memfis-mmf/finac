$(document).ready(function () {
    RepeatType = function () {
        $.ajax({
            url: '/get-repeat-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="repeat_type"]').empty();

                $('select[name="repeat_type"]').append(
                    '<option value=""> Select a Repeat Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="repeat_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    RepeatType();
});
