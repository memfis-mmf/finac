let FacilitySelect2 = {
    init: function () {
        $('.facility, #facility_validate').select2({
            placeholder: 'Select a Facility'
        });
    }
};

jQuery(document).ready(function () {
    FacilitySelect2.init();
});
