let CashbookTypeSelect2 = {
    init: function () {
        $('#cashbook_type, #cashbook_type_validate').select2({
            placeholder: 'Select a Cashbook Type',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    CashbookTypeSelect2.init();
});
