let SeriesSelect2 = {
    init: function () {
        $('#series, #series_validate').select2({
            placeholder: 'Select a Series'
        });
    }
};

jQuery(document).ready(function () {
    SeriesSelect2.init();
});
