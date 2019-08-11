$(document).ready(function () {
    let select = document.getElementById('name4');

    name2 = function () {
        $.ajax({
            url: '/get-employees-data/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="name"]').empty();

                $('select[name="name"]').append(
                    '<option value=""> Select a Name</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="name"]').append(
                        select.options[select.options.length] = new Option(value, key)

                    );
                });
            }
        });
    };

    name2();
});
