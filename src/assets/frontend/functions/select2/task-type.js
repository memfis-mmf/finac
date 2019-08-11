let TaskTypeSelect2 = {
    init: function () {
        $('#task_type_id, #task_type_id_validate').select2({
            placeholder: 'Select a Task Type'
        });
    }
};

jQuery(document).ready(function () {
    TaskTypeSelect2.init();
});
