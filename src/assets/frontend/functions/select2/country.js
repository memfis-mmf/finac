let CountrySelect2 = {
    init: function () {
        $('#country, #country_validate').select2({
            placeholder: 'Select a Country'
        });
    }
};

jQuery(document).ready(function () {
    CountrySelect2.init();
});
