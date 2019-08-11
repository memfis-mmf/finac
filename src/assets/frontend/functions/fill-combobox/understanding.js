$(document).ready(function () {
    understanding = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="understanding"]').empty();

                $('select[name="understanding"]').append(
                    '<option value=""> Select a Understanding Level</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="understanding"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    understanding();
});
