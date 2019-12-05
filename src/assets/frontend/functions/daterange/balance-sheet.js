var BalanceSheetDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_balance_sheet").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    BalanceSheetDaterangepicker.init()
});
