let ExchangeSelect2 = {
    init: function () {
        $('#exchange, #exchange_validate').select2({
            placeholder: 'Select an Exchange'
        });
    }
};

jQuery(document).ready(function () {
    ExchangeSelect2.init();
});
