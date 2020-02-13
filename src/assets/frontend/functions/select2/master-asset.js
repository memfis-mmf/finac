let MasterAssetSelect2 = {
    init: function () {
        $('#master_asset, #master_asset_validate').select2({
            placeholder: 'Select an Master Asset'
        });
    }
};

jQuery(document).ready(function () {
    MasterAssetSelect2.init();
});
