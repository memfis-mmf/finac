let CustomerLevelSelect2 = {
    init: function () {
        $('#customer-level, #customer-level_validate').select2({
            placeholder: 'Select a Level'
        });
    }
};

jQuery(document).ready(function () {
    CustomerLevelSelect2.init();
});
