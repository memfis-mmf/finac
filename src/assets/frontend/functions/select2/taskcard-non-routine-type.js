let TaskcardNonRoutineTypeSelect2 = {
    init: function () {
        $('#taskcard_non_routine_type, #taskcard_non_routine_type_validate').select2({
            placeholder: 'Select a Taskcard Non Routine Type'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardNonRoutineTypeSelect2.init();
});
