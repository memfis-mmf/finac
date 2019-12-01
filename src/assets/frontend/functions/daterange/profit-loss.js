var ProfitLossDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_profitloss").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    ProfitLossDaterangepicker.init()
});
