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
            $("#exchange").val("");
            $("#exchange").attr("readonly", false); 
            $('#exchange').prop('readonly', false);
            document.getElementById("requi").style.display = "block";
        } else {
            $("#exchange").val("");
            $("#exchange").attr("readonly", true); 
            $('#exchange').prop('readonly', true);
            document.getElementById("requi").style.display = "none";
            
        }
    });
});
