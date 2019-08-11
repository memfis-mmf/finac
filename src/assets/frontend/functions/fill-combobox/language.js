$(document).ready(function () {
    language = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="language"]').empty();

                $('select[name="language"]').append(
                    '<option value=""> Select a Language</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="language"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    language();
});
