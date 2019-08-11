$(document).ready(function () {
    TaskcardType = function () {
        $.ajax({
            url: '/get-accesses/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="access"]').empty();

                $('select[name="access"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="access"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardType();
});
