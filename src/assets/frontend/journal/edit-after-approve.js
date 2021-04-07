let JournalEdit = {
  init: function () {

    $('input').attr('disabled', 'disabled');
    $('select').attr('disabled', 'disabled');
    $('textarea').not('.not-disabled').attr('disabled', 'disabled');

    let number_format = new Intl.NumberFormat('de-DE');

    column_list = [];

    column_list.push(
      { data: 'coa.code' },
      { data: 'coa.name' },
      { data: 'project.code', defaultContent: '-' },
      {
        data: 'debit', render: (data, type, row) => {
          return row.journal.currency.symbol + ' ' + number_format.format(row.debit);
        }
      },
      {
        data: 'credit', render: (data, type, row) => {
          $("#total_debit").val(
            number_format.format(parseFloat(row.total_debit))
          );
          $("#total_credit").val(
            number_format.format(parseFloat(row.total_credit))
          );
          return row.journal.currency.symbol + ' ' + number_format.format(row.credit);
        }
      },
      { data: 'description_field', name: 'description_2' },
      { data: 'action' }
    );

    let journala_datatable = $('.journala_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: $('.journala_datatable').data('url'),
      columns: column_list
    });

    $('.paging_simple_numbers').addClass('pull-left');
    $('.dataTables_length').addClass('pull-right');
    $('.dataTables_info').addClass('pull-left');
    $('.dataTables_info').addClass('margin-info');
    $('.paging_simple_numbers').addClass('padding-datatable');

    $(document).on('click', '.save-description', function () {
      let tr = $(this).parents('tr');

      let description_2 = tr.find('textarea').val();
      let data = journala_datatable.row(tr).data();
      let url = data.url;

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "put",
        url: url,
        data: {
          'description_2': description_2
        },
        dataType: "json",
        success: function (response) {
          if (response.status) {
            toastr.success(response.message, 'Success', {
              timeOut: 2000
            });

            journala_datatable.ajax.reload(null, false);

          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });

    });

  }
};

let errorHandler = (response) => {

  let message = '';

  if (!('errors' in response)) {
    message = response.message;
  } else {
    errors = response.errors;

    loop = 0;
    $.each(errors, function (index, value) {

      if (!loop) {
        message = value[0]
      }

      loop++;
    })
  }

  toastr.error(message, 'Invalid', {
    timeOut: 2000
  });
}

jQuery(document).ready(function () {
  JournalEdit.init();
});
