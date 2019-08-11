let OfSelect2 = {
  init: function () {
      $('#of, #of_validate').select2({
          placeholder: 'Select an Of'
      });
  }
};

jQuery(document).ready(function () {
  OfSelect2.init();
});
