let MasterAsset = {
  init: function () {

    let _url = window.location.origin;
    let master_asset_datatable_url = `${_url}/asset/datatables`;

    $('._select2').select2();

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
      ajax: master_asset_datatable_url,
      order: [[0, 'desc']],
      columns: [
        { data: 'transaction_number', defaultContent: '-', class:'text-nowrap',
        render: (data, type, row) => {
          return `<a href="${_url}/asset/${row.uuid}">${row.transaction_number}</a>`
        }},
        { data: 'asset_code', defaultContent: '-', class:'text-nowrap',
        "render": function ( data, type, row, meta ) {
            if (row.asset_code) {
                return '<b><p class="text-left style="width:150px" mb-0">' + row.asset_code + '</b><br>' + row.name + '</p>';
            }
            else {
                return "-"
            }
        }},
        // { data: 'name', defaultContent: '-', class:'text-nowrap', },
        { data: 'grnno', defaultContent: '-', class:'text-nowrap'},
        {
          data: 'povalue', defaultContent: '-',
          render: function (data, type, row) {
            if (!row.povalue) {
              row.povalue = 0;
            }

            return '<p class="text-right text-nowrap">' + addCommas(parseFloat(row.povalue)) + '</p>';
        }},
        {
          data: 'usefullife', defaultContent: '-', class: 'text-center text-nowrap',
          render: function (data, type, row) {
            return addCommas(parseFloat(row.usefullife)) + ' Month';
          }},
        { data: 'account_asset', class:'text-center', defaultContent: '-', searchable: false, orderable: false,
        "render": function ( data, type, row, meta ) {
            if (row.account_asset) {
                return '<p class="text-center" style="width:120px">' + row.account_asset + '</p>';
            }
            else {
                return "-"
            }
        }},
        { data: 'coa_accumulate.name', defaultContent: '-',
        render: (data, type, row) => {
          if (row.coa_accumulate) {
            return '<p class="text-center" style="width:120px">' + row.coa_accumulate.name + ' (' + row.coa_accumulate.code + ')';
          }

          return '-';
        }},
        { data: 'coa_expense.name', defaultContent: '-',
        render: (data, type, row) => {
          if (row.coa_expense) {
            return '<p class="text-center" style="width:120px">' + row.coa_expense.name + ' (' + row.coa_expense.code + ')';
          }

          return '-';
        }},
        { data: 'coa_depreciation.name', defaultContent: '-',
        render: (data, type, row) => {
          if (row.coa_depreciation) {
            return '<p class="text-center" style="width:120px">' + row.coa_depreciation.name + ' (' + row.coa_depreciation.code + ')';
          }

          return '-';
        }},
        { data: 'depreciationstart_format', name: 'depreciationstart', defaultContent: '-', class:'text-center' },
        { data: 'depreciationend_format', name: 'depreciationend', defaultContent: '-', class:'text-center' },
        { data: 'status', name: 'approve', class: 'text-center'},
        { data: 'created_by', class: 'text-center',
        "render": function ( data, type, row, meta ) {
            if (row.created_by) {
                return `<p class="text-center" style="width:120px">${row.created_by}</p>`;
            }
            else {
                return "-"
            }
        }},
        { data: 'approved_by', name: 'approvals.created_at', class: 'text-center',
        "render": function ( data, type, row, meta ) {
            if (row.approved_by) {
                return `<p class="text-center" style="width:120px">${row.approved_by}</p>`;
            }
            else {
                return "-"
            }
        }},
        { data: 'action', class:'text-nowrap' }
      ]
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

    $(document).on('submit', '.form-filter-datatable', function (e) {
      e.preventDefault();

      data = $(this).serialize();

      master_asset_datatable.ajax.url(master_asset_datatable_url+'?'+data).load();
    });

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

            master_asset_datatable.ajax.reload(null, false);
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
