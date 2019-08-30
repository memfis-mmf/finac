let Bankselect2 = {
    init: function () {
        $('#bankinfo, #bankinfo_validate').select2({
            placeholder: 'Select an Bank'
        });
    }
};

jQuery(document).ready(function () {
    Bankselect2.init();
});
