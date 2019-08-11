$(document).ready(function () {
    material = function () {
        $.ajax({
            url: '/get-materials/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="material"]').empty();

                $('select[name="material"]').append(
                    '<option value=""> Select a Material</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="material"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    material();
});
