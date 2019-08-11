$(document).ready(function () {
    TaskcardType = function () {
        $.ajax({
            url: '/get-takcard-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="taskcard_type"]').empty();

                $('select[name="taskcard_type"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="taskcard_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardType();
});
