$(document).ready(function () {
    type = function () {
        $.ajax({
            url: '/coa/type',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[id="type"]').empty();

                $('select[id="type"]').append(
                    '<option value=""> Select a Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[id="type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    type();
});
