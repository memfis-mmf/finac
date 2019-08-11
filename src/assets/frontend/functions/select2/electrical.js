let electrical = {
  init: function () {
      $('#electrical, #electrical_validate').select2({
          placeholder: 'Select an Electrical',
      });
  }
};

jQuery(document).ready(function () {
  electrical.init();
});
