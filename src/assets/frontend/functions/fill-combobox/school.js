$(document).ready(function () {
    school = function () {
        $.ajax({
            url: '/get-categories-item/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="school"]').empty();

                $('select[name="school"]').append(
                    '<option value=""> Select a school</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="school"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    school();
});
