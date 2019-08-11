let ScheduledPaymentTypeSelect2 = {
    init: function () {
        $('#scheduled_payment_type, #scheduled_payment_type_validate').select2({
            placeholder: 'Select a Type'
        });
    }
};

jQuery(document).ready(function () {
    ScheduledPaymentTypeSelect2.init();
});
