var TrialBalanceDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_trial_balance").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    TrialBalanceDaterangepicker.init()
});
