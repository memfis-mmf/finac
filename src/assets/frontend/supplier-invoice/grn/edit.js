let SupplierInvoice = {
    init: function () {

			let _url = window.location.origin;
			let _voucher_no = $('input[name=voucher_no]').val();

			let grn_table = $('.grn_datatable').mDatatable({
					data: {
							type: 'remote',
							source: {
									read: {
											method: 'GET',
											url: '/trxpaymenta/datatables',
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
								field: 'grn.number',
								title: 'GRN No.',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: '',
								title: 'Total Amount',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: 'description',
								title: 'Invoice No.',
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
										'<button type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-description='+t.description+' data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
										'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
										t.uuid +
										' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
										);
								}
							}

					]
			});

			$('.grn_datatable').on('click', '.edit-item', function() {
				let description = $(this).data('description');
				let uuid = $(this).data('uuid');
				let _modal = $('#modal_edit_grn'); 

				_modal.find('#invoice_no').val(description);
				_modal.modal('show');
			});

			let grn_modal_table = $('.grn_modal_datatable').mDatatable({
					data: {
							type: 'remote',
							source: {
									read: {
											method: 'GET',
											url: '/supplier-invoice/grn/datatables',
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
								field: 'received_at',
								title: 'Date',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: 'number',
								title: 'GRN No.',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: 'purchase_order.number',
								title: 'PO No.',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: 'purchase_order.purchase_request.number',
								title: 'PR No.',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: '',
								title: 'Total Amount',
								sortable: 'asc',
								filterable: !1,
							},
							{
								field: 'Actions',
								width: 110,
								sortable: !1,
								overflow: 'visible',
								template: function (t, e, i) {
									return '<a class="btn btn-primary btn-sm m-btn--hover-brand select-grn" title="View" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
								}
							}

					]
			});
	
			$('.grn_modal_datatable').on('click', '.select-grn', function () {

				let _uuid = $(this).data('uuid');
				let _si_uuid = $('input[name=si_uuid]').val();
				let _modal = $('.grn_modal_datatable').parents('.modal');

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: '/supplier-invoice/grn/use',
					data: {
						_token: $('input[name=_token]').val(),
						uuid: _uuid,
						si_uuid: _si_uuid,
					},
					success: function (data) {
						if (data.errors) {
							if (data.errors.customer_id) {
								$('#customer-error').html(data.errors.customer_id[0]);
							}
							if (data.errors.aircraft_register) {
								$('#reg-error').html(data.errors.aircraft_register[0]);
							}
							if (data.errors.aircraft_sn) {
								$('#serial-number-error').html(data.errors.aircraft_sn[0]);
							}
							if (data.errors.aircraft_id) {
								$('#applicability-airplane-error').html(data.errors.aircraft_id[0]);
							}
							if (data.errors.no_wo) {
								$('#work-order-error').html(data.errors.no_wo[0]);
							}
	
							document.getElementById('customer').value = data.getAll('customer_id');
							document.getElementById('work-order').value = data.getAll('no_wo');
							document.getElementById('applicability_airplane').value = data.getAll('aircraft_id');
							document.getElementById('reg').value = data.getAll('aircraft_register');
							document.getElementById('serial-number').value = data.getAll('aircraft_sn');
						} else {
	
							toastr.success('Data Used', 'Success',  {
								timeOut: 3000
							});
	
							grn_table.reload();
						}
					}
				});
			});
	
			let dispay_modal = $('body').on('click', '#show_modal_journala', function() {
				let _uuid = $(this).data('uuid');
				let _modal = $('#modal_coa_edit');
				let form = _modal.find('form');
				let tr = $(this).parents('tr');
				let data = grn_table.row(tr).data().mDatatable.dataSet[0];
				let amount = '';

				amount = parseInt(data.credit);

				form.find('input[value=kredit]').prop('checked', true);

				if (data.debit) {
					amount = parseInt(data.debit);
					form.find('input[value=debet]').prop('checked', true);
				}

				form.find('input[name=amount]').val(amount);
				form.find('textarea[name=remark]').val(data.description);

				_modal.find('input[name=uuid]').val(_uuid);
				_modal.modal('show');

			})

			let update_trxpaymenta = $('body').on('click', '#update_grn', function () {

					let button = $(this);
					let form = button.parents('form');
					let uuid = form.find('input[name=uuid]').val();
					let _data = form.serialize();

					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'put',
							url: `/journala/${uuid}`,
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
										toastr.success('Data berhasil disimpan.', 'Sukses', {
												timeOut: 5000
										});

										$('#modal_coa_edit').modal('hide');
										grn_table.reload();
									}
							}
					});
			});

			$('.paging_simple_numbers').addClass('pull-left');
			$('.dataTables_length').addClass('pull-right');
			$('.dataTables_info').addClass('pull-left');
			$('.dataTables_info').addClass('margin-info');
			$('.paging_simple_numbers').addClass('padding-datatable');

			let remove = $('.grn_datatable').on('click', '.delete', function () {
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
										url: '/trxpaymenta/' + triggerid + '',
										success: function (data) {
												toastr.success('AR has been deleted.', 'Deleted', {
																timeOut: 2000
														}
												);

												grn_table.reload();
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

    }
};

jQuery(document).ready(function () {
    SupplierInvoice.init();
});
