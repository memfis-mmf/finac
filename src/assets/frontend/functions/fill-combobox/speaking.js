$(document).ready(function () {
    speaking = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="speaking"]').empty();

                $('select[name="speaking"]').append(
                    '<option value=""> Select a Speaking Level</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="speaking"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    speaking();
});
