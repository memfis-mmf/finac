let StorageSelect2 = {
    init: function () {
        $('#item_storage_id, #item_storage_validate').select2({
            placeholder: 'Select a Storage'
        });
    }
};

jQuery(document).ready(function () {
    StorageSelect2.init();
});
