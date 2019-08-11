let receivedBySelect2 = {
    init: function () {
        $('#received-by, #received-by_validate').select2({
            placeholder: 'Select a Received By'
        });
    }
};

jQuery(document).ready(function () {
    receivedBySelect2.init();
});
