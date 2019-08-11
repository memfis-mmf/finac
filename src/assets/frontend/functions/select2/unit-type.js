let UnitTypeSelect2 = {
    init: function () {
        $('#type_id, #type_id_validate').select2({
            placeholder: 'Select a Type'
        });
    }
};

jQuery(document).ready(function () {
    UnitTypeSelect2.init();
});
