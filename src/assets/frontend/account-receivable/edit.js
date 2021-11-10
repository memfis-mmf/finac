let AccountReceivableEdit = {
  init: function () {

    if (page_type == 'show') {
      $('input').attr('disabled', 'disabled');
      $('select').attr('disabled', 'disabled');
      $('textarea').attr('disabled', 'disabled');
      $('button').attr('disabled', 'disabled');
      $('button').hide();
    }

    let _url = window.location.origin;
    let ar_uuid = $('input[name=ar_uuid]').val();
    let id_customer = $('select[name=id_customer]').val();
    let number_format = new Intl.NumberFormat('de-DE');

    $('._select2').select2({
      placeholder: '-- Select --'
    });

    $('#project').select2({
      ajax: {
        url: _url + '/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $('select.project_detail').select2({
      placeholder: '-- Select --',
      width: '100%',
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $('.modal').on('hidden.bs.modal', function (e) {
      modal = $('.modal');

      modal.find('input').val('');
      modal.find('select').empty();
      modal.find('textarea').val('');
    })

    let coa_datatables = $("#coa_datatables").DataTable({
      "dom": '<"top"f>rt<"bottom">pl',
      responsive: !0,
      searchDelay: 500,
      processing: !0,
      serverSide: !0,
      lengthMenu: [5, 10, 25, 50],
      pageLength: 5,
      ajax: "/account-receivable/coa/datatables",
      columns: [
        {
          data: 'code'
        },
        {
          data: "name"
        },
        {
          data: "Actions",
                    searchable: false,
                    orderable: false
        }
      ],
      columnDefs: [{
        targets: -1,
        orderable: !1,
        render: function (a, e, t, n) {
          return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
        }
      },

      ]
    })

    let coa_datatables_adj = $("#coa_datatables_adj").DataTable({
      "dom": '<"top"f>rt<"bottom">pl',
      responsive: !0,
      searchDelay: 500,
      processing: !0,
      serverSide: !0,
      lengthMenu: [5, 10, 25, 50],
      pageLength: 5,
      ajax: $("#coa_datatables_adj").data('url'),
      columns: [
        {
          data: 'code'
        },
        {
          data: "name"
        },
        {
          data: "Actions",
                    searchable: false,
                    orderable: false
        }
      ],
      columnDefs: [{
        targets: -1,
        orderable: !1,
        render: function (a, e, t, n) {
          return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
        }
      },

      ]
    })

    let invoice_table = $('.invoice_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: _url + '/areceivea/datatables/?ar_uuid=' + ar_uuid,
            map: function (raw) {
              let dataSet = raw;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: !0,
        serverSorting: !0
      },
      layout: {
        theme: 'default',
        class: '',
        scroll: false,
        footer: !1
      },
      sortable: !0,
      filterable: !1,
      pagination: !0,
      search: {
        input: $('#generalSearch')
      },
      toolbar: {
        items: {
          pagination: {
            pageSizeSelect: [5, 10, 20, 30, 50, 100]
          }
        }
      },
      columns: [
        {
          field: 'invoice.transactionnumber',
          title: 'Transaction No.',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (data, type, row) {
            return '<b><p class="text-left mb-0">' + data.ar.date + '</p></b>' + '<p class="text-left">' + data.invoice.transactionnumber + '</p>';
        }},
        // {
        //   field: 'ar.transactiondate',
        //   title: 'Date',
        //   sortable: 'asc',
        //   filterable: !1,
        // },
        {
          field: 'currency',
          title: 'Currency',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
        },
        {
          field: 'exchangerate',
          title: 'Exchange Rate',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {
            return 'Rp ' + number_format.format(parseFloat(t.exchangerate));
        }},
        {
          field: 'invoice.grandtotalforeign',
          title: 'Total Amount',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.invoice.currencies.symbol + ' ' + number_format.format(parseFloat(t.invoice.grandtotalforeign)) + '</p>';
          }
        },
        {
          field: 'paid_amount',
          title: 'Paid Amount',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.invoice.currencies.symbol + ' ' + number_format.format(parseFloat(t.paid_amount)) + '</p>';
          }
        },
        {
          field: 'credit',
          title: 'Receive Amount',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.ar.currencies.symbol + ' ' + number_format.format(parseFloat(t.credit)) + '</p>';
          }
        },
        {
          field: '',
          title: 'Receive Amount (IDR)',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + 'Rp. ' + number_format.format(parseFloat(t.credit_idr)) + '</p>';
          }
        },
        {
          field: 'exchange_rate_gap',
          title: 'Exchange Rate Gap',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + 'Rp. ' + number_format.format(parseFloat((v = t.arc) ? v.gap : 0)) + '</p>';
          }
        },
        {
          field: 'description',
          title: 'Description',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          width: 150,
                template: function (data, type, row) {
                    if (data.description) {
                        return '<p class="text-left" mb-0>' + data.description + '</p>';
                    }
                    else {
                        return "-"
                    }
        }},
        {
            field: 'code',
            title: 'Account Code',
            sortable: 'asc',
            class: 'text-center',
            filterable: !1,
        },
        {
          field: 'actions',
          title: 'Actions',
          sortable: !1,
          class:'text-nowrap',
          overflow: 'visible',
          template: function (t, e, i) {

            if (page_type == 'show') {
              return '';
            }

            return (
              '<button data-target="#modal_edit_invoice" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
              '\t\t\t\t\t\t\t<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
              t.uuid +
              ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
            );
          }
        }
      ]
    });

    let adjustment_datatable = $('.adjustment_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: _url + '/areceiveb/datatables/?ar_uuid=' + ar_uuid,
            map: function (raw) {
              let dataSet = raw;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: !0,
        serverSorting: !0
      },
      layout: {
        theme: 'default',
        class: '',
        scroll: false,
        footer: !1
      },
      sortable: !0,
      filterable: !1,
      pagination: !0,
      search: {
        input: $('#generalSearch')
      },
      toolbar: {
        items: {
          pagination: {
            pageSizeSelect: [5, 10, 20, 30, 50, 100]
          }
        }
      },
      columns: [
        {
          field: 'code',
          title: 'Account Code',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (data, type, row) {
            return '<b><p class="text-left mb-0">' + data.code + '</b></p>' + '<p class="text-left">' + data.name + '</p>';
        }},
        // {
        //   field: 'name',
        //   title: 'Account Name',
        //   sortable: 'asc',
        //   filterable: !1,
        // },
        {
            field: 'project.code',
            title: 'Project',
            sortable: 'asc',
            class: 'text-center',
            filterable: !1,
            width: '150px',
        },
        {
          field: 'debit',
          title: 'Debit',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap">' + t.ar.currencies.symbol + ' ' + number_format.format(parseFloat(t.debit)) + '</p>';
          }
        },
        {
          field: 'credit',
          title: 'Credit',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap">' + t.ar.currencies.symbol + ' ' + number_format.format(parseFloat(t.credit)) + '</p>';
          }
        },
        {
          field: 'description',
          title: 'Description',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (data, type, row) {
            if (data.description) {
                return '<p class="text-left">' + data.description + '</p>';
            }
            else {
                return "-"
            }
        }},
        {
          field: 'actions',
          title: 'Actions',
          sortable: !1,
          class: 'text-nowrap',
          overflow: 'visible',
          template: function (t, e, i) {

            if (page_type == 'show') {
              return '';
            }

            return (
              '<button data-target="#modal_edit_adjustment" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
              '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
              t.uuid +
              ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
            );
          }
        }

      ]
    });

    let invoice_modal_table = $('.invoice_modal_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: `${_url}/account-receivable/invoice/modal/datatable/?ar_uuid=${ar_uuid}&id_customer=${id_customer}`,
      pageLength: 100,
      columns: [
        { data: 'transactionnumber', class: 'text-nowrap',
            "render": function ( data, type, row, meta ) {
                return '<b>' + row.transactiondate + '</b><br>' + row.transactionnumber ;
        }},
        // { data: 'transactiondate', visible:false },
        { data: 'due_date', class:'text-center'},
        {
          data: 'exchangerate', class: 'text-center',
          render: (data, type, row) => {
            return 'Rp '+number_format.format(parseFloat(row.exchangerate));
        }},
        {
          data: 'grandtotalforeign', class: 'text-center',
          render: (data, type, row) => {
            return '<p class="text-right text-nowrap">' + row.currencies.symbol+' '+number_format.format(parseFloat(row.grandtotalforeign))+ '</p>';
        }},
        {
          data: 'grandtotal', class: 'text-center',
          render: (data, type, row) => {
            return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(row.grandtotal)) + '</p>';
        }},
        {
          data: 'paid_amount', class: 'text-center',
          render: (data, type, row) => {
            return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(row.paid_amount)) + '</p>';
        }},
        {
          data: 'exchange_rate_gap', class: 'text-center',
          render: (data, type, row) => {
            return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(row.exchange_rate_gap)) + '</p>';
        }},
        { data: 'coas.code', class:'text-center' },
        // { data: 'description' },
        {
          data: '', searchable: false, render: function (data, type, row) {
            t = row;

            return (
              '<a class="btn btn-primary btn-sm m-btn--hover-brand select-invoice" title="View" data-type="' + t.x_type + '" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
            );
          }
        }
      ]
    });


    $(document).on('click', '.btn-modal-create-invoice', function () {
      invoice_modal_table.ajax.reload(null, false);
    });

    $('body').on('click', '.select-invoice', function () {

      let data_uuid = $(this).data('uuid');
      let type = $(this).data('type');

      let tr = $(this).parents('tr');

      let data = invoice_modal_table.row(tr).data();

      $.ajax({
        url: _url + '/areceivea',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        dataType: 'json',
        data: {
          'account_code': data.code,
          'ar_uuid': ar_uuid,
          'data_uuid': data_uuid,
          'type': type,
        },
        success: function (data) {

          if (data.errors) {
            toastr.error(data.errors, 'Invalid', {
              timeOut: 2000
            });
          } else {
            $('#modal_create_invoice').modal('hide');

            invoice_table.reload();
            invoice_modal_table.ajax.reload(null, false);

            toastr.success('Data saved', 'Success', {
              timeOut: 2000
            });
          }

        }
      });

    });

    $('#coa_datatables').on('click', '.select-coa', function () {
      let tr = $(this).parents('tr');
      let data = coa_datatables.row(tr).data();

      $('input[name=accountcode]').val(data.code);
      $('input[name=account_name]').val(data.name);

      $('.modal').modal('hide');
    });

    $('#coa_datatables_adj').on('click', '.select-coa', function () {

      coa_uuid = $(this).data('uuid');

      $.ajax({
        url: _url + '/areceiveb',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        dataType: 'json',
        data: {
          'coa_uuid': coa_uuid,
          'ar_uuid': ar_uuid
        },
        success: function (data) {

          $('#coa_modal_adj').modal('hide');

          adjustment_datatable.reload();

          toastr.success('Data saved', 'Success', {
            timeOut: 2000
          });

        }
      });

    });

    let remove = $('.invoice_datatable').on('click', '.delete', function () {
      let triggerid = $(this).data('uuid');

      swal({
        title: 'Sure want to remove?',
        type: 'question',
        confirmButtonText: 'Yes, REMOVE',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        showCancelButton: true,
      }).then(result => {
        if (result.value) {

          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content'
              )
            },
            type: 'DELETE',
            url: '/areceivea/' + triggerid + '',
            success: function (data) {
              toastr.success('Data has been deleted.', 'Deleted', {
                timeOut: 2000
              }
              );

              invoice_table.reload();
            },
            error: function (jqXhr, json, errorThrown) {
              let errorsHtml = '';
              let errors = jqXhr.responseJSON;

              $.each(errors.errors, function (index, value) {
                $('#delete-error').html(value);
              });
            }
          });
        }
      });
    });

    let remove_adjustment = $('.adjustment_datatable').on('click', '.delete', function () {
      let triggerid = $(this).data('uuid');

      swal({
        title: 'Sure want to remove?',
        type: 'question',
        confirmButtonText: 'Yes, REMOVE',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        showCancelButton: true,
      }).then(result => {
        if (result.value) {

          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content'
              )
            },
            type: 'DELETE',
            url: '/areceiveb/' + triggerid + '',
            success: function (data) {
              toastr.success('Data has been deleted.', 'Deleted', {
                timeOut: 2000
              }
              );

              adjustment_datatable.reload();
            },
            error: function (jqXhr, json, errorThrown) {
              let errorsHtml = '';
              let errors = jqXhr.responseJSON;

              $.each(errors.errors, function (index, value) {
                $('#delete-error').html(value);
              });
            }
          });
        }
      });
    });

    let update_invoice = $('body').on('click', '#update_invoice', function () {

      let modal = $(this).parents('.modal');
      let _data = {
        'credit': modal.find('input[name=credit]').val(),
        'description': modal.find('[name=description]').val(),
        'is_clearing': (modal.find('[name=is_clearing]:checked').length) ? '1' : '0',
      };
      let invoice_uuid = modal.find('input[name=invoice_uuid]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: _url + '/areceivea/' + invoice_uuid,
        data: _data,
        success: function (data) {
          if (data.errors) {
            toastr.error(data.errors, 'Invalid', {
              timeOut: 2000
            });
          } else {
            toastr.success('Data saved.', 'Success', {
              timeOut: 2000
            });

            $('#modal_edit_invoice').modal('hide');
            invoice_table.reload();
          }
        }
      });
    });

    $('.invoice_datatable').on('click', '.edit-item', function () {
      let target = $(this).data('target');
      let uuid = $(this).data('uuid');

      let tr = $(this).parents('tr');
      let tr_index = tr.index();
      let data = invoice_table.row(tr).data().mDatatable.dataSet[tr_index];
      let currency = $('[name=currency]').val();

      if (currency == 'idr') {
        amount = data.credit_idr;
      } else {
        amount = data.credit;
      }

      $(target).find('input[name=invoice_uuid]').val(uuid);
      $(target).find('[name=description]').val(data.description);
      $(target).find('input[name=credit]').val(
        parseFloat(amount)
      );

      $(target).find('.balance_amount').val(
        data.invoice.currencies.symbol + ' ' +
        number_format.format(parseFloat(data.invoice.grandtotalforeign - data.paid_amount - amount))
      )

      $(target).find('.iv_date').val(data.ar.transactiondate);
      $(target).find('.iv_transactionnumber').val(data.invoice.transactionnumber);
      $(target).find('.iv_code').val(data.code);
      $(target).find('.iv_currency').val(data.currency);
      $(target).find('.iv_exchangerate').val('Rp ' + number_format.format(parseFloat(data.exchangerate)));
      $(target).find('.iv_total_amount').val(data.invoice.currencies.symbol + ' ' + number_format.format(parseFloat(data.invoice.grandtotalforeign)));
      $(target).find('.iv_paid_amount').val(data.invoice.currencies.symbol + ' ' + number_format.format(parseFloat(data.paid_amount)));
      $(target).find('.iv_exchangerate_gap').val('Rp ' + number_format.format(parseFloat(v = data.arc) ? v.gap : 0));
      $(target).find('.atp_symbol').html(data.ar.currencies.symbol);

      $(target).modal('show');
    })

    $('.adjustment_datatable').on('click', '.edit-item', function () {
      let target = $(this).data('target');
      let uuid = $(this).data('uuid');

      let tr = $(this).parents('tr');
      let tr_index = tr.index();
      let data = adjustment_datatable.row(tr).data().mDatatable.dataSet[tr_index];

      $(target).find('input[name=_uuid]').val(uuid);
      $(target).find('[name=debit_b]').val(parseFloat(data.debit));
      $(target).find('[name=credit_b]').val(parseFloat(data.credit));
      $(target).find('[name=description_b]').val(data.description);

      if (data.project) {
        $(target).find('.project_detail')
          .append(new Option(data.project.code, data.id_project, false, true));
      }

      $(target).modal('show');
    })

    let update_adj = $('body').on('click', '#update_adjustment', function () {

      let form = $(this).parents('form');
      let _data = form.serialize();
      let _uuid = form.find('input[name=_uuid]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: _url + '/areceiveb/' + _uuid,
        data: _data,
        success: function (data) {
          if (data.errors) {
            toastr.error(data.errors, 'Invalid', {
              timeOut: 2000
            });
          } else {
            toastr.success('Data saved.', 'Success', {
              timeOut: 2000
            });

            $('#modal_edit_adjustment').modal('hide');
            adjustment_datatable.reload();
          }
        }
      });
    });

    let update = $('body').on('click', '#account_receivable_save', function () {

      let form = $(this).parents('form');
      let _data = form.serialize();
      let ar_uuid = form.find('input[name=ar_uuid]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: _url + '/account-receivable/' + ar_uuid,
        data: _data,
        success: function (data) {
          if (data.errors) {
            toastr.error(data.errors, 'Invalid', {
              timeOut: 2000
            });
          } else {
            toastr.success('Data saved', 'Success', {
              timeOut: 2000
            });

            setTimeout(function () {
              location.href = `${_url}/account-receivable/`;
            }, 2000);
          }
        },
        error: function (xhr) {
          if (xhr.status == 422) {
            toastr.error('Please fill required field', 'Invalid', {
              timeOut: 2000
            });
          } else {
            toastr.error('Invalid Form', 'Invalid', {
              timeOut: 2000
            });
          }
        }
      });
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

  }
};

jQuery(document).ready(function () {
  AccountReceivableEdit.init();
});
