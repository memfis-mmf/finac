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
        console.log(this.value);
        if(this.value != 46){
            console.log("bukan idr");
            $("#exchange_rate1111").val("");
            document.getElementById("requi").style.display = "block";
        } else {
            console.log("idr");
            $("#exchange_rate1111").val("");
            $("#exchange_rate1111").attr("readonly", true); 
            document.getElementById("requi").style.display = "none";
            
        }
    });
});
