let ChargeTypeSelect2 = {
    init: function () {
        $('.charge_type').select2({
            placeholder: 'Select Extra Charge Type',
        });
    }
};

jQuery(document).ready(function () {
    ChargeTypeSelect2.init();
});
