let Invoice = {
    init: function () {

        let _url = window.location.origin;
        let invoice_datatable_url = _url+'/invoice/datatables';

        $('._select2').select2();

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

        let invoice_datatable = $('.invoice_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: invoice_datatable_url,
          order: [
            [ 0, "desc" ],
            [ 1, "desc" ]
          ],
          columns: [
            {data: 'created_at', searchable: false, visible: false},
            {data: 'transactiondate_formated', name: 'transactiondate', class: 'text-nowrap',
                "render": function ( data, type, row, meta ) {
                    return '<b>' + row.transactiondate_formated + '</b><br>' + row.transaction_number_link;
            }},
            {data: 'transaction_number_link', name: 'transactionnumber', visible: false},
            {data: 'xstatus', searchable: false, orderable: false, class:'text-center',
                "render": function ( data, type, row, meta ) {
                    if (row.xstatus) {
                        return `<p style="width:80px">${row.xstatus}</p>`;
                    }
                    else {
                        return "-"
                    }
            }},
            {data: 'customer.name', visible:false},
            {data: 'quotations.number', defaultContent: '-', class:'text-nowrap',
                render: (data, type, row) => {
                    if (row.quotations.number) {
                        return `<a target="_blank" href="${_url}/quotation/${row.quotations.uuid}/print">${row.quotations.number}</a><br>` + row.customer.name;
                    }
                    else {
                        return "-"
                    }
            }},
            {data: 'currency_formated', name: 'currencies.code', defaultContent: '-', class: 'text-center text-nowrap'},
            {data: 'grandtotalforeign',
                "render": function ( data, type, row, meta ) {
                    if (row.grandtotalforeign) {
                        let value = addCommas(parseFloat(row.grandtotalforeign));
                        let symbol = row.currencies.symbol;

                        return `<p class="text-right text-nowrap">${symbol} ${value}</p>`;
                    }
                    else {
                        return "-"
                    }
            }},
            {data: 'status', name: 'approve', class: 'text-center'},
            {data: 'created_by', class: 'text-center',
                "render": function ( data, type, row, meta ) {
                    if (row.created_by) {
                        return `<p class="text-center" style="width:120px">${row.created_by}</p>`;
                    }
                    else {
                        return "-"
                    }
            }},
            {data: 'approved_by', class: 'text-center',
                "render": function ( data, type, row, meta ) {
                    if (row.approved_by) {
                        return `<p class="text-center" style="width:120px">${row.approved_by}</p>`;
                    }
                    else {
                        return "-"
                    }
            }},
            {data: '', class:'text-nowrap', searchable: false, render: function (data, type, row) {
                let t = row;

                if (t.quotations) {
                  if (t.approve == 1) {
                      html =
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/print?uuid=' + t.uuid + '"><i class="la la-print"></i></a>\t\t\t\t\t\t';
                        // '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +

                      html +=
                        '<a href="'+t.export_url+'" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" title="Print" data-id="' + t.uuid + '">' +
                            '<i class="far fa-file-excel"></i>' +
                        "</a>";

                      return html;

                  } else if (t.status == 'Void') {
                      return (
                          // '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                          '\t\t\t\t\t\t\t'
                      );
                  } else {
                    html =
                      '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/print?uuid=' + t.uuid + '"><i class="la la-print"></i></a>\t\t\t\t\t\t';
                    html +=
                      '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t';

                    html +=
                      '<a href="'+t.export_url+'" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" title="Print" data-id="' +
                          t.uuid + '">' +
                          '<i class="far fa-file-excel"></i>' +
                      "</a>";

                    if (t.can_approve_fa) {
                      html += '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalinvoice" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Approve" data-uuid=' +
                            t.uuid +
                            '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t';
                    }

                    html += '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete-invoice" href="#" data-uuid=' +
                          t.uuid +
                          ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'

                      return (html);

                  }
                } else {
                  return '';
                }

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

        $(document).on('submit', '.form-filter-datatable', function (e) {
          e.preventDefault();

          data = $(this).serialize();

          invoice_datatable.ajax.url(invoice_datatable_url+'?'+data).load();
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
                url: '/invoice/' + triggerid + '/approve',
                data: {
                    _token: $('input[name=_token]').val(),
                },
                success: function (data) {
                    if (!data.status) {
                      toastr.error(data.message, 'Invalid', {
                          timeOut: 5000
                      });
                      $('.modal').modal('hide');
                    } else {
                        $('#modal_approvalinvoice').modal('hide');

                        toastr.success('Data saved.', 'Success', {
                            timeOut: 5000
                        });

                        $('#code-error').html('');

                        invoice_datatable.ajax.reload(null, false);
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
                        url: '/coa/type/' + data.type,
                        success: function (data2) {
                            var obj = JSON.parse(data2);
                            console.log(obj);
                            console.log(obj.id);
                            $('select[name="type"]').append(
                                '<option value="' + obj.id + '" selected>' + obj.name + '</option>'
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

        let remove = $('.invoice_datatable').on('click', '.delete-invoice', function () {
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
                        url: '/invoice/' + triggerid + '',
                        success: function (data) {
                            toastr.success('Invoice has been closed.', 'Deleted', {
                                timeOut: 5000
                            });

                            invoice_datatable.ajax.reload(null, false);
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
    Invoice.init();
});
