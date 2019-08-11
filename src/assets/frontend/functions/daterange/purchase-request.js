var PurchaseRequestDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_purchase_request").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    PurchaseRequestDaterangepicker.init()
});
