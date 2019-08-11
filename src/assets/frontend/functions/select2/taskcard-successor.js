let TaskcardSuccessorSelect2 = {
    init: function () {
        $('#taskcard_successor, #taskcard_validate').select2({
            placeholder: 'Select a Taskcard'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardSuccessorSelect2.init();
});
