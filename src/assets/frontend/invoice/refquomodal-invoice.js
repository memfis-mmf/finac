let RefQuoDatatables = {
    init: function () {

        $("#refquotation_datatables").DataTable({
            "dom": '<"top"f>rt<"bottom">pl',
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 5,
            ajax: "/invoice/quotation/datatables/modal",
            columns: [
                {
                    data: 'requested_at'
                },
                {
                    data: "number"
                },
                {
                    data: "customer_no"
                },
                {
                    data: "workorder_no"
                },
                {
                    data: "project_no"
                },
                {
                    data: "Actions"
                }
            ],
            columnDefs: [{
                targets: -1,
                orderable: !1,
                render: function (a, e, t, n) {
                    return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-refquo" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
                }
            },

            ]
        })

        // $('<a class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air btn-primary btn-sm refresh" style="margin-left: 60%; color: white;"><span><i class="la la-refresh"></i><span>Reload</span></span> </button>').appendTo('div.dataTables_filter');
        $('.paging_simple_numbers').addClass('pull-left');
        $('.dataTables_length').addClass('pull-right');
        $('.dataTables_info').addClass('pull-left');
        $('.dataTables_info').addClass('margin-info');
        $('.paging_simple_numbers').addClass('padding-datatable');

        $('.dataTables_filter').on('click', '.refresh', function () {
            $('#coa_datatables').DataTable().ajax.reload();

        });

        $('#refquo_modal').on('click', '.select-refquo', function () {
            var code = $(this).data('uuid');
            $('#coa_modal').modal('hide');
            mApp.blockPage();
            //console.log(code);
            $.ajax({
                url: '/invoice/quotation/datatables/modal/' + code + '/detail',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    mApp.unblockPage();
                    console.log(data);
                    // if (data.spcount != data.invoicecount) {
                    if (!data.duplicate) {
                        n_invoice_count = data.invoicecount;
                        var scheduled_payment_amount1112 = JSON.parse(data.scheduled_payment_amount);
                        console.log(scheduled_payment_amount1112[n_invoice_count].amount);
                        $("#due_payment").val(scheduled_payment_amount1112[n_invoice_count].amount);

                        let dataSchedule = JSON.parse(data.scheduled_payment_amount);
                        let scheduled_payments111 = {
                            init: function () {
                                let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable({
                                    data: dataSchedule,
                                    columns: [
                                        {
                                            title: "Work Progress(%)",
                                            data: "work_progress",
                                            "render": function (data, type, row, meta) {
                                                return data + "%";
                                            }
                                        },
                                        {
                                            title: "Amount",
                                            data: "amount",
                                            "render": function (data, type, row, meta) {
                                                return data;
                                            }
                                        },
                                        {
                                            title: "Amount(%)",
                                            data: "amount_percentage",
                                            "render": function (data, type, row, meta) {
                                                return data + "%";
                                            }
                                        },
                                        {
                                            title: "Description",
                                            data: "description"
                                        }
                                    ],
                                    searching: false,
                                    paging: false,
                                    info: false,
                                    footer: true,
                                    "footerCallback": function (row, data, start, end, display) {

                                        var api = this.api();
                                        api.columns('0', {
                                            page: 'current'
                                        }).every(function () {
                                            var sum = this.data();
                                            let arr_work_progress = sum.join();
                                            let max = arr_work_progress.split(",");
                                            Array.prototype.max = function () {
                                                return Math.max.apply(null, this);
                                            };
                                            $(api.column(0).footer()).html("Work Progress : " + max.max() + "%");
                                        });
                                        api.columns('1', {
                                            page: 'current'
                                        }).every(function () {
                                            var sum = this
                                                .data()
                                                .reduce(function (a, b) {
                                                    var x = parseFloat(a) || 0;
                                                    var y = parseFloat(b) || 0;
                                                    return x + y;
                                                }, 0);
                                            $(api.column(1).footer()).html("Total Amount : " + sum);
                                        });

                                        api.columns('2', {
                                            page: 'current'
                                        }).every(function () {
                                            var sum = this
                                                .data()
                                                .reduce(function (a, b) {
                                                    var x = parseFloat(a) || 0;
                                                    var y = parseFloat(b) || 0;
                                                    return x + y;
                                                }, 0);
                                            $(api.column(2).footer()).html("Total Amount : " + sum + "%");
                                        });

                                    }

                                });

                                $('.add_scheduled_row').on('click', function () {
                                    $("#work_progress_scheduled-error").html('');
                                    $("#amount_scheduled-error").html('');
                                    $("#work_progress_scheduled").removeClass('is-invalid');
                                    $("#amount_scheduled").removeClass('is-invalid');
                                    let total = $('#grand_total').attr('value');
                                    let work_progress_scheduled = $("#work_progress_scheduled").val();
                                    let amount_scheduled = $("#amount_scheduled").val();
                                    let description_scheduled = $("#description_scheduled").val();
                                    let amount_scheduled_percentage = (amount_scheduled / total) * 100;
                                    let sub_total = calculate_amount();
                                    let max = calculate_progress();
                                    let remaining = total - sub_total;
                                    if (work_progress_scheduled < max) {
                                        $("#work_progress_scheduled-error").html('Work progess precentage cannot lower than ' + max + '%');
                                        $("#work_progress_scheduled").addClass('is-invalid');
                                    } else if (work_progress_scheduled > 100) {
                                        $("#work_progress_scheduled-error").html('Work progess precentage cannot exceed 100%');
                                        $("#work_progress_scheduled").addClass('is-invalid');
                                        return;
                                    } else if (parseInt(amount_scheduled) > parseInt(total)) {
                                        $("#amount_scheduled-error").html('Amount inserted cannot exceed remaining ' + remaining + ' of total');
                                        $("#amount_scheduled").addClass('is-invalid');
                                        return;
                                    } else {
                                        let newRow = [];
                                        newRow["description"] = description_scheduled;
                                        newRow["work_progress"] = work_progress_scheduled;
                                        newRow["amount"] = amount_scheduled;
                                        newRow["amount_percentage"] = amount_scheduled_percentage;
                                        scheduled_payment_datatable
                                            .row.add(newRow)
                                            .draw();

                                        $("#work_progress_scheduled").val(0);
                                        $("#amount_scheduled").val(0);
                                        $("#description_scheduled").val("");
                                    }
                                });

                                $('#scheduled_payments_datatables tbody').on('click', 'tr', function () {
                                    if ($(this).hasClass('selected')) {
                                        $(this).removeClass('selected');
                                    }
                                    else {
                                        scheduled_payment_datatable.$('tr.selected').removeClass('selected');
                                        $(this).addClass('selected');
                                    }
                                });

                                $('.delete_row').on('click', function () {
                                    scheduled_payment_datatable.row('.selected').remove().draw(false);
                                });

                                // calculate amount
                                function calculate_amount() {
                                    let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                                    let total = scheduled_payment_datatable.column(1).data().reduce(function (a, b) {
                                        var x = parseFloat(a) || 0;
                                        var y = parseFloat(b) || 0;
                                        return x + y;
                                    }, 0);

                                    return total;
                                }

                                // calculate progress
                                function calculate_progress() {
                                    let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                                    let arrays = scheduled_payment_datatable.column(0).data();
                                    let max = Math.max(arrays.join());
                                    return max;
                                }
                            }
                        };

                        scheduled_payments111.init();
                        customers = JSON.parse(data.customer);
                        attention = JSON.parse(customers.attention);
                        attentionquo = JSON.parse(data.attention_quo);
                        console.log(attentionquo);
                        currency = data.currency;
                        var levels = customers.levels[0];
												atten_array = [];

												console.table({
													'currency': currency
												});

												if (currency.code == 'idr') {
													$('#currency').attr('disabled', 'disabled');
													$('#exchange_rate1111').attr('disabled', 'disabled')
												}

                        $.each(attention, function (i, attention) {
                            atten_array[i] = attention.name;
                        });
                        $('#attention').empty();
                        $("#name").val(customers.name);
                        console.log(customers.addresses[0].address);
                        $("#address").val(customers.addresses[0].address);
                        $("#level").val(levels.name);
                        $("#refquono").val(data.number);
                        $("#currency").val(currency.code);

                        $("h3#subjectquo").html("Subject : " + data.title);
                        currencyCode = currency.code;
                        if (currency.code != "idr") {
                            $("#exchange_rate1111").attr("readonly", false);
                        }

                        $("#exchange_rate1111").val(data.exchange_rate);
                        $('select[name="attention"]').append(
                            '<option value="' + attentionquo.name + '"> ' + attentionquo.name + '</option>'
                        );
                        $('select[name="phone"]').append(
                            '<option value="' + attentionquo.phone + '">' + attentionquo.phone + '</option>'
                        );
                        $('select[name="fax"]').append(
                            '<option value="' + attentionquo.fax + '">' + attentionquo.fax + '</option>'
                        );
                        $('select[name="email"]').append(
                            '<option value="' + attentionquo.email + '">' + attentionquo.email + '</option>'
                        );
                        $.each(window.atten_array, function (key, value) {
                            $('select[name="attention"]').append(
                                '<option value="' + key + '">' + value + '</option>'
                            );
                        });
                        $("#refquono").data("uuid", code);
                        //console.log(code);
                        $('#refquo_modal').modal('hide');
                    } else {
                        //console.log("gak bisa");
                        toastr.error('Schedule Payment Sudah Penuh', 'Error!', {
                            timeOut: 5000
                        }
                    );

                    }

                }

            });
        });


    }
};

jQuery(document).ready(function () {
    RefQuoDatatables.init();
    $('#attention').on('change', function () {
        console.log(attention);
        console.log(customers);
        console.log(atten_array);
        var this_attention = attention[this.value];
        var attn_phone = this_attention['phones'];
        var attn_fax = this_attention['fax'];
        var attn_email = this_attention['emails'];
        //$('#phone').empty();
        //$('#fax').empty();
        //$('#email').empty();
        $.each(attn_phone, function (key, value) {
            $('select[name="phone"]').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
        $.each(attn_fax, function (key, value) {
            $('select[name="fax"]').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
        $.each(attn_email, function (key, value) {
            $('select[name="email"]').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
        $('#refquo_modal').modal('hide');

    });

});
jQuery(document).on("click", ".open-AddRowDialog", function () {
    var myBookId = $(this).data('id');
    console.log(myBookId);
    document.getElementById('hiderow').value = myBookId;



    // As pointed out in comments,
    // it is unnecessary to have to manually call the modal.
    // $('#addBookDialog').modal('show');
});