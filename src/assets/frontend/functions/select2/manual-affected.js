
let ManualAffectedSelect2 = {
    init: function () {
        $('#manual_affected_id, #manual_affected_id_validate').select2({
            placeholder: 'Select a Manual Affected'
        })
    }
};

jQuery(document).ready(function () {
    ManualAffectedSelect2.init();
});
