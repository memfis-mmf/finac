let AttnSelect2 = {
    init: function () {
        $('#attention, #attention_validate').select2({
            placeholder: 'Select an Attention'
        });
    }
};

jQuery(document).ready(function () {
    AttnSelect2.init();
});
