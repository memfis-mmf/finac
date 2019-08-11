let DocumentSelect2 = {
    init: function () {
        $('#document, #document_validate').select2({
            placeholder: 'Select a Documents',
        });
    }
};

jQuery(document).ready(function () {
    DocumentSelect2.init();
});
