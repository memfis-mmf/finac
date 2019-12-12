let AccountPayable = {
  init: function () {

		let _url = window.location.origin;
		let ap_uuid = $('input[name=ap_uuid]').val();

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

		let supplier_invoice_table = $('.supplier_invoice_datatable').mDatatable({
				data: {
						type: 'remote',
						source: {
								read: {
										method: 'GET',
										url: _url+'/apaymenta/datatables/?ap_uuid='+ap_uuid,
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
							field: '_transaction_number',
							title: 'Transaction No.',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'ap.transactiondate',
							title: 'Date',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'currency',
							title: 'Currency',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'exchangerate',
							title: 'Exchange Rate',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.exchangerate));
							}
						},
						{
							field: 'si.total',
							title: 'Total Amount',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.si.total));
							}
						},
						{
							field: '',
							title: 'Paid Amount',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'code',
							title: 'Account Code',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'debit',
							title: 'Amount to Pay',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.debit));
							}
						},
						{
							field: '',
							title: 'Exchange Rate Gap',
							sortable: 'asc',
							filterable: !1,
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
										url: _url+'/apaymentb/datatables/?ap_uuid='+ap_uuid,
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
							field: 'name',
							title: 'Account Name',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'debit',
							title: 'Debet',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.debit));
							}
						},
						{
							field: 'credit',
							title: 'Credit',
							sortable: 'asc',
							filterable: !1,
							template: function(t, e, i) {
								return addCommas(parseInt(t.credit));
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
									'<button data-target="#modal_edit_adjustment" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
									'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
									t.uuid +
									' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
									);
							}
						}

				]
		});

		let supplier_invoice_modal_table = $('.supplier_invoice_modal_datatable').mDatatable({
				data: {
						type: 'remote',
						source: {
								read: {
										method: 'GET',
										url: _url+'/account-payable/si/modal/datatable/?ap_uuid='+ap_uuid,
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
							field: 'transaction_number',
							title: 'Transaction No.',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'transaction_date',
							title: 'Date',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Due Date',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'exchange_rate',
							title: 'Exchange Rate',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'grandtotal',
							title: 'Total Amount',
							sortable: 'asc',
							filterable: !1,
							template: function (t, e, i) {
								return addCommas(parseInt(t.grandtotal));
							}
						},
						{
							field: '',
							title: 'Paid Amount',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: 'accont_code',
							title: 'Account Code',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Amount to Pay',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Exchange Rate Gap',
							sortable: 'asc',
							filterable: !1,
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
									'<a class="btn btn-primary btn-sm m-btn--hover-brand select-supplier-invoice" title="View" data-type="' + t.x_type + '" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
								);
							}
						}

				]
		});

		$('body').on('click', '.select-supplier-invoice', function () {

			let data_uuid = $(this).data('uuid');
			let type = $(this).data('type');

			let tr = $(this).parents('tr');
			let tr_index = tr.index();

			let data = supplier_invoice_modal_table.row(tr).data().mDatatable.dataSet[tr_index];

			$.ajax({
					url: _url+'/apaymenta',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					dataType: 'json',
					data : {
						'account_code' : data.code,
						'ap_uuid' : ap_uuid,
						'data_uuid' : data_uuid,
						'type' : type,
					},
					success: function (data) {

						if (data.errors) {
							toastr.error(data.errors, 'Invalid',  {
								timeOut: 2000
							});
						} else {
							$('#modal_create_supplier_invoice').modal('hide');

							supplier_invoice_table.reload();

							toastr.success('Data tersimpan', 'Sukses', {
								timeOut: 2000
							});
						}

					}
			});

		});

		$('body').on('click', '.select-coa', function () {

			coa_uuid = $(this).data('uuid');

			$.ajax({
					url: _url+'/apaymentb',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					dataType: 'json',
					data : {
						'coa_uuid' : coa_uuid,
						'ap_uuid' : ap_uuid
					},
					success: function (data) {

						$('#coa_modal').modal('hide');

						adjustment_datatable.reload();

						toastr.success('Data tersimpan', 'Sukses', {
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

				let form = $(this).parents('form');
				let _data = form.serialize();
				let si_uuid = form.find('input[name=si_uuid]').val();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'put',
						url: _url+'/apaymenta/'+si_uuid,
						data: _data,
						success: function (data) {
								if (data.errors) {
									toastr.error(data.errors, 'Invalid', {
										timeOut: 2000
									});
								} else {
									toastr.success('Data berhasil disimpan.', 'Sukses', {
										timeOut: 2000
									});

									$('#modal_edit_supplier_invoice').modal('hide');
									supplier_invoice_table.reload();
								}
						}
				});
		});

		$('.supplier_invoice_datatable').on('click', '.edit-item', function() {
			let target = $(this).data('target');
			let uuid = $(this).data('uuid');

			let tr = $(this).parents('tr');
			let tr_index = tr.index();
			let data = supplier_invoice_table.row(tr).data().mDatatable.dataSet[tr_index];

			$(target).find('input[name=si_uuid]').val(uuid);
			$(target).find('[name=description]').val(data.description);
			$(target).find('input[name=debit]').val(data.debit);

			$(target).modal('show');
		})

		$('.adjustment_datatable').on('click', '.edit-item', function() {
			let target = $(this).data('target');
			let uuid = $(this).data('uuid');

			let tr = $(this).parents('tr');
			let tr_index = tr.index();
			let data = adjustment_datatable.row(tr).data().mDatatable.dataSet[tr_index];

			$(target).find('input[name=_uuid]').val(uuid);
			$(target).find('[name=debit_b]').val(data.debit);
			$(target).find('[name=credit]').val(data.credit);
			$(target).find('[name=description]').val(data.description);

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
						url: _url+'/apaymentb/'+_uuid,
						data: _data,
						success: function (data) {
								if (data.errors) {
									toastr.error(data.errors, 'Invalid', {
										timeOut: 2000
									});
								} else {
									toastr.success('Data berhasil disimpan.', 'Sukses', {
										timeOut: 2000
									});

									$('#modal_edit_adjustment').modal('hide');
									adjustment_datatable.reload();
								}
						}
				});
		});

  }
};

jQuery(document).ready(function () {
    AccountPayable.init();
});
