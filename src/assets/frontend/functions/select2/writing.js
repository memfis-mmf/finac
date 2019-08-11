let WritingSelect2 = {
    init: function () {
        $('#writing, #writing_validate').select2({
            placeholder: 'Select a Writing Level'
        });
    }
};

jQuery(document).ready(function () {
    WritingSelect2.init();
});
