let TypeSelect2 = {
    init: function () {
        $('#discount-type, #discount-type_validate').select2({
            placeholder: 'Select a Type'
        });
        $('select[name="discount-type"]').append(
            '<option value="amount">Amount</option>',
            '<option value="percentage">Percentage</option>'
        );
    }
};

jQuery(document).ready(function () {
    TypeSelect2.init();
});
