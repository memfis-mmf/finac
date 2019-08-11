let radio = {
  init: function () {
      $('#radio, #radio_validate').select2({
          placeholder: 'Select a Radio',
      });
  }
};

jQuery(document).ready(function () {
  radio.init();
});
