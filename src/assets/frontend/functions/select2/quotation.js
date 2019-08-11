let QuotationSelect2 = {
    init: function () {
        $('#quotation, #quotation_validate').select2({
            placeholder: 'Select a Quotation'
        });
    }
};

jQuery(document).ready(function () {
    QuotationSelect2.init();
});
