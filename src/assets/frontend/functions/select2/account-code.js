let AccountCodeSelect2 = {
    init: function () {
        $('#accountcode, #accountcode_validate').select2({
            placeholder: 'Select an Account Code'
        // }), $('#accountcode2, #accountcode2_validate').select2({
        //     placeholder: 'Select an Account Code'
        }), $('#accountcode3, #accountcode3_validate').select2({
            placeholder: 'Select an Account Code'
        });
    }
};

jQuery(document).ready(function () {
    AccountCodeSelect2.init();
});
