$(document).ready(function () {
    Quotation = function () {
        $.ajax({
            url: '/get-taskcards/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="quotation"]').empty();

                $('select[name="quotation"]').append(
                    '<option value=""> Select a Quotation</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="quotation"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    Quotation();
});
