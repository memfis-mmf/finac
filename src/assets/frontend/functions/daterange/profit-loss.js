var ProfitLossDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_profitloss").daterangepicker({
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
    ProfitLossDaterangepicker.init()
});
