let Coa = {
  init: function () {

		let _url = window.location.origin;
		let cashbook_uuid = $('input[name=cashbook_uuid]').val();

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

    let coa_datatable = $('.coa_datatable').mDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    method: 'GET',
                    url: _url+'/cashbooka/datatables/?cashbook_uuid='+cashbook_uuid,
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
            serverPaging: !1,
            serverFiltering: !0,
            serverSorting: !1
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
                width: 100
            },
            {
                field: 'name',
                title: 'Account Name',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: 'debit',
                title: 'Debit',
                sortable: 'asc',
                filterable: !1,
                width: 150,
								template: function(t, e, i) {
									return addCommas(parseInt(t.debit));
								}
            },
            {
                field: 'credit',
                title: 'Credit',
                sortable: 'asc',
                filterable: !1,
                width: 150,
								template: function(t, e, i) {
									return addCommas(parseInt(t.credit));
								}
            },
            {
                field: 'description',
                title: 'Description',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: 'Actions',
                width: 110,
                title: 'Actions',
                sortable: !1,
                overflow: 'visible',
                template: function (t, e, i) {
                    return (
                        '<button id="show_coa_edit" data-target="#modal_coa_edit" type="button" href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-description="'+t.description+'" data-uuid=' +
                        t.uuid +
                        '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                        t.uuid +
                        ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                    );
                }
            }
        ]
    });

		let display_coa_edit = $('body').on('click', '#show_coa_edit', function() {

			let tr = $(this).parents('tr');
			let tr_index = tr.index();
			let data = coa_datatable.row(tr).data().mDatatable.dataSet[tr_index];
			let _description = $(this).data('description');
			let _modal = $('#modal_coa_edit');

			console.table(data);

			_modal.find('[name=uuid]').val(data.uuid);
			_modal.find('[name=account_code_a]').val(data.code);
			_modal.find('[name=account_name_a]').val(data.name);
			_modal.find('[name=amount_a]').val(
				(data.debit > 0)? parseInt(data.debit): parseInt(data.credit)
			);
			_modal.find('[name=description_a]').val(_description);

			$('#modal_coa_edit').modal('show');
		})

		let update_cashbook_a = $('body').on('click', '#update_cashbook_a', function () {

			console.log('wew');

			let _form = $(this).parents('form');
			let _uuid = _form.find('[name=uuid]').val();
			let _data = _form.serialize();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'put',
					url: _url+'/cashbooka/'+_uuid,
					data: _data,
					success: function (data) {
							if (data.errors) {
								toastr.error(data.errors, 'Invalid', {
										timeOut: 2000
								});

							} else {
									$('.modal').modal('hide');

									toastr.success('Data Saved', 'Success', {
											timeOut: 2000
									});

									coa_datatable.reload()
							}
					}
			});
		});

		let save_cashbook_a = $('body').on('click', '#create_cashbooka', function () {

			let modal = $(this).parents('.modal');
			let form = modal.find('form');
			let _data = form.serialize();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: _url+'/cashbooka',
					data: _data,
					success: function (data) {
							if (data.errors) {
								toastr.error(data.errors, 'Invalid', {
										timeOut: 2000
								});

							} else {
									$('.modal').modal('hide');

									toastr.success('Data Saved', 'Success', {
											timeOut: 2000
									});

									coa_datatable.reload()
							}
					}
			});
		});

		let update = $('body').on('click', '#cashbook_save', function () {

			let form = $(this).parents('form');
			let _data = form.serialize();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'put',
					url: _url+'/cashbook/'+cashbook_uuid,
					data: _data,
					success: function (data) {
							if (data.errors) {
								toastr.error(data.errors, 'Invalid', {
										timeOut: 2000
								});

							} else {
									$('.modal').modal('hide');

									toastr.success('Data Saved', 'Success', {
											timeOut: 2000
									});

									setTimeout(function(){
										location.href = `${_url}/cashbook`;
									}, 2000);
							}
					}
			});
		});

		let remove = $('.coa_datatable').on('click', '.delete', function () {
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
									url: '/cashbooka/' + triggerid + '',
									success: function (data) {
											toastr.success('data has been deleted.', 'Deleted', {
															timeOut: 2000
													}
											);

											coa_datatable.reload();
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

		$('#_accountcode').select2({
		  ajax: {
		    url: _url+'/journal/get-account-code-select2',
		    dataType: 'json'
		  },
			minimumInputLength: 3,
			// templateSelection: formatSelected
		});

  }
};

jQuery(document).ready(function () {
    Coa.init();
});
