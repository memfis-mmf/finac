$(document).ready(function () {
    currencyfa = function () {
        $.ajax({
            url: '/currencyfa/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[id="currency"], select[class*="currency"]').empty();

                $('select[id="currency"], select[class*="currency"]').append(
                    '<option value=""> Select a Currency</option>'
                );

                $.each(data, function (key, value) {
                    $('select[id="currency"], select[class*="currency"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    currencyfa();
});
