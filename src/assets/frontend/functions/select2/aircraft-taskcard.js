let AircraftTaskcardSelect2 = {
    init: function () {
        $('#aircraft_taskcard, #aircraft_taskcard_validate').select2({
            placeholder: 'Select an Aicraft'
        });
    }
};

jQuery(document).ready(function () {
    AircraftTaskcardSelect2.init();
});
