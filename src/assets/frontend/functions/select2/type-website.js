let TypeWebsiteSelect2 = {
    init: function () {
        $('#type_document, #type_document_validate').select2({
            placeholder: 'Select a Website Type'
        });
    }
};

jQuery(document).ready(function () {
    TypeWebsiteSelect2.init();
});