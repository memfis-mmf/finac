var TrialBalanceDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_trial_balance").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary",
								locale: {
			            format: 'DD/MM/YYYY'
				        }
            });
        }()
    }
};
jQuery(document).ready(function () {
    TrialBalanceDaterangepicker.init()
});
