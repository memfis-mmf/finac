$(document).ready(function () {
    coa = function () {
        $.ajax({
            url: '/coa/data',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="coa"]').empty();

                $('select[name="coa"]').append(
                    '<option value=""> Select a Type</option>'
                );
                for (let i = 0; i < data.length; ++i) {
                    $('select[name="coa"]').append(
                        '<option value="' + data[i].uuid + '">' + data[i].name  +' - '+ data[i].code +'</option>'
                    );
                }
                
            }
        });
    };
    coa();
});
