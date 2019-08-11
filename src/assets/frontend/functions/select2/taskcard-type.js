let TaskcardTypeSelect2 = {
    init: function () {
        $('#taskcard_type, #taskcard_type_validate').select2({
            placeholder: 'Select a Taskcard Type'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardTypeSelect2.init();
});
