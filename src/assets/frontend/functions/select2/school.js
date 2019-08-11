let SchoolSelect2 = {
    init: function () {
        $('#school, #school_validate').select2({
            placeholder: 'Select a School'
        });
    }
};

jQuery(document).ready(function () {
    SchoolSelect2.init();
});
