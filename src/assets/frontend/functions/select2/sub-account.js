let SubAccountSelect2 = {
    init: function () {
        $('#sub_account, #sub_account_validate').select2({
            placeholder: 'Select a Type'
        });
    }
};

jQuery(document).ready(function () {
    SubAccountSelect2.init();
});
