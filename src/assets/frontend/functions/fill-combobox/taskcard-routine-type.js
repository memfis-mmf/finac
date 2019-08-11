$(document).ready(function () {
    TaskcardRoutineType = function () {
        $.ajax({
            url: '/get-takcard-routine-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="taskcard_routine_type"]').empty();

                $('select[name="taskcard_routine_type"]').append(
                    '<option value=""> Select a Taskcard Routine Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="taskcard_routine_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardRoutineType();
});
