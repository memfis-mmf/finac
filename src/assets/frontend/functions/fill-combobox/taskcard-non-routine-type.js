$(document).ready(function () {
    TaskcardRoutineNonType = function () {
        $.ajax({
            url: '/get-takcard-non-routine-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="taskcard_non_routine_type"]').empty();

                $('select[name="taskcard_non_routine_type"]').append(
                    '<option value=""> Select a Taskcard Non Routine type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="taskcard_non_routine_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardRoutineNonType();
});
