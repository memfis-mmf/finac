let AccountPayable = {
  init: function () {

    if (page_type == 'show') {
      $('input').attr('disabled', 'disabled');
      $('select').attr('disabled', 'disabled');
      $('textarea').attr('disabled', 'disabled');
      $('button').attr('disabled', 'disabled');
      $('button').hide();
    }

    let _url = window.location.origin;
    let ap_uuid = $('input[name=ap_uuid]').val();
    let id_vendor = $('select[name=id_supplier]').val();
    let number_format = new Intl.NumberFormat('de-DE');

    $('._select2').select2({
      placeholder: '-- Select --'
    });

    $('.modal').on('shown.bs.modal', function (e) {
      // supplier_invoice_modal_table.reload();
      // supplier_invoice_modal_datatable.reload();
      // supplier_invoice_modal_datatable.reload();
      supplier_invoice_modal_datatable.ajax.reload(null, false);
      grn_modal_datatable.ajax.reload(null, false);
    })

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
          if (page_type == 'show') {
            return '';
          }

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
          if (page_type == 'show') {
            return '';
          }
          return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
        }
      },

      ]
    })

    let supplier_invoice_table = $('.supplier_invoice_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: _url + '/apaymenta/datatables/?ap_uuid=' + ap_uuid,
            map: function (raw) {
              let dataSet = raw;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
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
          field: '_transaction_number',
          title: 'Transaction No.',
          sortable: 'asc',
          width: '140px',
          filterable: !1,
          template: function (data, type, row) {
            return '<b><p class="text-left mb-0">' + data.ap.date + '</b></p>' + '<p class="text-left text-nowrap mb-0">' + data._transaction_number + '</p>';
        }},
        // {
        //   field: 'ap.date',
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
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + 'Rp ' + number_format.format(parseFloat(t.exchangerate)) + '</p>';
        }},
        {
          field: 'si.grandtotal_foreign',
          title: 'Total Amount',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.si.currencies.symbol + ' ' + number_format.format(parseFloat(t.si.grandtotal_foreign)) + '</p>';
        }},
        {
          field: 'paid_amount',
          title: 'Paid Amount',
          class: 'text-center',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.si.currencies.symbol + ' ' + number_format.format(parseFloat(t.paid_amount)) + '</p>';
        }},
        {
          field: 'code',
          title: 'Account Code',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
        },
        {
          field: 'debit',
          title: 'Amount to Pay',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.si.currencies.symbol + ' ' + number_format.format(parseFloat(t.debit)) + '</p>';
        }},
        {
          field: '',
          title: 'Amount to Pay IDR',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + 'Rp. ' + number_format.format(parseFloat(t.debit_idr)) + '</p>';
        }},
        {
          field: 'exchange_rate_gap',
          title: 'Exchange Rate Gap',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + 'Rp. ' + number_format.format(parseFloat((v = t.apc) ? v.gap : 0)) + '</p>';
        }},
        {
          field: 'description',
          title: 'Description',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (data, type, row) {
            return '<p class="text-left mb-0">' + data.description + '</p>';
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
              '<button data-target="#modal_edit_supplier_invoice" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
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
            url: _url + '/apaymentb/datatables/?ap_uuid=' + ap_uuid,
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
            return '<b><p class="text-left style="width:120px" mb-0"  >' + data.code + '</b><br>' + data.name;
        }},
        // {
        //   field: 'name',
        //   title: 'Account Name',
        //   sortable: 'asc',
        //   filterable: !1,
        // },
        {
          field: 'debit',
          title: 'Debit',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.ap.currencies.symbol + ' ' + number_format.format(parseFloat(t.debit)) + '</p>';
          }
        },
        {
          field: 'credit',
          title: 'Credit',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (t, e, i) {
            return '<p class="text-right text-nowrap mb-0">' + t.ap.currencies.symbol + ' ' + number_format.format(parseFloat(t.credit)) + '</p>';
          }
        },
        {
            field: 'project.code',
            title: 'Project',
            sortable: 'asc',
            class: 'text-center text-nowrap mb-0',
            filterable: !1,
            width: '150px'
          },
        {
          field: 'description',
          title: 'Description',
          sortable: 'asc',
          class: 'text-center',
          filterable: !1,
          template: function (data, type, row) {
            return '<p class="text-left">' + data.description + '</p>';
        }},
        {
          field: 'actions',
          title: 'Actions',
          sortable: !1,
          class: 'text-center text-nowrap',
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
        url: _url + '/apaymentb',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        dataType: 'json',
        data: {
          'coa_uuid': coa_uuid,
          'ap_uuid': ap_uuid
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

    let remove = $('.supplier_invoice_datatable').on('click', '.delete', function () {
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
            url: '/apaymenta/' + triggerid + '',
            success: function (data) {
              toastr.success('Data has been deleted.', 'Deleted', {
                timeOut: 2000
              }
              );

              supplier_invoice_table.reload();
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
            url: '/apaymentb/' + triggerid + '',
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

    let update_si = $('body').on('click', '#update_supplier_invoice', function () {

      let modal = $(this).parents('.modal');
      let _data = {
        'debit': modal.find('input[name=debit]').val(),
        'description': modal.find('[name=description]').val(),
        'is_clearing': (modal.find('[name=is_clearing]:checked').length) ? '1' : '0',
      };
      let si_uuid = modal.find('input[name=si_uuid]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: _url + '/apaymenta/' + si_uuid,
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

            $('#modal_edit_supplier_invoice').modal('hide');
            supplier_invoice_table.reload();
          }
        }
      });
    });

    $('.supplier_invoice_datatable').on('click', '.edit-item', function () {
      let target = $(this).data('target');
      let uuid = $(this).data('uuid');

      let tr = $(this).parents('tr');
      let tr_index = tr.index();
      let data = supplier_invoice_table.row(tr).data().mDatatable.dataSet[tr_index];
      let currency = $('[name=currency]').val();

      if (currency == 'idr') {
        amount = data.debit_idr;
      } else {
        amount = data.debit;
      }

      $(target).find('input[name=si_uuid]').val(uuid);
      $(target).find('[name=description]').val(data.description);
      $(target).find('input[name=debit]').val(
        parseFloat(amount)
      );

      $(target).find('.balance_amount').val(
        data.si.currencies.symbol + ' ' +
        number_format.format(parseFloat(data.si.grandtotal_foreign - data.paid_amount - amount))
      )

      $(target).find('.iv_date').val(data.ap.transactiondate);
      $(target).find('.iv_transactionnumber').val(data._transaction_number);
      $(target).find('.iv_code').val(data.code);
      $(target).find('.iv_currency').val(data.currency);
      $(target).find('.iv_exchangerate').val('Rp ' + number_format.format(parseFloat(data.exchangerate)));
      $(target).find('.iv_total_amount').val(data.si.currencies.symbol + ' ' + number_format.format(parseFloat(data.si.grandtotal_foreign)));
      $(target).find('.iv_paid_amount').val(data.si.currencies.symbol + ' ' + number_format.format(parseFloat(data.paid_amount)));
      $(target).find('.iv_exchangerate_gap').val('Rp ' + number_format.format(parseFloat(v = data.apc) ? v.gap : 0));
      $(target).find('.atp_symbol').html(data.ap.currencies.symbol);

      $(target).modal('show');
    })

    $('.adjustment_datatable').on('click', '.edit-item', function () {
      let target = $(this).data('target');
      let uuid = $(this).data('uuid');

      let tr = $(this).parents('tr');
      let tr_index = tr.index();
      let data = adjustment_datatable.row(tr).data().mDatatable.dataSet[tr_index];

      $(target).find('input[name=_uuid]').val(uuid);
      $(target).find('[name=debit_b]').val(parseInt(data.debit));
      $(target).find('[name=credit_b]').val(parseInt(data.credit));
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
        url: _url + '/apaymentb/' + _uuid,
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

            $('#modal_edit_adjustment').modal('hide');
            adjustment_datatable.reload();
          }
        }
      });
    });

    let update = $('body').on('click', '#account_payable_save', function () {

      let form = $(this).parents('form');
      let _data = form.serialize();
      let ap_uuid = form.find('input[name=ap_uuid]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: _url + '/account-payable/' + ap_uuid,
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
              location.href = `${_url}/account-payable/`;
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

		let supplier_invoice_modal_datatable = $('.supplier_invoice_modal_datatable').DataTable({
			dom: '<"top"f>rt<"bottom">pil',
			scrollX: true,
			processing: true,
			serverSide: true,
      responsive: true,
			lengthMenu: [5, 10, 23, 50, 100],
			serverSide: true,
			order: [
				[8, 'desc'],
				[0, 'desc'],
			],
			ajax: _url 
        + '/account-payable/si/modal/datatable/?ap_uuid=' + ap_uuid 
        + ' &id_vendor=' + id_vendor
        + ' page_type=' + page_type,
			oLanguage: {
            sLengthMenu: "_MENU_",
			},
			columnDefs: [
				{
					targets: [0,1,2,3],
					"className": "text-left" 
				}
			],
			columns: [
				{ data: 'transaction_number'},
				{ data: 'currency'},
				{
					data: 'exchange_rate', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + 'Rp' + number_format.format(parseFloat(row.exchange_rate)) + '</p>';
					}
				},
				{
					data: 'grandtotal_foreign', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + row.currencies.symbol + number_format.format(parseFloat(row.grandtotal_foreign)) + '</p>';
					}
				},
				{
					data: 'grandtotal', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + row.currencies.symbol + number_format.format(parseFloat(row.grandtotal)) + '</p>';
					}
				},
				{
					data: 'grandtotal', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + 'Rp' + number_format.format(parseFloat(row.paid_amount)) + '</p>';
					}
				},
				{ data: 'coa.code'},
				{
					data: 'description', render: function (data, type, row) {
						return '<p class="text-left">' + row.description ?? '' + '</p>';
					}
				},
				{
					data: 'action', orderable: false, searchable: false
				}
			]
		});

		let grn_modal_datatable = $('.grn_modal_datatable').DataTable({
			dom: '<"top"f>rt<"bottom">pil',
			scrollX: true,
			processing: true,
			serverSide: true,
      responsive: true,
			lengthMenu: [5, 10, 23, 50, 100],
			serverSide: true,
			order: [
				[8, 'desc'],
				[0, 'desc'],
			],
			ajax: _url + '/account-payable/grn/modal/datatable/?ap_uuid=' + ap_uuid + ' &id_vendor=' + id_vendor,
			oLanguage: {
            sLengthMenu: "_MENU_",
			},
			columnDefs: [
				{
					targets: [0,1,2,3],
					"className": "text-left" 
				}
			],
			columns: [
				{ data: 'number'},
				{ data: 'trxpaymenta.si.transaction_number'},
				{ data: 'due_date'},
				{
					data: 'exchange_rate', searchable: false, orderable: false, render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + 'Rp' + number_format.format(parseFloat(row.trxpaymenta.si.exchange_rate)) + '</p>';
					}
				},
				{
					data: 'total_amount', searchable: false, orderable: false, render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + row.trxpaymenta.si.currencies.symbol + number_format.format(parseFloat(row.total_amount)) + '</p>';
					}
				},
				{
					data: 'total_amount', searchable: false, orderable: false, render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + row.trxpaymenta.si.currencies.symbol + number_format.format(parseFloat(row.total_amount * row.rate)) + '</p>';
					}
				},
				{
					data: 'grandtotal', searchable: false, orderable: false, render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + 'Rp' + number_format.format(parseFloat(row.paid_amount)) + '</p>';
					}
				},
				{ data: 'trxpaymenta.si.coa.code'},
				{
					data: 'description', render: function (data, type, row) {
						return '<p class="text-left">' + row.description ?? '' + '</p>';
					}
				},
				{
					data: 'action', orderable: false, searchable: false
				}
			]
		});

		$(".dataTables_length select").addClass("form-control m-input");
		$(".dataTables_filter").addClass("pull-left");
		$(".paging_simple_numbers").addClass("pull-left");
		$(".dataTables_length").addClass("pull-right");
		$(".dataTables_info").addClass("pull-right");
		$(".dataTables_info").addClass("margin-info");
		$(".paging_simple_numbers").addClass("padding-datatable");

    function selectSI(elem, datatable) {

			let data_uuid = elem.data('uuid');
			let type = elem.data('type');
	
			let tr = elem.parents('tr');
	
			let data = datatable.row(tr).data();
	
			$.ajax({
				url: _url + '/apaymenta',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'post',
				dataType: 'json',
				data: {
					'account_code': data.account_code,
					'ap_uuid': ap_uuid,
					'data_uuid': data_uuid,
					'type': type,
				},
				success: function (data) {

          if (data.errors) {
            toastr.error(data.errors, 'Invalid', {
              timeOut: 2000
            });
            
          } else {
            $('.modal').modal('hide');
    
            supplier_invoice_table.reload();
            // supplier_invoice_modal_datatable.reload();
            supplier_invoice_modal_datatable.ajax.reload(null, false);
            grn_modal_datatable.ajax.reload(null, false);

    
            toastr.success('Data saved', 'Success', {
              timeOut: 2000
            });
          }
				}
			});     
    }

		$('body').on('click', '.select-supplier-invoice', function () {
      selectSI($(this), supplier_invoice_modal_datatable)
		});

    $('body').on('click', '.select-grn', function () {
      selectSI($(this), grn_modal_datatable)
		});
  }
};

jQuery(document).ready(function () {
  AccountPayable.init();
});



// File Temporary

// let supplier_invoice_modal_table = $('.supplier_invoice_modal_datatable').mDatatable({
    //   data: {
    //     type: 'remote',
    //     source: {
    //       read: {
    //         method: 'GET',
    //         url: `${_url}/account-payable/si/modal/datatable/?ap_uuid=${ap_uuid}&id_vendor=${id_vendor}`,
    //         map: function (raw) {
    //           let dataSet = raw;

    //           if (typeof raw.data !== 'undefined') {
    //             dataSet = raw.data;
    //           }

    //           return dataSet;
    //         }
    //       }
    //     },
    //     serverPaging: !0,
    //     serverSorting: !0
    //   },
    //   layout: {
    //     theme: 'default',
    //     class: '',
    //     scroll: false,
    //     footer: !1
    //   },
    //   sortable: !0,
    //   filterable: !1,
    //   pagination: !1,
    //   search: {
    //     input: $('#generalSearch')
    //   },
    //   toolbar: {
    //     items: {
    //       pagination: {
    //         pageSizeSelect: [5, 10, 20, 30, 50, 100]
    //       }
    //     }
    //   },
    //   columns: [
    //     {
    //       field: 'transaction_number',
    //       title: 'Transaction No.',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       width: 150,
    //       filterable: !1,
    //       template: function (data, type, row) {
    //         return '<b><p class="text-left text-nowrap mb-0">' + data.transaction_date + '</b></p>' + '<p class="text-left text-nowrap">' + data.transaction_number + '</p>';
    //     }},
    //     // {
    //     //   field: 'transaction_date',
    //     //   title: 'Date',
    //     //   sortable: 'asc',
    //     //   filterable: !1,
    //     // },
    //     {
    //       field: 'due_date',
    //       title: 'Due Date',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //     },
    //     {
    //       field: 'exchange_rate',
    //       title: 'Exchange Rate',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //       template: function (t, e, i) {
    //         return '<p class="text-right text-nowrap">' + 'Rp'+number_format.format(parseFloat(t.exchange_rate)) + '</p>';
    //     }},
    //     {
    //       field: 'grandtotal_foreign',
    //       title: 'Total Amount',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //       template: function (t, e, i) {
    //         return '<p class="text-right text-nowrap">' + t.currencies.symbol+' '+number_format.format(parseFloat(t.grandtotal_foreign)) + '</p>';
    //     }},
    //     {
    //       field: 'grnadtotal',
    //       title: 'Total Amount (IDR)',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //       template: function (t, e, i) {
    //         return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(t.grandtotal)) + '</p>';
    //     }},
    //     {
    //       field: 'paid_amount',
    //       title: 'Paid Amount',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //       template: function (t, e, i) {
    //         return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(t.paid_amount)) + '</p>';
    //     }},
    //     {
    //       field: 'coa.code',
    //       title: 'Account Code',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //     },
    //     // {
    //     //   field: '',
    //     //   title: 'Exchange Rate Gap',
    //     //   sortable: 'asc',
    //     //   class: 'text-center',
    //     //   filterable: !1,
    //     //   template: function (t, e, i) {
    //     //     return '<p class="text-right text-nowrap">' + 'Rp '+number_format.format(parseFloat(t.exchange_rate_gap))+ '</p>';
    //     // }}hide krn cukup menampilkan exchange gap di datatable edit AP aja,
    //     {
    //       field: 'description',
    //       title: 'Description',
    //       sortable: 'asc',
    //       class: 'text-center',
    //       filterable: !1,
    //       template: function (data, type, row) {
    //         return '<p class="text-left">' + data.description ?? '-' + '</p>';
    //     }},
    //     {
    //       field: 'actions',
    //       title: 'Actions',
    //       sortable: !1,
    //       class: 'text-nowrap',
    //       overflow: 'visible',
    //       template: function (t, e, i) {
    //         if (page_type == 'show') {
    //           return '';
    //         }
    //         return (
    //           '<a class="btn btn-primary btn-sm m-btn--hover-brand select-supplier-invoice" title="View" data-type="' + t.x_type + '" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
    //         );
    //       }
    //     }

    //   ]
    // });

    // $('body').on('click', '.select-supplier-invoice', function () {

    //   let data_uuid = $(this).data('uuid');
    //   let type = $(this).data('type');

    //   let tr = $(this).parents('tr');
    //   let tr_index = tr.index();

    //   let data = supplier_invoice_modal_table.row(tr).data().mDatatable.dataSet[tr_index];

    //   $.ajax({
    //     url: _url + '/apaymenta',
    //     headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     type: 'post',
    //     dataType: 'json',
    //     data: {
    //       'account_code': data.code,
    //       'ap_uuid': ap_uuid,
    //       'data_uuid': data_uuid,
    //       'type': type,
    //     },
    //     success: function (data) {

    //       if (data.errors) {
    //         toastr.error(data.errors, 'Invalid', {
    //           timeOut: 2000
    //         });
    //       } else {
    //         $('#modal_create_supplier_invoice').modal('hide');

    //         supplier_invoice_table.reload();
    //         supplier_invoice_modal_table.reload();

    //         toastr.success('Data saved', 'Success', {
    //           timeOut: 2000
    //         });
    //       }

    //     }
    //   });

    // });