let WorkOrderSelect2 = {
    init: function () {
        $('#work-order, #work-order_validate').select2({
            placeholder: 'Select a Work Order'
        });
    }
};

jQuery(document).ready(function () {
    WorkOrderSelect2.init();
});