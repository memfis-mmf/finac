let TypeDocumentSelect2 = {
    init: function () {
        $('.type_website').select2({
            placeholder: 'Select a Document Type'
        });
    }
};

jQuery(document).ready(function () {
    TypeDocumentSelect2.init();
});