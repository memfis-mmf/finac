$(document).ready(function () {
  $('#employee').select2({
    placeholder: ' Select a Customer ',
    ajax: {
      url: '/get-employees-uuid',
      dataType: 'json'
    }
  });
});
