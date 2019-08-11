$(document).ready(function () {
    type = function () {
        $.ajax({
            url: '/get-website-types',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[id="type_website"]').empty();

                $('select[id="type_website"]').append(
                    '<option value=""> Select a Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[id="type_website"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    type();
});
