$(document).ready(function () {
    storage = function () {
        $.ajax({
            url: '/get-storages-combobox/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="item_storage_id"]').empty();

                $('select[name="item_storage_id"]').append(
                    '<option value=""> Select a Storage</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="item_storage_id"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    storage();
});
