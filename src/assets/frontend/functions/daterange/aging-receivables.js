var AgingDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_aging").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    AgingDaterangepicker.init()
});
