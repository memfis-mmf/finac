$(document).ready(function () {
    description = function () {

        $('select[id="description"]').empty();

        $('select[id="description"]').append(
            '<option value=""> Select a Description</option>'
        );

        $('select[id="description"]').append(
            '<option value="Header"> Header</option>'
        );
        $('select[id="description"]').append(
            '<option value="Detail"> Detail</option>'
        );

     

    };
    description();
});
