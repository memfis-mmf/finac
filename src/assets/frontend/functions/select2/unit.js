let UnitSelect2 = {
    init: function () {
        $('#unit_id, #unit_id_validate').select2({
            placeholder: 'Select a Unit'
        })
    }
};

jQuery(document).ready(function () {
    UnitSelect2.init();
});
