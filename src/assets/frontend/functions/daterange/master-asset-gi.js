var MasterAssetDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_master_asset").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    MasterAssetDaterangepicker.init()
});
