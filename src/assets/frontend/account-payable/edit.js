let AccountPayable = {
    init: function () {
		let suuplier_invoice = $('.supplier_invoice_datatable').mDatatable({
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
									'<button id="show_modal_journala" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
									'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
									t.uuid +
									' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
									);
							}
						}

				]
		});

		$("#supplier_invoice_modal_datatable").DataTable({
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
					data: "aircraft.name"
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
						return '<a class="btn btn-primary btn-sm m-btn--hover-brand select-supplier-invoice" title="View" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
					}
				},

			]
		})

		$('#supplier_invoice_modal_datatable').on('click', '.supplier-invoice', function () {
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

    }
};

jQuery(document).ready(function () {
    AccountPayable.init();
});
