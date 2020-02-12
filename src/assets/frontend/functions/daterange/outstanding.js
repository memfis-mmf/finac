var OutstandingDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_outstanding").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    OutstandingDaterangepicker.init()
});
