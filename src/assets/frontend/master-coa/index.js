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

    $('body').on('click', '#coa_switch', function() {
      let uuid = $(this).data('uuid');

      mApp.blockPage()

      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content'
            )
        },
        type: "POST",
        url: _url+"/master-coa-switch-coa/"+uuid,
        dataType: "json",
        success: function (response) {
          toastr.success('Status Changed', 'Success', {
            timeOut: 3000
          });
        }
      })
      .fail(function () {
        mApp.unblockPage()
      })
      .done(function () {
        mApp.unblockPage()
      });

    });

  }
};

jQuery(document).ready(function () {
    MasterCoa.init();
});
