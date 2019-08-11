let AttnEmailSelect2 = {
    init: function () {
        $('.attn-email, #attn-email_validate').select2({
            placeholder: 'Email Adresses',
            tags: true
        });
    }
};

jQuery(document).ready(function () {
    AttnEmailSelect2.init();
});
