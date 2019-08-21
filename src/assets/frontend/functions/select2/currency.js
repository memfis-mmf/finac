let CurrencySelect2 = {
    init: function () {
        $('#currency, #currency_validate').select2({
            placeholder: 'Select a Currency'
        });
    }
};

jQuery(document).ready(function () {
    document.getElementById("requi").style.display = "none";
    CurrencySelect2.init();
    $('#currency').on('change', function () {
        if(this.value != 46){
            $("#exchange").attr("readonly", false); 
            document.getElementById("requi").style.display = "block";
        } else {
            document.getElementById('exchange').value = '1';
            $("#exchange").attr("readonly", true); 
            document.getElementById("requi").style.display = "none";
            
        }
    });
});
