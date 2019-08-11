var PurchaseOrderDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_purchase_order").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    PurchaseOrderDaterangepicker.init()
});
