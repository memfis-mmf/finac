$(document).ready(function () {
    TaskcardType = function () {
        $.ajax({
            url: '/get-zones/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="zone"]').empty();

                $('select[name="zone"]').append(
                    '<option value=""> Select a Taskcard</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="zone"]').append(
                        '<option value="' + value + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardType();
});
