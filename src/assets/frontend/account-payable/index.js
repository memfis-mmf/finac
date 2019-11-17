let Journal = {
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
        $('.account_payable_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: _url+'/account-payable/datatables',
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
                    field: 'transactiondate',
                    title: 'Date',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: 'transactionnumber',
                    title: 'AP NO.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'vendor.name',
                    title: 'Supplier Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: 'refno',
                    title: 'Ref No.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'currency',
                    title: 'Currency',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'exchangerate',
                    title: 'Exchange Rate',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
										template: function(t, e, i) {
											return addCommas(parseInt(t.exchangerate));
										}
                },
                {
                    field: '',
                    title: 'Total Transaction',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Status',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Created By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Approve By',
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
                          '<a href="journal/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                          t.uuid +
                          '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
                          '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                          t.uuid +
                          ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t' +
                          '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-id="' + t.uuid + '">' +
                          '<i class="la la-check"></i>' +
                          '</a>'
                          );
                    }
                }
            ]
        });

        $('.modal-footer').on('click', '.reset', function () {
            coa_reset();
        });


        let save_changes_button = function () {
            $('.btn-success').removeClass('add');
            $('.btn-success').addClass('update');
            $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save Changes</span></span>");
        }

        let save_button = function () {
            $('.btn-success').removeClass('edit');
            $('.btn-success').addClass('add');
            $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save New</span></span>");
        }

        let simpan = $('.modal-footer').on('click', '.add', function () {
            $('#simpan').text('Simpan');

            let type = $('#type').val();
            let level = $('#level').val();
            let registerForm = $('#CustomerForm');
            let code = $('input[name=code]').val();
            let name = $('input[name=name]').val();
            let formData = registerForm.serialize();
            let description = $('#description').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/coa',
                data: {
                    _token: $('input[name=_token]').val(),
                    code: code,
                    name: name,
                    type_id: type,
                    description: description
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
                        $('#modal_coa').modal('hide');

                        toastr.success('Data berhasil disimpan.', 'Sukses', {
                            timeOut: 5000
                        });

                        $('#code-error').html('');

                        let table = $('.coa_datatable').mDatatable();
                        coa_reset();
                        table.originalDataSet = [];
                        table.reload();
                    }
                }
            });
        });

        let edit = $('.coa_datatable').on('click', '.edit', function () {
            // $('#button').show();
            // $('#simpan').text('Perbarui');

            var triggerid = $(this).data('uuid');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: '/coa/' + triggerid + '/edit',
                success: function (data) {
                    let select = document.getElementById('type');


                    // FIXME: 'select' has already been declared.
                    // let select = document.getElementById('level');

                    document.getElementById('uuid').value = data.uuid;
                    document.getElementById('code').value = data.code;
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'get',
                        url: '/coa/type/'+data.type_id,
                        success: function (data2) {
                            var obj = JSON.parse(data2);
                            console.log(obj);
                            console.log(obj.id);
                            $('select[name="type"]').append(
                                '<option value="'+obj.id+'" selected>'+obj.name+'</option>'
                            );
                        }
                    });
                    save_changes_button();

                },
                error: function (jqXhr, json, errorThrown) {
                    let errorsHtml = '';
                    let errors = jqXhr.responseJSON;

                    $.each(errors.errors, function (index, value) {
                        $('#coa-error').html(value);
                    });
                }
            });
        });

        let update = $('.modal-footer').on('click', '.update', function () {
            $('#button').show();
            $('#name-error').html('');
            $('#simpan').text('Perbarui');

            let type = $('#type').val();
            let level = $('#level').val();
            let code = $('input[name=code]').val();
            let name = $('input[name=name]').val();
            let description = $('#description').val();
            let triggerid = $('input[name=uuid]').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'put',
                url: '/coa/' + triggerid,
                data: {
                    _token: $('input[name=_token]').val(),
                    code: code,
                    name: name,
                    type_id: type,
                    level: level,
                    description: description
                },
                success: function (data) {
                    if (data.errors) {
                        if (data.errors.code) {
                            $('#code-error').html(data.errors.code[0]);
                        }

                    } else {
                        save_button();
                        $('#modal_coa').modal('hide');

                        toastr.success('Data berhasil disimpan.', 'Sukses', {
                            timeOut: 5000
                        });

                        let table = $('.coa_datatable').mDatatable();

                        table.originalDataSet = [];
                        table.reload();
                        coa_reset();

                        $('#code-error').html('');
                        $('#name-error').html('');
                        $('#type-error').html('');
                        $('#level-error').html('');
                        $('#description-error').html('');

                    }
                }
            });
        });

        let remove = $('.account_payable_datatable').on('click', '.delete', function () {
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
                        url: '/account-payable/' + triggerid + '',
                        success: function (data) {
                            toastr.success('Data has been deleted.', 'Deleted', {
                                    timeOut: 5000
                                }
                            );

                            let table = $('.account_payable_datatable').mDatatable();

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

    }
};

jQuery(document).ready(function () {
    Journal.init();
});
