let ThresholdTypeSelect2 = {
    init: function () {
        $('#threshold_type, #threshold_type_validate').select2({
            placeholder: 'Select a Threshold Type'
        });
    }
};

jQuery(document).ready(function () {
    ThresholdTypeSelect2.init();
});
