$(document).ready(function () {
    WorkArea = function () {
        $.ajax({
            url: '/get-work-orders/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="work-order"]').empty();

                $('select[name="work-order"]').append(
                    '<option value=""> Select a Work Order</option>'
                );

                $.each(data, function (key, value) {

                    $('select[name="work-order"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    WorkArea();
});
