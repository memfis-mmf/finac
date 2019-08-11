$(document).ready(function () {
    aviationDegree = function () {
        $.ajax({
            url: '/get-aviation-degree',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="aviation_degree"]').empty();

                $('select[name="aviation_degree"]').append(
                    '<option value=""> Select a Aviation Degree</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="aviation_degree"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };
    aviationDegree();
});
