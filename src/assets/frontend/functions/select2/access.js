let AccessSelect2 = {
    init: function () {
        $('#access, #access_validate').select2({
            placeholder: 'Select an Access',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    AccessSelect2.init();
});
