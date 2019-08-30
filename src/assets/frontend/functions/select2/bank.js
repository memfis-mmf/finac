let Bankselect2 = {
    init: function () {
        $('#bankinfo, #bankinfo_validate').select2({
            placeholder: 'Select a Bank'
        });
    }
};

jQuery(document).ready(function () {
    Bankselect2.init();
});
