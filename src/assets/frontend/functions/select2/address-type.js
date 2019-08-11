let AddressTypeSelect2 = {
    init: function () {
        $('#address_type, #address_type_validate').select2({
            placeholder: 'Select a Type'
        });
    }
};

jQuery(document).ready(function () {
    AddressTypeSelect2.init();
});
