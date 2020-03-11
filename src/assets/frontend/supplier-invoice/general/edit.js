let SupplierInvoice = {
	init: function () {

		let _url = window.location.origin;
		let _si_uuid = $('input[name=si_uuid]').val();

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

						toastr.success('Data tersimpan', 'Success', {
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
											toastr.success('AR has been deleted.', 'Deleted', {
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
									toastr.success('Data berhasil disimpan.', 'Success', {
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
					}
			});
    });

    let simpan_journala = $('body').on('click', '#create_detail_supplier', function () {

        let button = $(this);
        let form = button.parents('form');
        let uuid = form.find('input[name=uuid]').val();
        let _data = form.serialize();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: `/journala`,
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
                  toastr.success('Data Saved Successfully.', 'Success', {
                      timeOut: 2000
                  });

                  $('#modal_coa_create').modal('hide');
                  account_code_table.reload();

                  form.find('input#amount').val('');
                  form.find('input[type=radio]').prop('checked', false);
                  form.find('textarea:not([type=hidden])').val('');
                  $('#_accountcode').val('').trigger('change');
                }
            }
        });
    });

    $('#_accountcode').select2({
      ajax: {
        url: _url+'/journal/get-account-code-select2',
        dataType: 'json'
      },
      minimumInputLength: 3,
      // templateSelection: formatSelected
    });
	}
};

jQuery(document).ready(function () {
    SupplierInvoice.init();
});
