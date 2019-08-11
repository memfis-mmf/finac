let TagSelect2 = {
    init: function () {
        $('#version, #version_validate').select2({
            placeholder: 'Select a Version',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    TagSelect2.init();
});
