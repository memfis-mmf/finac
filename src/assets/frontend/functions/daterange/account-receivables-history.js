var AccountDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_account_receivables_history").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    AccountDaterangepicker.init()
});
