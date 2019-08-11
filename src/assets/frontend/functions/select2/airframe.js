let airframe = {
  init: function () {
      $('#airframe, #airframe_validate').select2({
          placeholder: 'Select an Airframe',
      });
  }
};

jQuery(document).ready(function () {
  airframe.init();
});
