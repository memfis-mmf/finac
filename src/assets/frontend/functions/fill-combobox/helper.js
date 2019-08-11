$(document).ready(function () {
    helper = function () {
        $.ajax({
            url: '/get-employees/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('.helper').empty();

                $('.helper').each(function(){
                        $(this).append('<option value=""> Select a Helper </option>');
                        $.each(data, function (key, value) {
                            $('.helper').append(
                                '<option value="' + key + '">' + value + '</option>'
                            );
                        });
                    }
                );

                
            }
        });
    };

    helper();
});
