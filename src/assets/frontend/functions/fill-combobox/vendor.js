$(document).ready(function () {
    vendor = function () {
        $.ajax({
            url: '/get-vendors/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[id="vendor"]').empty();

                $('select[id="vendor"]').append(
                    '<option value=""> Select a Vendor </option>'
                );

                $.each(data, function (key, value) {
                    $('select[id="vendor"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    vendor();
});
