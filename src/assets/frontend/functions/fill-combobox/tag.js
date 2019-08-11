$(document).ready(function () {
    tag = function () {
        $.ajax({
            url: '/get-tags/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="tag"]').empty();

                $('select[name="tag"]').append(
                    '<option value=""> Select a Tag</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="tag"]').append(
                        '<option value="' + value + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    tag();
});
