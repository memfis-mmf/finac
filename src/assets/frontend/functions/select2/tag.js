let TagSelect2 = {
    init: function () {
        $('#tag, #tag_validate').select2({
            placeholder: 'Select a Tag',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    TagSelect2.init();
});
