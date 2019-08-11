    let TaskcardRoutineTypeSelect2 = {
    init: function () {
        $('#taskcard_routine_type, #taskcard_routine_type_validate').select2({
            placeholder: 'Select a Taskcard Routine Type '
        });
    }
};

jQuery(document).ready(function () {
    TaskcardRoutineTypeSelect2.init();
});
