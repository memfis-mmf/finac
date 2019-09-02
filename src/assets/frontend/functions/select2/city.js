let CitySelect2 = {
    init: function () {
        $('#city, #city_validate').select2({
            placeholder: 'Select an City'
        });
    }
};

jQuery(document).ready(function () {
    CitySelect2.init();
});
