let ItemSelect2 = {
    init: function () {
        $('#item, #item_validate').select2({
            placeholder: 'Select an Item'
        });
    }
};

jQuery(document).ready(function () {
    ItemSelect2.init();
});
