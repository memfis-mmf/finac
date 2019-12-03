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

			let grn_table = $('.grn_datatable').mDatatable({
					data: {
							type: 'remote',
							source: {
									read: {
											method: 'GET',
											url: '/supplier-invoice/grn/items/datatables?si_uuid='+_si_uuid,
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
										'<button type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
										'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
										t.uuid +
										' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
										);
								}
							}

					]
			});

			$('.grn_datatable').on('click', '.edit-item', function() {
				let uuid = $(this).data('uuid');
				let _modal = $('#modal_edit_grn');

				let tr = $(this).parents('tr');
				let tr_index = tr.index();
				let data = grn_table.row(tr).data().mDatatable.dataSet[tr_index];

				_modal.find('input#grn_no').val(data.grn.number);
				_modal.find('input#total_amount').val(addCommas(parseInt(data.total)));
				_modal.find('#invoice_no').val(data.description);
				_modal.find('input[name=uuid]').val(uuid);
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
				let _modal = $('.grn_modal_datatable').parents('.modal');

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: _url+'/supplier-invoice/grn/use',
					data: {
						_token: $('input[name=_token]').val(),
						uuid: _uuid,
						si_uuid: _si_uuid,
					},
					success: function (data) {
						if (data.errors) {
							toastr.error(data.errors, 'Invalid',  {
								timeOut: 2000
							});
						} else {

							toastr.success('Data Used', 'Success',  {
								timeOut: 2000
							});

							$('#modal_create_grn').modal('hide');

							grn_table.reload();
						}
					}
				});
			});

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
							url: `/trxpaymenta/${uuid}`,
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

										$('#modal_edit_grn').modal('hide');
										grn_table.reload();
									}
							}
					});
			});

			let update = $('body').on('click', '#supplier_invoice_grnupdate', function () {

				let form = $(this).parents('form');
				let _data = form.serialize();
				let si_uuid = $('input[name=si_uuid]').val();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'PUT',
						url: '/supplier-invoice/grn/'+si_uuid,
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
										toastr.success('Data Saved', 'Sukses', {
												timeOut: 2000
										});

										setTimeout(function(){
											location.href = `${_url}/supplier-invoice/`;
										}, 2000);
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
