let RefSelect2 = {
    init: function () {
        $('#ref, #ref_validate').select2({
            placeholder: 'Select a Reference'
        });
    }
};

jQuery(document).ready(function () {
    RefSelect2.init();
});
