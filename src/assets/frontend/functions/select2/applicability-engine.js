let ApplicabilityEngineSelect2 = {
    init: function () {
        $('#applicability_engine, #applicability_engine_validate').select2({
            placeholder: 'Select an Applicability Engine'
        });
    }
};

jQuery(document).ready(function () {
    ApplicabilityEngineSelect2.init();
});
