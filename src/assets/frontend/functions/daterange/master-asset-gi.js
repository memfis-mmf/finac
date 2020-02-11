var MasterAssetDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_master_asset").daterangepicker({
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
    MasterAssetDaterangepicker.init()
});
