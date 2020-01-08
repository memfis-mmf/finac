let Bond = {
    init: function () {

				let _url = window.location.origin;

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

        let bond_datatable = $('.bond_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: `${_url}/bond/datatables`,
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
                    field: 'transaction_date',
                    title: 'Date',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: 'transaction_number',
                    title: 'Transaction No.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Person',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
										template: function(t, e, i) {
											return t.employee.first_name+' '+t.employee.last_name;
										}
                },
                {
                    field: 'value',
                    title: 'Amount',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
										template: function(t, e, i) {
											return addCommas(parseInt(t.value));
										}
                },
                {
                    field: 'date_return',
                    title: 'Return Date',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'x',
                    title: 'Paid Amount',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
                },
                {
                    field: 'description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'x',
                    title: 'Status',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'x',
                    title: 'Created By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'x',
                    title: 'Approve by',
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
											let _html = '';

											if (!t.approve) {
												_html +=
                          '<a href="'+_url+'/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                          t.uuid +
                          '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
                          '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                          t.uuid +
                          ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t' +
                          '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-uuid="' + t.uuid + '">' +
                          '<i class="la la-check"></i>' +
                          '</a>';
											}

                      return (_html);
                    }
                }
            ]
        });

        let remove = $('.bond_datatable').on('click', '.delete', function () {
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
                        url: '/bond/' + triggerid + '',
                        success: function (data) {
                            toastr.success('AR has been deleted.', 'Deleted', {
                                    timeOut: 5000
                                }
                            );

                            let table = $('.bond_datatable').mDatatable();

                            table.originalDataSet = [];
                            table.reload();
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

				let approve = $('body').on('click', 'a.approve', function() {
					let _uuid = $(this).data('uuid');

					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'post',
							url: `/bond/approve`,
							data: {
									_token: $('input[name=_token]').val(),
									uuid: _uuid
							},
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

											bond_datatable.reload();
									}
							}
					});
				})
    }
};

jQuery(document).ready(function () {
    Bond.init();
});
