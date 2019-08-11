let LicenseSelect2 = {
    init: function () {
        $('#license, #license_validate').select2({
            placeholder: 'Select a License'
        }),$('#license2, #license2_validate').select2({
            placeholder: 'Select a License'
        });
    }
};

jQuery(document).ready(function () {
    LicenseSelect2.init();
});
