$(document).ready(function () {
    TaskcardRelationship = function () {
        $.ajax({
            url: '/get-taskcard-relationships/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="relationship"]').empty();

                $('select[name="relationship"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="relationship"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardRelationship();
});
