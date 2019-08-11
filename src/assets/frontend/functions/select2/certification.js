let CertificationSelect2 = {
    init: function () {
        $('#certification, #certification_validate').select2({
            placeholder: 'Select a Certification'
        });
    }
};

jQuery(document).ready(function () {
    CertificationSelect2.init();
});
