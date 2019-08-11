let cabin = {
  init: function () {
      $('#cabin, #cabin_validate').select2({
          placeholder: 'Select a Cabin',
      });
  }
};

jQuery(document).ready(function () {
  cabin.init();
});
