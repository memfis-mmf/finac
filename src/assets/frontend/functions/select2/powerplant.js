let powerplant = {
  init: function () {
      $('#powerplant, #powerplant_validate').select2({
          placeholder: 'Select a Powerplant',
      });
  }
};

jQuery(document).ready(function () {
  powerplant.init();
});
