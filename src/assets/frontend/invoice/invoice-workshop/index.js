let InvoiceWorkshop = {
    init: function () {
				let _url = window.location.origin;

        let item_modal_datatable = $("#item_datatables").DataTable({
            "dom": '<"top"f>rt<"bottom">pl',
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 5,
            ajax: "/coa/datatables/modal",
            columns: [
                {
                    data: 'code'
                },
                {
                    data: "name"
                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "Actions",
                    searchable: false,
                    orderable: false
                },
            ],
            columnDefs: [{
                targets: -1,
                orderable: !1,
                render: function (a, e, t, n) {
                    return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-item" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
                }
            },

            ]
        })

        let item_datatable = $('.item_datatable').DataTable({
            'paging':false,
            "ordering":false,
	        "info":false,
	        "searching":false,
        });

        $('#item_datatables').on('click', '.select-item', function () {
            let tr = $(this).parents('tr');
            let data = item_modal_datatable.row( tr ).data();

            item_datatable.row.add([
		        data.code,
		        data.name,
                '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill delete" href="javascript:;" title="Delete"><i class="la la-trash"></i> </a>'
            ]).draw();

            $('.modal').modal('hide');
        });

        $('.item_datatable').on('click', '.delete', function () {
            let tr = $(this).parents('tr');

            console.log('wew')

            item_datatable.row(tr).remove().draw();
        });

        $('body').on('click', '.view', function() {
            let data = item_datatable.rows().data();
            let param = [];
            let date = $('[name=daterange_general_ledger]').val();

            for (var data_index = 0; data_index < data.length; data_index++) {
                param[data_index] = data[data_index][0];
            }

            location.href = _url+'/general-ledger/show/?data='+param+'&date='+date;
        });

        $('body').on('click', '.export', function() {
            let data = item_datatable.rows().data();
            let param = [];
            let date = $('[name=daterange_general_ledger]').val();

            for (var data_index = 0; data_index < data.length; data_index++) {
                param[data_index] = data[data_index][0];
            }

            location.href = _url+'/general-ledger/export/?data='+param+'&date='+date;
        });

        $('body').on('click', '.print', function() {
            let data = item_datatable.rows().data();
            let param = [];
            let date = $('[name=daterange_general_ledger]').val();

            for (var data_index = 0; data_index < data.length; data_index++) {
                param[data_index] = data[data_index][0];
            }

            location.href = _url+'/general-ledger/print/?data='+param+'&date='+date;
        });
    }
};

jQuery(document).ready(function () {
    InvoiceWorkshop.init();
});
