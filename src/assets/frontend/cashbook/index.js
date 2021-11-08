let Cashbook = {
    init: function () {

        let _url = window.location.origin;
        let cashbook_datatable_url = _url+'/cashbook/datatables';

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

        let cashbook_datatable = $('.cashbook_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          processing: true,
          responsive: true,
          serverSide: true,
          scrollX: true,
          ajax: cashbook_datatable_url,
          order: [[0, 'desc']],
          columns: [
            {data: 'transactiondate_formated', name: 'transactiondate', class: 'text-nowrap'},
            //     "render": function ( data, type, row, meta ) {
            //         return `<p class="text-center" style="width:50px">${row.transactiondate_formated}</p>`;
            // }},
            {data: 'transactionnumber_link', name: 'transactionnumber', class: 'text-nowrap'},
            {data: 'journal_number', defaultContent: '-', name: 'journal.voucher_no', class: 'text-nowrap'},
            {data: 'totaltransaction_formated', name: 'totaltransaction', class: 'text-right text-nowrap'},
            {data: 'personal', defaultContent: '-', class: 'text-nowrap'},
            //     "render": function ( data, type, row, meta ) {
            //         if (row.personal) {
            //             return `<p class="text-left" style="width:50px">${row.personal}</p>`;
            //         }
            //         else {
            //             return "-"
            //     }
            // }},
            {data: 'description', defaultContent: '-', className: "dt-text-left"},
            //     "render": function ( data, type, row, meta ) {
            //         if (row.description) {
            //             return `<p style="width:100px">${row.description}</p>`;
            //         }
            //         else {
            //             return "-"
            //         }
            // }},
            {data: 'status', name: 'approve', defaultContent: '-', class: 'text-center'},
            {data: 'created_by', defaultContent: '-', class: 'text-center'},
            //     "render": function ( data, type, row, meta ) {
            //         if (row.approved_by) {
            //             return `<p class="text-center" style="width:80px">${row.approved_by}</p>`;
            //         }
            //         else {
            //             return "-"
            //         }
            // }},
            {data: 'approved_by', defaultContent: '-', class: 'text-center'},
            {data: '', searchable: false, render: function (data, type, row) {
                t = row;

                let _html =
                  '<a href="'+_url+'/cashbook/print/?uuid='+t.uuid+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" title="Print" data-id="' +
                      t.uuid + '">' +
                      '<i class="la la-print"></i>' +
                  "</a>";

                _html +=
                  '<a href="'+t.export_url+'" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" title="Print" data-id="' +
                      t.uuid + '">' +
                      '<i class="fa fa-file-download"></i>' +
                  "</a>";

                if (!t.approve) {
                    if (t.can_approve_fa) {
                      _html +=
                        '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-uuid="' + t.uuid + '">' +
                          '<i class="la la-check"></i>' +
                        '</a>';
                    }

                    _html +=
                      '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="'+_url+'/cashbook/'+t.uuid+'/edit"><i class="la la-pencil"></i></a>';

                    _html +=
                      '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                      t.uuid +
                      ' title="Delete"><i class="la la-trash"></i> </a>'
                }

                return (_html);
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

          cashbook_datatable.ajax.url(cashbook_datatable_url+'?'+data).load();
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

				let approve = $('body').on('click', 'a.approve', function() {
					let _uuid = $(this).data('uuid');
					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'post',
							url: '/cashbook/approve',
							data: {
									_token: $('input[name=_token]').val(),
									uuid: _uuid
							},
							success: function (data) {
									if (data.errors) {
											toastr.error(data.errors, 'Invalid', {
													timeOut: 3000
											});
									} else {
											toastr.success('Data saved.', 'Success', {
													timeOut: 3000
											});

											cashbook_datatable.ajax.reload(null, false);
									}
							}
					});
				})

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
