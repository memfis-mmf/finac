$(document).ready(function () {
    vendor = function () {
        $.ajax({
            url: '/get-vendors/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="vendor"]').empty();

                $('select[name="vendor"]').append(
                    '<option value=""> Select a Vendor </option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="vendor"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    vendor();
});
