let DescriptionSelect2 = {
    init: function () {
        $('#description, #description_validate').select2({
            placeholder: 'Select a Description'
        });
    }
};

jQuery(document).ready(function () {
    DescriptionSelect2.init();

    
});
