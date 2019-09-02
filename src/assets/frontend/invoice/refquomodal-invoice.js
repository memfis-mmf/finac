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
            //console.log(code);
            $.ajax({
                url: '/invoice/quotation/datatables/modal/' + code + '/detail',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    customers = JSON.parse(data.customer);
                    attention = JSON.parse(customers.attention);
                    var levels = customers.levels[0];
                    $.each(attention, function (i, attention) {
                        atten_array[i] = attention.name;
                    });
                    $('#attention').empty();
                    $("#name").val(customers.name);
                    $("#level").val(levels.name);
                    $("#refquono").val(data.number);
                    $('select[name="attention"]').append(
                        '<option value=""> Select a Attention</option>'
                    );
                    $.each(window.atten_array, function (key, value) {
                        $('select[name="attention"]').append(
                            '<option value="' + key + '">' + value + '</option>'
                        );
                    });
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
        $('#phone').empty();
        $('#fax').empty();
        $('#email').empty();
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