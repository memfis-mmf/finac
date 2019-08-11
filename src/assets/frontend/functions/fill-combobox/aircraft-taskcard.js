$(document).ready(function () {
    AircraftTaskcard = function () {
        $.ajax({
            url: '/get-aircraft-taskcards/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="aircraft_taskcard"]').empty();

                $('select[name="aircraft_taskcard"]').append(
                    '<option value=""> Select a Aircraft</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="aircraft_taskcard"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    AircraftTaskcard();
});
