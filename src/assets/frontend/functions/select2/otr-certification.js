let OtrCertificationSelect2 = {
    init: function () {
        $('#otr_certification, #otr_certification_validate').select2({
            placeholder: 'Select a Skill'
        });
    }
};

jQuery(document).ready(function () {
    OtrCertificationSelect2.init();
});
