let instrument = {
  init: function () {
      $('#instrument, #instrument_validate').select2({
          placeholder: 'Select an Instrument',
      });
  }
};

jQuery(document).ready(function () {
  instrument.init();
});
