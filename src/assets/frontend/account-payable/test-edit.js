let Account_payable = {
	init: function () {
		let _url = window.location.origin;
		let ap_uuid = $('input[name=ap_uuid]').val();
		let id_vendor = $('select[name=id_supplier]').val();
		let number_format = new Intl.NumberFormat('de-DE');

		let account_payable_datatable = $('.supplier_invoice_modal_datatable1').DataTable({
			dom: '<"top"f>rt<"bottom">pil',
			scrollX: true,
			processing: true,
			serverSide: true,
			responsive: !0,
			lengthMenu: [5, 10, 23, 50, 100],
			serverSide: true,
			order: [
				[8, 'desc'],
				[0, 'desc'],
			],
			ajax: _url + '/account-payable/si/modal/datatable/?ap_uuid=' + ap_uuid + ' &id_vendor=' + id_vendor,
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
					data: 'grandtotal_foreign', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + row.currencies.symbol + number_format.format(parseFloat(row.grandtotal_foreign)) + '</p>';
					}
				},
				{
					data: 'grandtotal', render: function (data, type, row) {
						return '<p class="text-left text-nowrap">' + 'Rp' + number_format.format(parseFloat(row.grandtotal)) + '</p>';
					}
				},
				{ data: 'coa.code', name: 'code'},
				{
					data: 'description', render: function (data, type, row) {
						return '<p class="text-left">' + row.description ?? '' + '</p>';
					}
				},
				{
					data: 'actions', render: function (data, type, row) {
						if (page_type == 'show') {
							return '';
						}
	
						return (
							'<a class="btn btn-primary btn-sm m-btn--hover-brand select-supplier-invoice" title="View" data-type="' + row.x_type + '" data-uuid="' + row.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
						);
					}
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

		$('body').on('click', '.select-supplier-invoice', function () {

			let data_uuid = $(this).data('uuid');
			let type = $(this).data('type');
	
			let tr = $(this).parents('tr');
	
			let data = account_payable_datatable.row(tr).data();
	
			// console.log(data_uuid);
			// console.log(type);
			// console.log(data);
			// console.log(data.code);
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
					$('#modal_create_supplier_invoice').modal('hide');
	
					supplier_invoice_table.reload();
					account_payable_datatable.reload();
	
					toastr.success('Data saved', 'Success', {
						timeOut: 2000
					});
				}
	
				}
			});
		});
	}
};

jQuery(document).ready(function () {
	Account_payable.init();
});