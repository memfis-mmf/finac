let vendorSelect2 = {
    init: function () {
        $('#vendor, #vendor_validate').select2({
            placeholder: 'Select a Vendor'
        });
    }
};

jQuery(document).ready(function () {
    vendorSelect2.init();
});
