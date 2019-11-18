let AccountPayable = {
  init: function () {

		let _url = window.location.origin;
		let ap_uuid = $('input[name=ap_uuid]').val();

		let supplier_invoice_table = $('.supplier_invoice_datatable').mDatatable({
				data: {
						type: 'remote',
						source: {
								read: {
										method: 'GET',
										url: '',
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
							title: 'Transaction No.',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Date',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Currency',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Exchange Rate',
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
							title: 'Paid Amount',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
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
							field: '',
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
									'<button data-target="#modal_edit_supplier_invoice" data-toggle="modal" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
									'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
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
										url: '',
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
							title: 'Account Code',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Account Name',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Debet',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
							title: 'Credit',
							sortable: 'asc',
							filterable: !1,
						},
						{
							field: '',
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
									'<button data-target="#modal_edit_adjustment" data-toggle="modal" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
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
									'<a class="btn btn-primary btn-sm m-btn--hover-brand select-supplier-invoice" title="View" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
								);
							}
						}

				]
		});

		$('body').on('click', '.select-supplier-invoice', function () {

			let si_uuid = $(this).data('uuid');

			let tr = $(this).parents('tr');
			let tr_index = tr.index();

			console.table(supplier_invoice_table.row(tr).data());

			let data = supplier_invoice_table.row(tr).data().mDatatable.dataSet[tr_index];

			$.ajax({
					url: _url+'/account-payable',
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

						account_code_table.reload();

						toastr.success('Data tersimpan', 'Sukses', {
							timeOut: 2000
						});

					}
			});

		});
  }
};

jQuery(document).ready(function () {
    AccountPayable.init();
});
