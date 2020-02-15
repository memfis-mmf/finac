var BalanceSheetDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_balance_sheet").daterangepicker({
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
    BalanceSheetDaterangepicker.init()
});
