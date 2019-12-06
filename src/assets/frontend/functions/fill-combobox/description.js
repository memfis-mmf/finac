$(document).ready(function () {
    description = function () {

        $('select[id="description"]').empty();

        $('select[id="description"]').append(
            '<option value=""> Select a Description</option>'
        );

        $('select[id="description"]').append(
            '<option value="header"> Header</option>'
        );
        $('select[id="description"]').append(
            '<option value="detail"> Detail</option>'
        );

     

    };
    description();
});
