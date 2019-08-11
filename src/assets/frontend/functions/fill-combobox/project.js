$(document).ready(function () {
    projects = function () {
        $.ajax({
            url: '/get-projects/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('select[name="project"]').empty();

                $('select[name="project"]').append(
                    '<option value=""> Select a Project</option>'
                );

                $.each(data, function (key, value) {
                    $('select[name="project"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            }
        });
    };

    projects();
});
