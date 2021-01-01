var CashStatementDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_cash_statement").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    CashStatementDaterangepicker.init()
});