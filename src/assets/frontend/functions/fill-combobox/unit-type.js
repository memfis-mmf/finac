$(document).ready(function () {
    unitTypes = function () {
        $.ajax({
            url: '/get-unit-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="type_id"]').empty();

                $('select[name="type_id"]').append(
                    '<option value=""> Select a Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="type_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    unitTypes();
});
