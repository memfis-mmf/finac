let AssetplAccountSelect2 = {
    init: function () {
        $('#asset_pl_account, #asset_pl_account_validate').select2({
            placeholder: 'Select an Asset'
        });
    }
};

jQuery(document).ready(function () {
    AssetplAccountSelect2.init();
});
