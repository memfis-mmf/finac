let FixedAssetDisposition = {
    init: function () {

        let _url = window.location.origin;

        let fixed_asset_disposition_datatable = $('.fixed_asset_disposition_datatable').DataTable({
          dom: '<"top"f>rt<"bottom">pil',
          scrollX: true,
          processing: true,
          serverSide: true,
          ajax: _url+'/invoice/datatables',
          order: [[ 0, "desc" ]],
          columns: [
            {data: 'created_at'},
          ]
        });
    }
};

jQuery(document).ready(function () {
    FixedAssetDisposition.init();
});
