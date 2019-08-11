let UnitItemSelect2 = {
    init: function () {
        $('#unit, #unit_validate').select2({
            placeholder: 'Select a Unit'
        }),

        $('#unit_item, #unit_item_validate').select2({
            placeholder: 'Select a Unit'
        });
    }
};

jQuery(document).ready(function () {
    UnitItemSelect2.init();
});
