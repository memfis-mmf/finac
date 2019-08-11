$(document).ready(function () {
    item = function () {
        $.ajax({
            url: '/get-items/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="item"]').empty();

                $('select[name="item"]').append(
                    '<option value=""> Select a Item</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="item"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    item();
});
