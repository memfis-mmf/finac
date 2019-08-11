$(document).ready(function () {
    $('select[name="name"]').on('change', function () {
        let select = document.getElementById('license');

        let id = $(this).val();
        // alert(stateID);

        license = function () {
            $.ajax({
                url: '/get-licenses/' + id + '/',
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    $('select[name="license"]').empty();

                    $('select[name="license"]').append(
                        '<option value=""> Select a License</option>'
                    );

                    $.each(data, function (key, value) {
                        $('select[name="license"]').append(
                            select.options[select.options.length] = new Option(value, key)
                        );
                    });
                }
            });
        };

        license();
    });

});

$(document).ready(function () {
    $('select[name="license"]').on('change', function () {
        let license = $('#license').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/get-gnrl-license/' + license + '/',
            success: function (data) {
                document.getElementById('issued_at').value = data.issued_at;
                document.getElementById('valid_until').value = data.valid_until;
                document.getElementById('revoke_at').value = data.revoke_at;
                document.getElementById('code_general_license').value = data.code;
            },
            error: function (jqXhr, json, errorThrown) {
                let errorsHtml = '';
                let errors = jqXhr.responseJSON;

                $.each(errors.errors, function (index, value) {
                    $('#general-license-error').html(value);
                });
            }
        });
    });
});
