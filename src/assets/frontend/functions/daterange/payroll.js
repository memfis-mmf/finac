var PayrollDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_payroll").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    PayrollDaterangepicker.init()
});
