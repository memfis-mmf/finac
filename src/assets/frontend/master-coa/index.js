let MasterCoa = {
  init: function () {

    let _url = window.location.origin;
    let coa_datatable_url = _url+'/master-coa/coa-datatables';

    $('._select2').select2();

    let coa_datatable = $('.coa_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: coa_datatable_url,
      columns: [
        {data: 'code', class: 'text-center'},
        {data: 'name'},
        {data: 'description', class: 'text-center'},
        {data: 'type.name', class: 'text-center'},
        // {data: 'sub_account'},
        // {data: 'created_by'},
        {data: 'status'},
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

      coa_datatable.ajax.url(coa_datatable_url+'?'+data).load();
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
