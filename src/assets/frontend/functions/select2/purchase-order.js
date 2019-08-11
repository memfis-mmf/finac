let PurchaseOrderSelect2 = {
  init: function () {
      $('#purchase_order, #purchase_order_validate').select2({
          placeholder: 'Select a Purchase Order Number'
      });
  }
};

jQuery(document).ready(function () {
  PurchaseOrderSelect2.init();
});
