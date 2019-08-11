let ValidUntil = {
    init: function () {

        $("#valid_until").datetimepicker({
            format: "yyyy-mm-dd",
            todayHighlight: !0,
            autoclose: !0,
            startView: 2,
            minView: 2,
            forceParse: 0,
            pickerPosition: "bottom-left"
        })
    }
};
jQuery(document).ready(function () {
    ValidUntil.init();
});
