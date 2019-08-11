$(document).ready(function () {
    accountcode = function () {
        $.ajax({
            url: '/get-accountcodes/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="accountcode"]').empty();

                $('select[name="accountcode"]').append(
                    '<option value=""> Select a Accountcode</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="accountcode"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    accountcode();
});
