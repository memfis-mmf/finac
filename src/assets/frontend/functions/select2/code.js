let CodeSelect2 = {
    init: function () {
        $('#code, #code_validate').select2({
            placeholder: 'Select a Code'
        });
    }
};

jQuery(document).ready(function () {
    CodeSelect2.init();
});
