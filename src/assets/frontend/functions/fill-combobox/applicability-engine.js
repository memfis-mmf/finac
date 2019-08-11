$(document).ready(function () {
    ApplicabilityEngine = function () {
        $.ajax({
            url: '/get-applicability-engines/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $('select[name="applicability_engine"]').empty();

                $('select[name="applicability_engine"]').append(
                    '<option value=""> Select a Applicability Engine</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="applicability_engine"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    ApplicabilityEngine();
});
