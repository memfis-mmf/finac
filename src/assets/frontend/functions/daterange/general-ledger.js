var GeneralLedgerDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_general_ledger").daterangepicker({
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
    GeneralLedgerDaterangepicker.init()
});
