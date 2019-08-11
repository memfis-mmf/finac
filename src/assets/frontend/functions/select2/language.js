let LanguageSelect2 = {
    init: function () {
        $('#language, #language_validate').select2({
            placeholder: 'Select a Language'
        });
    }
};

jQuery(document).ready(function () {
    LanguageSelect2.init();
});
