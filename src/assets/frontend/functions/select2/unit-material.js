let UnitMaterialSelect2 = {
    init: function () {
        $('#unit_material, #unit_material_validate').select2({
            placeholder: 'Select a Unit'
        });
    }
};

jQuery(document).ready(function () {
    UnitMaterialSelect2.init();
});
