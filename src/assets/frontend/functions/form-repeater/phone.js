var PhoneFormRepeater = {
    init: function() {
        $("#m_repeater_phone").repeater({
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
    PhoneFormRepeater.init();
});
