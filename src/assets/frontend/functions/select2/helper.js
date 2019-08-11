let HelperSelect2 = {
    init: function () {
        $('select[name^=helper], #helper_validate').select2({
            placeholder: 'Select a Helper',
            allowClear: true
        });
    }
};

jQuery(document).ready(function () {
    HelperSelect2.init();
});
