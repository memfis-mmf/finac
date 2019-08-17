let CurrencySelect2 = {
    init: function () {
        $('#currency, #currency_validate').select2({
            placeholder: 'Select a Currency'
        });
    }
};

jQuery(document).ready(function () {
    CurrencySelect2.init();
    $('#currency').on('change', function () {
        if(this.value != 46){
            $("#exchange").attr("readonly", false); 
        } else {
            document.getElementById('exchange').value = '';
            $("#exchange").attr("readonly", true); 
            
        }
    });
});
