$(document).ready(function () {
    TaskcardType = function () {
        $.ajax({
            url: '/get-task-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="task_type_id"]').empty();

                $('select[name="task_type_id"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="task_type_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardType();
});
