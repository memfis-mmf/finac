var GoodRecievedNoteDaterangepicker = {
    init: function () {
        ! function () {
            $("#daterange_good_recieved_note").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            });
        }()
    }
};
jQuery(document).ready(function () {
    GoodRecievedNoteDaterangepicker.init()
});
