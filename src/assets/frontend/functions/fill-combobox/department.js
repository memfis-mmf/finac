$(document).ready(function () {
    Department = function () {
        $.ajax({
            url: '/get-departments',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="department"]').empty();

                $('select[name="department"]').append(
                    '<option value=""> Select a Department</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="department"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    Department();
});
