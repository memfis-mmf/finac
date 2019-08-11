let FaxSelect2 = {
    init: function () {
        $('#fax, #fax_validate').select2({
            placeholder: 'Select a Fax'
        });
    }
};

jQuery(document).ready(function () {
    FaxSelect2.init();
});
