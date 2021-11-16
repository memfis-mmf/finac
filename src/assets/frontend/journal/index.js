let Journal = {
    init: function () {
        let _url = window.location.origin;
        let journal_datatable_url = _url+'/journal/datatables';
        $.fn.dataTable.ext.errMode = 'none';

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

        let journal_datatable = $('.journal_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: journal_datatable_url,
          order: [
            [0, 'desc'],
            [1, 'desc']
          ],
          columns: [
            {data: 'created_at', visible: false},
            {data: 'transaction_date_formated', name: 'transaction_date', class: 'text-left text-nowrap',
            "render": function ( data, type, row, meta ) {
                return '<b>' + row.transaction_date_formated + '</b><br>' + row.voucher_no_formated ;
            }},
            {data: 'voucher_no_formated', name: 'voucher_no', visible:false},
            {data: 'ref_no_link', name: 'ref_no', class:'text-nowrap'},
            {data: 'currency_code', class: 'text-center', render: function(data, type, row) {
              return row.currency_code.toUpperCase();
            }},
            {data: 'exchange_rate', class: 'text-right text-nowrap', render: function(data, type, row) {
              val = addCommas(parseInt(row.exchange_rate));

              return val;
            }},
            {data: 'type_jurnal.name',
            "render": function ( data, type, row, meta ) {
                if (row.type_jurnal.name) {
                    return `<p class="text-left" style="width:120px">${row.type_jurnal.name}</p>`;
                }
                else {
                    return "-"
                }
            }},
            {data: 'total_transaction_formated', name: 'total_transaction', class: 'text-right text-nowrap'},
            {data: 'status', name: 'approve', class: 'text-center'},
            {data: 'created_by', name: 'created_at', class: 'text-center',
            "render": function ( data, type, row, meta ) {
                if (row.created_by) {
                    return `<p class="text-center" style="width:120px">${row.created_by}</p>`;
                }
                else {
                    return "-"
                }
            }},
            {data: 'updated_by', name: 'updated_at', class: 'text-center',
            "render": function ( data, type, row, meta ) {
                if (row.updated_by) {
                    return `<p class="text-center" style="width:120px">${row.updated_by}</p>`;
                }
                else {
                    return "-"
                }
            }},
            {data: 'approved_by', name: 'approvals.created_at', class: 'text-center',
            "render": function ( data, type, row, meta ) {
                if (row.approved_by) {
                    return `<p class="text-center" style="width:120px">${row.approved_by}</p>`;
                }
                else {
                    return "-"
                }
            }},
            {data: 'action', class:'text-nowrap', searchable: false},
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

          journal_datatable.ajax.url(journal_datatable_url+'?'+data).load();
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
							url: '/journal/approve',
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
											toastr.success('Approved', 'Success', {
													timeOut: 3000
											});

											journal_datatable.ajax.reload(null, false);
									}
							}
					});
				})

				let unapprove = $('body').on('click', 'a.unapprove', function() {
					let _uuid = $(this).data('uuid');
					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'post',
							url: '/journal/unapprove',
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
											toastr.success('Unapproved', 'Success', {
													timeOut: 3000
											});

											journal_datatable.ajax.reload(null, false);
									}
							}
					});
				})

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

                        toastr.success('Data saved.', 'Success', {
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

                        toastr.success('Data saved.', 'Success', {
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

        let remove = $('.journal_datatable').on('click', '.delete', function () {
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
                        url: '/journal/' + triggerid + '',
                        success: function (data) {
                            toastr.success('Data has been deleted.', 'Deleted', {
                                    timeOut: 5000
                                }
                            );

                            journal_datatable.ajax.reload(null, false);
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

        $("#daterange").daterangepicker({
          buttonClasses: "m-btn btn",
          applyClass: "btn-primary",
          cancelClass: "btn-secondary",
          locale: {
            format: 'DD-MM-YYYY'
          }
        });

        $(document).on('change', '#daterange', function () {
          let date = $(this).val();

          journal_datatable.ajax.url(_url+'/journal/datatables?daterange='+date).load();
        });

    }
};

jQuery(document).ready(function () {
    Journal.init();
});
