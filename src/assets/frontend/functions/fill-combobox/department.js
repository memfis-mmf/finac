$(document).ready(function () {
    Department = function () {
        $.ajax({
            url: '/get-departments',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select#department').empty();

                $('select#department').append(
                    '<option value=""> Select a Department</option>'
                );

                $.each(data, function (key, value) {
                    $('select#department').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    Department();
});
