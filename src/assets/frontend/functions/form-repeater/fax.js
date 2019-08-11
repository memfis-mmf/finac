var FaxFormRepeater = {
    init: function() {
        $("#m_repeater_fax").repeater({
            initEmpty: !1,
            defaultValues: { "text-input": "foo" },
            show: function() {
                $(this).slideDown();
            },
            hide: function(e) {
                $(this).slideUp(e);
            }
        })
    }
};
jQuery(document).ready(function() {
    FaxFormRepeater.init();
});
