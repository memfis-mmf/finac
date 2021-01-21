let AccountReceivable = {
	init: function () {

    let _url = window.location.origin;

    $('._select2').select2({
      placeholder: '-- Select --'
    });

    $('#project').select2({
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $.ajax({
        url: _url+'/invoice/get-customers/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            $('select[id="customer"]').empty();

            $('select[id="customer"]').append(
                '<option value=""> Select a Customer </option>'
            );

            $.each(data, function (key, value) {
                $('select[id="customer"]').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            });
        }
    });

		let coa_datatables = $("#coa_datatables").DataTable({
				"dom": '<"top"f>rt<"bottom">pl',
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !0,
				lengthMenu: [5, 10, 25, 50],
				pageLength: 5,
				ajax: "/account-receivable/coa/datatables",
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

		let invoice = $('.invoice_datatable').mDatatable({
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
									'<button id="show_modal_journala" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
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

		let simpan = $('body').on('click', '#account_receivable_save', function () {

				let form = $(this).parents('form');
				let _data = form.serialize();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'post',
						url: '/account-receivable',
						data: _data,
						success: function (data) {
								if (data.errors) {
										toastr.error(data.errors, 'Invalid', {
												timeOut: 2000
										});
								} else {

										toastr.success('Data saved.', 'Sukses', {
												timeOut: 2000
										});

										setTimeout(function(){
											location.href = `${_url}/account-receivable/${data.uuid}/edit`;
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

		$('body').on('click', '.select-coa', function() {
			let tr = $(this).parents('tr');
			let data = coa_datatables.row(tr).data();

			$('input[name=accountcode]').val(data.code);
			$('input[name=account_name]').val(data.name);

			$('.modal').modal('hide');
		});
	}
};

jQuery(document).ready(function () {
    AccountReceivable.init();
});
