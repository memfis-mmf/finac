$(document).ready(function () {
    ScheduledPriority = function () {
        $.ajax({
            url: '/get-scheduled-priorities/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="scheduled_priority_id"]').empty();

                $('select[name="scheduled_priority_id"]').append(
                    '<option value=""> Select a Scheduled Priority</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="scheduled_priority_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    ScheduledPriority();
});
