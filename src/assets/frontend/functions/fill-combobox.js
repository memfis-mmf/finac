$(document).ready(function () {
    accountcode_category = function () {
        $.ajax({
            url: '/get-accountcodes/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let angka2 = 1;

                $('select[name="accountcode_category"]').empty();

                $.each(data, function (key, value) {
                    if (angka2 == 1) {
                        $('select[name="accountcode_category"]').append(
                            '<option> Select a Accountcode</option>'
                        );

                        angka2 = 0;
                    }

                    $('select[name="accountcode_category"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    accountcode_category();
});









