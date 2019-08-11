$(document).ready(function () {
    ThresholdType = function () {
        $.ajax({
            url: '/get-threshold-types/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="threshold_type"]').empty();

                $('select[name="threshold_type"]').append(
                    '<option value=""> Select a Threshold Type</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="threshold_type"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    ThresholdType();
});
