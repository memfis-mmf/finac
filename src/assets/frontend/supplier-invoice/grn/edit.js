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
											url: '/journala/datatables?voucher_no=' + _voucher_no,
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
								field: '',
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
								field: '',
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
										'<button id="modal_edit_grn" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
										'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
										t.uuid +
										' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
										);
								}
							}

					]
			});

			$("#grn_modal_datatable").DataTable({
				"dom": '<"top"f>rt<"bottom">pl',
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !0,
				lengthMenu: [5, 10, 25, 50],
				pageLength: 5,
				ajax: "/datatables/workpackage/modal",
				columns: [
					{
						data: "code"
					},
					{
						data: "title"
					},
					{
						data: "title"
					},
					{
						data: "aircraft.name"
					},
					{
						data: "aircraft.name"
					},
					{
						data: "Actions"
					}
				],
				columnDefs: [{
						targets: -1,
						orderable: !1,
						render: function (a, e, t, n) {
							return '<a class="btn btn-primary btn-sm m-btn--hover-brand select-grn" title="View" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
						}
					},
	
				]
			})
	
			$('#grn_modal_datatable').on('click', '.select-grn', function () {
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: '/project-hm/' + project_uuid +'/workpackage',
					data: {
						_token: $('input[name=_token]').val(),
						workpackage: $(this).data('uuid'),
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
							$('#modal_project').modal('hide');
	
							toastr.success('Work Package has been created.', 'Success',  {
								timeOut: 5000
							});
	
							let table = $('.workpackage_datatable').mDatatable();
	
							table.originalDataSet = [];
							table.reload();
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

			let ubah_journala = $('body').on('click', '#update_journala', function () {

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

			let ubah = $('body').on('click', '#journalsave', function () {

					let button = $(this);
					let form = button.parents('form');
					let _data = form.serialize();
					let uuid = button.data('uuid');

					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'put',
							url: `/journal/${uuid}`,
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

											setTimeout(function(){ 
												location.href = `${_url}/journal`; 
											}, 2000);
									}
							}
					});
			});

			let coa_table = $("#coa_datatables").DataTable({
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

			// $('<a class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air btn-primary btn-sm refresh" style="margin-left: 60%; color: white;"><span><i class="la la-refresh"></i><span>Reload</span></span> </button>').appendTo('div.dataTables_filter');
			$('.paging_simple_numbers').addClass('pull-left');
			$('.dataTables_length').addClass('pull-right');
			$('.dataTables_info').addClass('pull-left');
			$('.dataTables_info').addClass('margin-info');
			$('.paging_simple_numbers').addClass('padding-datatable');

			$('.dataTables_filter').on('click', '.refresh', function () {
					$('#coa_datatables').DataTable().ajax.reload();

			});

			$('#coa_datatables').on('click', '.select-coa', function () {
				let tr = $(this).parents('tr');

				let data = coa_table.row(tr).data();

				$.ajax({
						url: '/journala',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'post',
						dataType: 'json',
						data : {
							'account_code' : data.code, 
							'voucher_no' : _voucher_no
						},
						success: function (data) {

							$('#coa_modal').modal('hide');

							grn_table.reload();

							toastr.success('Data tersimpan', 'Sukses', {
								timeOut: 2000
							});

						}
				});

			});

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
										url: '/journala/' + triggerid + '',
										success: function (data) {
												toastr.success('AR has been deleted.', 'Deleted', {
																timeOut: 5000
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
