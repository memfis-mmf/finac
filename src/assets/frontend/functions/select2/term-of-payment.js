let TermOfPaymentSelect2 = {
    init: function () {
        $('#payment_term, #payment_term_validate').select2({
            placeholder: 'Select a Term of Payment',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    TermOfPaymentSelect2.init();
});
