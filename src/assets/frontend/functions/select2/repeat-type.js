let RepeatTypeSelect2 = {
    init: function () {
        $('#repeat_type, #repeat_type_validate').select2({
            placeholder: 'Select a Repeat Type'
        });
    }
};

jQuery(document).ready(function () {
    RepeatTypeSelect2.init();
});