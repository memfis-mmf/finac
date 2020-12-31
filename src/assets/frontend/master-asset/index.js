let MasterAsset = {
  init: function () {

    let _url = window.location.origin;

    $("[name=date_generate]").daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'YYYY-MM-DD'
      }
    });

    function addCommas(nStr) {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
      return x1 + x2;
    }

    let master_asset_datatable = $('.master_asset_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: `${_url}/asset/datatables`,
      order: [[0, 'desc']],
      columns: [
        { data: 'transaction_number', defaultContent: '-', render: (data, type, row) => {
          return `<a href="${_url}/asset/${row.uuid}">${row.transaction_number}</a>`
        }},
        { data: 'asset_code', defaultContent: '-'},
        { data: 'name', defaultContent: '-' },
        { data: 'grnno', defaultContent: '-'},
        {
          data: 'povalue', defaultContent: '-', render: function (data, type, row) {
            if (!row.povalue) {
              row.povalue = 0;
            }

            return addCommas(parseFloat(row.povalue));
          }
        },
        {
          data: 'usefullife', defaultContent: '-', render: function (data, type, row) {
            return addCommas(parseFloat(row.usefullife)) + ' Month';
          }
        },
        { data: 'account_asset', defaultContent: '-', searchable: false, orderable: false },
        { data: 'coa_accumulate.name', defaultContent: '-', render: (data, type, row) => {
          if (row.coa_accumulate) {
            return row.coa_accumulate.name + ' (' + row.coa_accumulate.code + ')';
          }

          return '-';
        }},
        { data: 'coa_expense.name', defaultContent: '-', render: (data, type, row) => {
          if (row.coa_expense) {
            return row.coa_expense.name + ' (' + row.coa_expense.code + ')';
          }

          return '-';
        }},
        { data: 'coa_depreciation.name', defaultContent: '-', render: (data, type, row) => {
          if (row.coa_depreciation) {
            return row.coa_depreciation.name + ' (' + row.coa_depreciation.code + ')';
          }

          return '-';
        }},
        { data: 'depreciationstart_format', name: 'depreciationstart', defaultContent: '-' },
        { data: 'depreciationend_format', name: 'depreciationend', defaultContent: '-' },
        { data: 'created_by', defaultContent: '-', searchable: false },
        { data: 'approved_by', defaultContent: '-', searchable: false },
        { data: 'action' }
      ]
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

    let approve = $('body').on('click', 'a.approve', function () {
      let _uuid = $(this).data('uuid');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/asset/approve',
        data: {
          _token: $('input[name=_token]').val(),
          uuid: _uuid
        },
        success: function (response) {
          if (response.status) {
            toastr.success(response.message, 'Success', {
              timeOut: 2000
            });

            master_asset_datatable.ajax.reload();
          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });
    })

    $(document).on('submit', '#form-depreciation', function (e) {
      e.preventDefault();

      let form = $(this);

      let data = form.serializeArray();
      let action = form.attr('action');

      $.ajax({
        type: "get",
        url: action,
        data: data,
        success: function (response) {
          if (response.status) {
            toastr.success(response.message, 'Success', {
              timeOut: 2000
            });

            $('.modal').modal('hide');
          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });
      
    });

    $(document).on('click', '.history-depreciation', function () {

      let url = $(this).data('url');

      $.ajax({
        type: "get",
        url: url,
        success: function (response) {

          let _modal = $('#modal_history_depreciation');
          _modal.find('.modal-body').html(response);
          _modal.modal('show');

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
  MasterAsset.init();
});
