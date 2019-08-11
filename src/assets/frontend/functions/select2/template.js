let TemplateSelect2 = {
    init: function () {
        $('#template, #template_validate').select2({
            placeholder: 'Select a Template'
        });
    }
};

jQuery(document).ready(function () {
    TemplateSelect2.init();
});