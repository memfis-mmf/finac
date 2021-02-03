let Coa = {
  init: function () {

    if (page_type == 'show') {
      $('input').attr('disabled', 'disabled');
      $('select').attr('disabled', 'disabled');
      $('textarea').attr('disabled', 'disabled');
      $('button').attr('disabled', 'disabled');
    }

		let _url = window.location.origin;
		let cashbook_uuid = $('input[name=cashbook_uuid]').val();
    let number_format = new Intl.NumberFormat('de-DE');

    $('select.project').select2({
      placeholder: '-- Select --',
      width: '100%',
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $('.modal').on('hidden.bs.modal', function (e) {
      modal = $('.modal');
      modal.find('input').not('[type=hidden]').val('');
      modal.find('select').empty();
      modal.find('textarea').val('');
    })

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

		let tota_debit = 0;
		let tota_credit = 0;

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
                field: 'project.code',
                title: 'Project',
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
									if (e == 0) {
										total_debit = 0;
									}
									total_debit = parseFloat(total_debit) + parseFloat(t.debit);
                  result = t.cashbook.currencies.symbol + ' ' + number_format.format(parseFloat(t.debit));

                  if (t.second_debit != 0) {
                    result += ` (${t.cashbook.second_currencies.symbol} ${number_format.format(parseFloat(t.second_debit))})`;
                  }

                  return result;
								}
            },
            {
                field: 'credit',
                title: 'Credit',
                sortable: 'asc',
                filterable: !1,
                width: 150,
								template: function(t, e, i) {
									if (e == 0) {
										total_credit = 0;
									}
									total_credit = parseFloat(total_credit) + parseFloat(t.credit);
                  result = t.cashbook.currencies.symbol + ' ' + number_format.format(parseFloat(t.credit));

                  if (t.second_credit != 0) {
                    result += ` (${t.cashbook.second_currencies.symbol} ${number_format.format(parseFloat(t.second_credit))})`;
                  }

                  return result;
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

                  if (cashbook_type == 'P') {
                    total = total_debit
                  }

                  if (cashbook_type == 'R') {
                    total = total_credit
                  }

									$('#total_debit').val(
										number_format.format(total)
									)

									$('#total_credit').val(
										number_format.format(total)
                  )

									$('#button_cushbook_adjustment').show();

									let _html =
										`<button 
										id="show_coa_edit" 
										data-target="#modal_coa_edit" 
										type="button" 
										href="#" 
										class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" 
										title="Edit" 
										data-transactionnumber="${t.transactionnumber}"
										data-description="${t.description}" 
										data-uuid="${t.uuid}"` +
                    '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                    '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                    t.uuid +
                    ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'

                  if (page_type == 'show') {
                    _html = '';
                  }

                  return _html;
                }
            }
        ]
		});
		
		function display_modal_adj(_modal, data) {
			_modal.find('[name=uuid]').val(data.uuid);
			_modal.find('[name=account_code_b]').val(data.code);
			_modal.find('[name=account_name_b]').val(data.name);
			_modal.find('[name=debit_b]').val(parseFloat(data.debit));
			_modal.find('[name=credit_b]').val(parseFloat(data.credit));
			_modal.find('[name=description_b]').val(data._description);

			_modal.modal('show');
		}

		function display_modal_transaction(_modal, data) {
			_modal.find('[name=uuid]').val(data.uuid);
			_modal.find('[name=account_code_a]').val(data.code);
			_modal.find('[name=account_name_a]').val(data.name);
			_modal.find('[name=amount_a]').val(
				(data.debit > 0)? parseFloat(data.debit): parseFloat(data.credit)
			);
      _modal.find('[name=description_a]').val(data._description);
      if (data.project) {
        _modal.find('[name=id_project]').append(new Option(data.project.code, data.id_project, false, true));
      }

      _modal.find('[name=id_project]').select2({
        placeholder: '-- Select --',
        width: '100%',
        ajax: {
          url: _url+'/journal/get-project-select2',
          dataType: 'json'
        },
      });

			_modal.modal('show');
		}

		let display_coa_edit = $('body').on('click', '#show_coa_edit', function() {

			let tr = $(this).parents('tr');
			let tr_index = tr.index();
			let data = coa_datatable.row(tr).data().mDatatable.dataSet[tr_index];
			data._description = $(this).data('description');
			let transactionnumber = $(this).data('transactionnumber');

			if (transactionnumber.includes('PJ') && data.credit > 0) {
				let _modal = $('#modal_cashbook_adjustment_edit');
				console.log('adj');
				display_modal_adj(_modal, data);
			}else{
				if (transactionnumber.includes('RJ') && data.debit > 0) {
					let _modal = $('#modal_cashbook_adjustment_edit');
					display_modal_adj(_modal, data);
				}else{
					let _modal = $('#modal_coa_edit');
					display_modal_transaction(_modal, data);
				}
			}


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

		let save_cashbook_adjustment = $('body').on('click', '#create_cashbook_adjustment', function () {

			let modal = $(this).parents('.modal');
			let form = modal.find('form');
			let _data = form.serialize();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: _url+'/cashbooka/adjustment',
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

		let update_cashbook_adjustment = $('body').on('click', '#update_cashbook_adjustment', function () {

			let modal = $(this).parents('.modal');
			let form = modal.find('form');
			let _data = form.serialize();

			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: _url+'/cashbooka/adjustment-update',
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

		let remove = $('.coa_datatable').on('click', '.delete', function () {
			let triggerid = $(this).data('uuid');

			$('#button_cushbook_adjustment').hide();

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
		});

		$('#_accountcode_adj').select2({
		  ajax: {
		    url: _url+'/journal/get-account-code-select2',
		    dataType: 'json'
		  },
		});

		$('body').on('click', '#button_cushbook_transaction', function() {
			console.log('wew');
			$('#select2-_accountcode-container').empty();
			$('#select2-_accountcode-container').css('height', '43');
			$('[name=amount_a').val('');
			$('[name=description_a').val('');
		});

  }
};

jQuery(document).ready(function () {
    Coa.init();
});
