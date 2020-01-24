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
							title: 'Debit',
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
						}

				]
		});
    }
};

jQuery(document).ready(function () {
    AccountPayable.init();
});
