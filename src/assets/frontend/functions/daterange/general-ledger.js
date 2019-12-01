var GeneralLedgerDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_general_ledger").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    GeneralLedgerDaterangepicker.init()
});
