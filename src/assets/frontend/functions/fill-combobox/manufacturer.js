$(document).ready(function () {
    manufacturer = function () {
        $.ajax({
            url: '/get-manufacturers/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="manufacturer_id"]').empty();

                $('select[name="manufacturer_id"]').append(
                    '<option value=""> Select a Manufacturer</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="manufacturer_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    manufacturer();
});
