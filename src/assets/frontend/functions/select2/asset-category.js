let AssetCategorySelect2 = {
    init: function () {
        $('#asset_category, #asset_category_validate').select2({
            placeholder: 'Select a Asset Category'
        });
    }
};

jQuery(document).ready(function () {
    AssetCategorySelect2.init();
});
