var BankStatementDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_bank_statement").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    BankStatementDaterangepicker.init()
});