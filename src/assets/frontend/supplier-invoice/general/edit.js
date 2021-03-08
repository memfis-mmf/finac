let SupplierInvoice = {
	init: function () {

		let _url = window.location.origin;
    let _si_uuid = $('input[name=si_uuid]').val();

    $('#project').select2({
      placeholder: '-- Select --',
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
      minimumInputLength: 3,
    });

		function addCommas(nStr)
		{
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

		let coa_modal_table = $("#coa_datatables").DataTable({
				"dom": '<"top"f>rt<"bottom">pl',
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !0,
				lengthMenu: [5, 10, 25, 50],
				pageLength: 5,
				ajax: "/coa/datatables/modal",
				columns: [
						{
								data: 'code'
						},
						{
								data: "name"
						},
						{
								data: "Actions"
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

		let general_table = $('.general_datatable').mDatatable({
				data: {
						type: 'remote',
						source: {
								read: {
										method: 'GET',
										url: '/supplier-invoice/coa/items/datatables?si_uuid='+_si_uuid,
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
							filterable: !1,
						},
						{
							field: 'coa.name',
							title: 'Account Name',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'total',
							title: 'Total Amount',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.total));
							}
						},
						{
							field: 'description',
							title: 'Description',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'Actions',
							width: 110,
							sortable: !1,
							overflow: 'visible',
							template: function (t, e, i) {
								return (
									'<button type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-description='+t.description+' data-total='+t.total+' data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
									'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
									t.uuid +
									' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
									);
							}
						}

				]
		});

		$('.general_datatable').on('click', '.edit-item', function() {
			let uuid = $(this).data('uuid');
			let _modal = $('#modal_edit_account');

			let tr = $(this).parents('tr');
			let tr_index = tr.index();
			let data = general_table.row(tr).data().mDatatable.dataSet[tr_index];

			_modal.find('#account_code').val(data.code);
			_modal.find('#account_name').val(data.coa.name);
			_modal.find('#total_amount').val(parseInt(data.total));
			_modal.find('#description').val(data.description);
			_modal.find('input[name=uuid]').val(uuid);
			_modal.modal('show');
		});

		$('#coa_datatables').on('click', '.select-coa', function () {
			let tr = $(this).parents('tr');

			let data = coa_modal_table.row(tr).data();

			$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: _url+'/supplier-invoice/coa/use',
					data : {
						'account_code' : data.code,
						'si_uuid' : _si_uuid
					},
					success: function (data) {

						$('#coa_modal').modal('hide');

						general_table.reload();

						toastr.success('Data saved', 'Success', {
							timeOut: 2000
						});

					}
			});

		});

		let remove = $('.general_datatable').on('click', '.delete', function () {
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
									url: '/trxpaymentb/' + triggerid + '',
									success: function (data) {
											toastr.success('AP has been deleted.', 'Deleted', {
															timeOut: 2000
													}
											);

											general_table.reload();
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

		let update_trxpaymentb = $('body').on('click', '#update_account', function () {

				let button = $(this);
				let form = button.parents('form');
				let uuid = form.find('input[name=uuid]').val();
				let _data = form.serialize();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'put',
						url: `/trxpaymentb/${uuid}`,
						data: _data,
						success: function (data) {
								if (data.errors) {
										if (data.errors.code) {
											$('#code-error').html(data.errors.code[0]);

											document.getElementById('code').value = code;
											document.getElementById('name').value = name;
											document.getElementById('type').value = type;
											document.getElementById('level').value = level;
											document.getElementById('description').value = description;
											coa_reset();
										}

								} else {
									toastr.success('Data saved.', 'Success', {
											timeOut: 5000
									});

									$('#modal_edit_account').modal('hide');
									general_table.reload();
								}
						}
				});
		});

		let update = $('body').on('click', '#supplier_invoice_generalupdate', function () {

			let form = $(this).parents('form');
			let _data = form.serialize();
			let si_uuid = $('input[name=si_uuid]').val();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'PUT',
					url: '/supplier-invoice/'+si_uuid,
					data: _data,
					success: function (data) {
							if (data.errors) {
								if (data.errors.code) {
										$('#code-error').html(data.errors.code[0]);

										document.getElementById('code').value = code;
										document.getElementById('name').value = name;
										document.getElementById('type').value = type;
										document.getElementById('level').value = level;
										document.getElementById('description').value = description;
										coa_reset();
								}
							} else {
								toastr.success('Data Saved', 'Success', {
										timeOut: 2000
								});

								setTimeout(function(){
									location.href = `${_url}/supplier-invoice/`;
								}, 2000);
							}
					},
          error: function(xhr) {
            if (xhr.status == 422) {
              toastr.error('Please fill required field', 'Invalid', {
                timeOut: 2000
              });
            }else{
              toastr.error('Invalid Form', 'Invalid', {
                timeOut: 2000
              });
            }
          }
			});
    });

    let simpan_detail_supplier_invoice = $('body').on('click', '#create_detail_supplier', function () {

        let button = $(this);
        let form = button.parents('form');
        let uuid = form.find('input[name=uuid]').val();
        let _data = form.serialize();

        console.table(_data);
        console.table(
          _data.amount
        );

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: _url+'/supplier-invoice/coa/use',
            data : {
              'account_code' : form.find('[name=account_code]').val(),
              'amount' : form.find('[name=amount]').val(),
              'si_uuid' : _si_uuid,
              'remark' : form.find('[name=remark]').val(),
            },
            success: function (data) {
                if (data.errors) {
                    if (data.errors.code) {
                      $('#code-error').html(data.errors.code[0]);

                      document.getElementById('code').value = code;
                      document.getElementById('name').value = name;
                      document.getElementById('type').value = type;
                      document.getElementById('level').value = level;
                      document.getElementById('description').value = description;
                      coa_reset();
                    }

                } else {
                  toastr.success('Data Saved Successfully.', 'Success', {
                      timeOut: 2000
                  });

                  $('#modal_coa_create').modal('hide');
                  general_table.reload();

                  form.find('input#amount').val('');
                  form.find('input[type=radio]').prop('checked', false);
                  form.find('textarea:not([type=hidden])').val('');
                  $('#_accountcode').val('').trigger('change');
                }
            }
        });
    });

    $('#_accountcode').select2({
      placeholder: '-- Select --',
      ajax: {
        url: _url+'/journal/get-account-code-select2',
        dataType: 'json'
      },
      minimumInputLength: 3,
      // templateSelection: formatSelected
    });

    let supplier_invoice_adj_datatable = $('.supplier_invoice_adj_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: $('.supplier_invoice_adj_datatable').data('url'),
      order: [[ 0, "desc" ]],
      columns: [
        {data: 'created_at', visible: false},
        {data: 'coa.code'},
        {data: 'coa.name'},
        {data: 'debit_formated', name:'debit'},
        {data: 'credit_formated', name:'credit'},
        {data: 'description'},
        {data: 'action'},
      ]
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

    $(document).on('click', '#add_si_adj', function () {
      href = $(this).data('href');

      $.ajax({
        type: "get",
        url: href,
        dataType: "html",
        success: function (response) {
          $('.modal-section').html(response);
          modal = $('.modal-section .modal');

          modal.modal('show');
        }
      });
    });

    $(document).on('submit', '.modal-section form', function (e) {
      e.preventDefault();

      data = new FormData($(this)[0]);

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
            'content'
          )
        },
        type: "post",
        url: $(this).attr('action'),
        data: data,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          if (response.status) {
            toastr.success('Data Saved', 'Success', {
              timeOut: 2000
            });

            $('.modal').modal('hide');

            supplier_invoice_adj_datatable.ajax.reload();
          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });
    });

    $(document).on('click', '.supplier_invoice_adj_datatable .delete', function () {
      url = $(this).data('href');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
            'content'
          )
        },
        type: "post",
        url: url,
        data: {
          _method: 'delete'
        },
        dataType: "json",
        success: function (response) {
          toastr.success('Data Deleted', 'Success');

          $('.modal').modal('hide');
          supplier_invoice_adj_datatable.ajax.reload();
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
    SupplierInvoice.init();
});
