let MasterCoa = {
    init: function () {

        let _url = window.location.origin;

        let coa_datatable = $('.coa_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: _url+'/master-coa/coa-datatables',
          columns: [
            {data: 'code'},
            {data: 'name'},
            {data: 'description'},
            // {data: 'sub_account'},
            // {data: 'created_by'},
            {data: 'status'},
          ]
        });

    }
};

jQuery(document).ready(function () {
    MasterCoa.init();
});
