$(document).ready(function () {
    type = function () {
        $.ajax({
            url: '/type',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="type"]').empty();

                $('select[name="type"]').append(
                    '<option value=""> Select a Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    type();
});
