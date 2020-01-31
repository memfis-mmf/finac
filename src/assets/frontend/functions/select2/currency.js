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
        if(this.value != 'idr'){
            console.log("bukan idr");
            $("#exchange").val("");
            $("#exchange").removeAttr("readonly");
            document.getElementById("requi").style.display = "block";
        } else {
            console.log("idr");
            $("#exchange").val("1");
            // $("#exchange").attr("readonly", true);
            $("#exchange").removeAttr("readonly"); 
            document.getElementById("requi").style.display = "none";

        }
    });
});
