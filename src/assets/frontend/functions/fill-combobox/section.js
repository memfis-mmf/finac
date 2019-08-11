$(document).ready(function () {
    TaskcardType = function () {
        $.ajax({
            url: '/get-zones/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="section"]').empty();

                $('select[name="section"]').append(
                    '<option value=""> Select a Section</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="section"]').append(
                        '<option value="' + value + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    TaskcardType();
});
