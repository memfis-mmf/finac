let TitleSelect2 = {
    init: function () {
        $('#title, #title_validate').select2({
            placeholder: 'Select a Title'
        });
    }
};

jQuery(document).ready(function () {
    TitleSelect2.init();
});
