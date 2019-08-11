

$(document).ready(function() {
    $('#numeric').on('blur', function() {
        // alert('Handler for .blur() called.');
        let qty = $('#numeric').val();
        let convert = accounting.formatNumber(qty, 2, ".", ",");
        document.getElementById('numeric').value = convert;

        // alert(tes);
    });
}); //end ready
// var string = numeral(10000000.120).format('0.0,');
// alert(string);
// $('input.number').keyup(function(event) {

//     // skip for arrow keys
//     if(event.which >= 37 && event.which <= 40) return;

//     // format number
//         $(this).val(function(index, value) {
//         // var n = value;
//         // return value.toLocaleString(en);
//         // var parts = value.toString().split(/\D/g,".");
//         // parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//         // return parts.join(".");        // return value
//         .replace(/\D/g, "")
//         .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
//         // ;
//         });
// });
// $('input.number').keyup(function(event) {

//     // skip for arrow keys
//     if(event.which >= 37 && event.which <= 40) return;

//     // format number
//         $(this).val(function(index, value) {
//         return value
//         // .replace(new RegExp(value, 'g'), replacement);
//         .replace(/\./g, "")
//         .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
//         // .replace(/\D/g, "")
//         // .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
//         // ;
//         });
// });
// $("input.number").on('keyup', function(evt){
//     // if (evt.which != 110 ){//not a fullstop
//         // var n = parseFloat($(this).val().replace(/\,/g,''),10);
//         // var n = accounting.formatNumber($(this).val() ,2, ".", ",");
//         // $(this).val(n.toLocaleString());
//         $(this).val(accounting.formatNumber($(this).val() ,2, ".", ","))
//     // }
// });