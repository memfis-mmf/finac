let FilterSelect2 = {
    init: function () {
        $('#filter, #filter_validate').select2({
            placeholder: 'Select a Filter',
            // tags: true
        });
    }
};

jQuery(document).ready(function () {
    FilterSelect2.init();
});
