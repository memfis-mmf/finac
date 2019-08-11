$(document).ready(function () {
    Taskcard = function () {
        $.ajax({
            url: '/get-taskcards/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="taskcard"]').empty();

                $('select[name="taskcard"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="taskcard"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    Taskcard();
});
