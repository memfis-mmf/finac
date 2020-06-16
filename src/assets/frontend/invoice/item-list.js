let ItemList = {
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

        let item_list_datatable = $('.item_list_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: _url+'/invoice/datatables',
          columns: [
            {data: 'date'},
            {data: 'transactionnumber'},
            {data: 'transactionnumber'},
            {data: 'transactionnumber'},
            {data: 'xstatus'},
            {data: 'customer.name'},
            {data: 'quotations.number', defaultContent: '-'},
            {data: 'currencies.code'},
            {data: 'total_transaction', render: function(data, type, row) {
                let value = addCommas(parseInt(row.grandtotalforeign));
                let symbol = row.currencies.symbol;
                return `${symbol} ${value}`;
            }},
            {data: 'status'},
            {data: 'approved_by', defaultContent: '-'},
            {data: '', searchable: false, render: function (data, type, row) {
                let t = row;
                if (t.status == 'Approved') {
                    return (
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/print?uuid=' + t.uuid + '"><i class="fa fa-print"></i></a>\t\t\t\t\t\t'+
                        // '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t'
                    );

                } else if (t.status == 'Void') {
                    return (
                        // '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/"><i class="la la-eye"></i></a>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t'
                    );
                } else {
                    return (
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/print?uuid=' + t.uuid + '"><i class="fa fa-print"></i></a>\t\t\t\t\t\t'+
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="/invoice/' + t.uuid + '/edit"><i class="la la-pencil"></i></a>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t<button data-toggle="modal" data-target="#modal_approvalinvoice" type="button" href="#" class="open-AddUuidApproveDialog m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                        t.uuid +
                        '>\t\t\t\t\t\t\t<i class="la la-check"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete-invoice" href="#" data-uuid=' +
                        t.uuid +
                        ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                    );

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
    }
};

jQuery(document).ready(function () {
    ItemList.init();
});
