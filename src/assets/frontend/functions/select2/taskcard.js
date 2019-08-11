let TaskcardSelect2 = {
    init: function () {
        $('#taskcard, #taskcard_validate').select2({
            placeholder: 'Select a Taskcard'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardSelect2.init();
});
