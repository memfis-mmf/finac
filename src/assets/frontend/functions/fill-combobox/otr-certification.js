$(document).ready(function () {
    OtrCertification = function () {
        $.ajax({
            url: '/get-otr-certifications/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="otr_certification"]').empty();

                $('select[name="otr_certification"]').append(
                    '<option value=""> Select a Skill</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="otr_certification"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    OtrCertification();
});
