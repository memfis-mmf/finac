let MaterialSelect2 = {
    init: function () {
        $('#material, #material_validate').select2({
            placeholder: 'Select a Material'
        });
    }
};

jQuery(document).ready(function () {
    MaterialSelect2.init();
});
