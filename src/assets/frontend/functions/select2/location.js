let LocationSelect2 = {
    init: function () {
        $('#location, #location_validate').select2({
            placeholder: 'Select a Location',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    LocationSelect2.init();
});
