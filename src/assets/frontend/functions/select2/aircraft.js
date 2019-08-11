let AircraftSelect2 = {
    init: function () {
        $('#aircraft, #aircraft_validate').select2({
            placeholder: 'Select an Aircraft'
        });
    }
};

jQuery(document).ready(function () {
    AircraftSelect2.init();
});
