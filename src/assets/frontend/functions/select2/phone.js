let PhoneSelect2 = {
    init: function () {
        $('#phone, #phone_validate').select2({
            placeholder: 'Select a Phone'
        });
    }
};

jQuery(document).ready(function () {
    PhoneSelect2.init();
});
