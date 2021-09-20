let Cashbook = {
    init: function () {
        $('.cashbook_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/cashbook/datatables',
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
                    title: 'TransactionNo',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'xstatus',
                    title: 'Type',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
                },
                {
                    field: 'refno',
                    title: 'Ref No',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'totaltransaction',
                    title: 'Total Transaction',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'personal',
                    title: 'Payment/Received By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'updateddate',
                    title: 'UpdatedDate',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'updatedby',
                    title: 'UpdatedBy',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'accountcode',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'approvedby',
                    title: 'Approved By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'created_at',
                    title: 'CreatedDate',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'createdby',
                    title: 'CreatedBy',
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
                        var transno = t.transactionnumber;
                        var res = transno.substring(0, 4);
                        console.log(res);
                        if(t.status == 'Approved'){
                            if (res == "CBPJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-bpj/'+t.uuid+'/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t'
                                );
                            }else if(res == "CBRJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-brj/'+t.uuid+'/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t'
                                );
                            }else if (res == "CCRJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-crj/'+t.uuid+'/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t'
                                );
                            }else if(res == "CCPJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-cpj/'+t.uuid+'/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t'
                                );
                            }
                        }
                        else{
                            if (res == "CBPJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-bpj/'+t.uuid+'/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalcashbook" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                                    t.uuid +
                                    '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                                    t.uuid +
                                    ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                                );
                            }else if(res == "CBRJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-brj/'+t.uuid+'/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalcashbook" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                                    t.uuid +
                                    '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                                    t.uuid +
                                    ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                                );
                            }else if (res == "CCRJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-crj/'+t.uuid+'/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalcashbook" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                                    t.uuid +
                                    '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                                    t.uuid +
                                    ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                                );
                            }else if(res == "CCPJ"){
                                return (
                                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="cashbook-cpj/'+t.uuid+'/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalcashbook" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                                    t.uuid +
                                    '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                                    '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                                    t.uuid +
                                    ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                                );
                            }
                        }
                        
                        
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

        let approve = $('.modal-footer').on('click', '.add', function () {
            let triggerid = $("#uuid-approve").val();
            

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/cashbook/' + triggerid + '/approve',
                data: {
                    _token: $('input[name=_token]').val(),
                },
                success: function (data) {
                    if (data.errors) {
                        if (data.errors.code) {
                            $('#code-error').html(data.errors.code[0]);


                          
                        }


                    } else {
                        $('#modal_approvalcashbook').modal('hide');

                        toastr.success('Data saved.', 'Success', {
                            timeOut: 5000
                        });

                        $('#code-error').html('');

                        let table = $('.cashbook_datatable').mDatatable();

                        table.originalDataSet = [];
                        table.reload();
                    }
                }
            });
        });

        let edit = $('.coa_datatable').on('click', '.edit', function () {
            // $('#button').show();
            // $('#simpan').text('Perbarui');

            let triggerid = $(this).data('uuid');
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
                        url: '/coa/type/'+data.type,
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

                        toastr.success('Data saved.', 'Success', {
                            timeOut: 5000
                        });

                        let table = $('.coa_datatable').mDatatable();

                        table.originalDataSet = [];
                        table.reload();

                        $('#code-error').html('');
                        $('#name-error').html('');
                        $('#type-error').html('');
                        $('#level-error').html('');
                        $('#description-error').html('');

                    }
                }
            });
        });

        let remove = $('.cashbook_datatable').on('click', '.delete', function () {
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
                        url: '/cashbook/' + triggerid + '',
                        success: function (data) {
                            toastr.success('Cashbook has been deleted.', 'Deleted', {
                                    timeOut: 5000
                                }
                            );

                            let table = $('.cashbook_datatable').mDatatable();

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
    Cashbook.init();
});
