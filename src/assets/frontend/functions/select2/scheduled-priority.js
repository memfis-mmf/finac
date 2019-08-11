let ScheduledPrioritySelect2 = {
    init: function () {
        $('#scheduled_priority_id, #scheduled_priority_id_validate').select2({
            placeholder: 'Select a Scheduled Priority'
        })
    }
};

jQuery(document).ready(function () {
    ScheduledPrioritySelect2.init();
});
