let SupplierInvoice = {
	init: function () {

    let _url = window.location.origin;

    $('#project').select2({
      placeholder: '--Select--',
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $.ajax({
        url: _url+'/supplier-invoice/get-vendors/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            $('select[id="vendor"]').empty();

            $('select[id="vendor"]').append(
                '<option value=""> Select a Vendor </option>'
            );

            $.each(data, function (key, value) {
                $('select[id="vendor"]').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            });
        }
    });

		let grn_table = $('.grn_datatable').mDatatable({
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
									'<button id="show_modal_journala" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
									'\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
									t.uuid +
									' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
									);
							}
						}

				]
		});

		let simpan = $('body').on('click', '#supplier_invoice_grnsave', function () {

				let form = $(this).parents('form');
				let _data = form.serialize();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'post',
						url: '/supplier-invoice/grn/create',
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
											location.href = `${_url}/supplier-invoice/grn/${data.uuid}/edit`;
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
  }
};

jQuery(document).ready(function () {
    SupplierInvoice.init();
});
