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

        let supplier_invoice_datatable = $('.supplier_invoice_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: _url+'/supplier-invoice/datatables',
          order: [[1, 'desc']],
          columns: [
            {data: 'transaction_date'},
            {data: 'show_url', name: 'transaction_number'},
            {data: 'x_type'},
            {data: 'vendor.name'},
            {data: 'status', searchable: false},
            {data: 'currency'},
            {data: 'exchange_rate_fix', name: 'exchange_rate'},
            {data: 'grandtotal_foreign_before_adj'},
            {data: 'grandtotal_foreign_formated'},
            {data: 'grandtotal_before_adj'},
            {data: 'grandtotal_formated'},
            {data: 'account_code'},
            {data: 'created_by', searchable: false},
            {data: 'updated_by', searchable: false, defaultContent: '-'},
            {data: 'approved_by', searchable: false, defaultContent: '-'},
            {data: '', searchable: false, render: function (data, para_type, row) {
                t = row;

                let type = '';

                if (t.x_type == "GRN") {
                    type = 'grn/';
                }

                let _html =
                '<a href="'+_url+'/supplier-invoice/'+type+'print/?uuid='+t.uuid+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" title="Print" data-id="' + t.uuid +'">' +
                    '<i class="la la-print"></i>' +
                '</a>';

                                    // jika belum di approve
                if (!t.approve) {
                    _html +=
                      '<a href="'+_url+'/supplier-invoice/'+type+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                      t.uuid +
                      '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t';

                    _html +=
                      '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                      t.uuid +
                      ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t';

                    if (t.can_approve_fa) {
                      _html +=
                        '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-type="'+t.x_type+'" data-uuid="' + t.uuid + '">' +
                        '<i class="la la-check"></i>' +
                        '</a>';
                    }
                }

                return ( _html );
            }}
          ]
        });

        $(".dataTables_length select").addClass("form-control m-input");
        $(".dataTables_filter").addClass("pull-left");
        $(".paging_simple_numbers").addClass("pull-left");
        $(".dataTables_length").addClass("pull-right");
        $(".dataTables_info").addClass("pull-right");
        $(".dataTables_info").addClass("margin-info");
        $(".paging_simple_numbers").addClass("padding-datatable");

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
            $('#simpan').text('Save');

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

                        toastr.success('Data saved.', 'Sukses', {
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

                        toastr.success('Data saved.', 'Sukses', {
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

        let remove = $('.supplier_invoice_datatable').on('click', '.delete', function () {
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
                        url: '/supplier-invoice/' + triggerid + '',
                        success: function (data) {
                            toastr.success('Data has been deleted.', 'Deleted', {
                                    timeOut: 5000
                                }
                            );

                          supplier_invoice_datatable.ajax.reload(null, false);
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
                    let _type = $(this).data('type');

                    let _type_url = '';

                    if (_type == "GRN") {
                        _type_url = 'grn/';
                    }

                    $.ajax({
                            headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'post',
                            url: `/supplier-invoice/${_type_url}approve`,
                            data: {
                                    _token: $('input[name=_token]').val(),
                                    uuid: _uuid
                            },
                            success: function (data) {
                                    if (data.errors) {
                                            toastr.error(data.errors, 'Invalid', {
                                                    timeOut: 5000
                                            });

                                    } else {
                                            toastr.success('Data Saved', 'Success', {
                                                    timeOut: 5000
                                            });

                                            supplier_invoice_datatable.ajax.reload();
                                    }
                            }
                    });
                })

    }
};

jQuery(document).ready(function () {
    Journal.init();
});
