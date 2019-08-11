let RecurrenceSelect2 = {
    init: function () {
        $('#recurrence_id, #recurrence_id_validate').select2({
            placeholder: 'Select a Recurrence'
        })
    }
};

jQuery(document).ready(function () {
    RecurrenceSelect2.init();
});
