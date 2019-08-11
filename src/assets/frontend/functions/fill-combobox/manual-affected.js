$(document).ready(function () {
    ManualAffected = function () {
        $.ajax({
            url: '/get-manual-affecteds/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="manual_affected_id"]').empty();

                $('select[name="manual_affected_id"]').append(
                    '<option value=""> Select a Manual Affected</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="manual_affected_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    ManualAffected();
});
