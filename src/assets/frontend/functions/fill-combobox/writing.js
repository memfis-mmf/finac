$(document).ready(function () {
    writinng = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="writing"]').empty();

                $('select[name="writing"]').append(
                    '<option value=""> Select a Writing Level</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="writing"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    writinng();
});
