let SectionSelect2 = {
    init: function () {
        $('#section, #section_validate').select2({
            placeholder: 'Select a Section(s)',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    SectionSelect2.init();
});
