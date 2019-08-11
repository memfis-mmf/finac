let ZoneSelect2 = {
    init: function () {
        $('#zone, #zone_validate').select2({
            placeholder: 'Select a Zone',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    ZoneSelect2.init();
});
