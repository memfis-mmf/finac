var MasterAssetDepDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_depreciation_date").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    MasterAssetDepDaterangepicker.init()
});
