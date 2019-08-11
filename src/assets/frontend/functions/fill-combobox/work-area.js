$(document).ready(function () {
    WorkArea = function () {
        $.ajax({
            url: '/get-work-areas/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="work_area"]').empty();

                $('select[name="work_area"]').append(
                    '<option value=""> Select a Work Area</option>'
                );

                $.each(data, function (key, value) {

                    $('select[name="work_area"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    WorkArea();
});
