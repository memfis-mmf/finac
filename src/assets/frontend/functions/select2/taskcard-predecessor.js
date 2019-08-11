let TaskcardPredecessorSelect2 = {
    init: function () {
        $('#taskcard_predecessor, #taskcard_validate').select2({
            placeholder: 'Select a Taskcard'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardPredecessorSelect2.init();
});
