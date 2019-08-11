$(document).ready(function () {
    addresses = function () {
        $.ajax({
            url: '/get-address-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="address_type"]').empty();

                $('select[name="address_type"]').append(
                    '<option value=""> Select a Address Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="address_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    addresses();
});
