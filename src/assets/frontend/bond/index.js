let Bond = {
  init: function () {

    let _url = window.location.origin;

    let number_format = new Intl.NumberFormat('de-DE', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

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

    let bond_datatable = $('.bond_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: `${_url}/bond/datatables`,
      order: [[ 0, "desc" ]],
      columns: [
        {data: 'transaction_date'},
        {data: 'transaction_number'},
        {data: 'employee.full_name', name: 'employee.first_name', defaultContent: '-'},
        {data: 'value', render: (data, type, row) => {
          return number_format.format(row.value);
        }},
        {data: 'date_return'},
        {data: 'paid_amount', defaultContent: '-'},
        {data: 'description'},
        {data: 'status', orderable: false, searchable: false, defaultContent: '-'},
        {data: 'created_by', orderable: false, searchable: false},
        {data: 'approved_by', orderable: false, searchable: false},
        {data: 'action', orderable: false, searchable: false},
      ]
    })

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

    let remove = $('.bond_datatable').on('click', '.delete', function () {
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
            url: '/bond/' + triggerid + '',
            success: function (data) {
              toastr.success('Data has been deleted.', 'Deleted', {
                timeOut: 5000
              }
              );

              bond_datatable.ajax.reload(null, false);
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

    let approve = $('body').on('click', 'a.approve', function() {
      let _uuid = $(this).data('uuid');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: `/bond/approve`,
        data: {
          _token: $('input[name=_token]').val(),
          uuid: _uuid
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
            toastr.success('Data saved.', 'Success', {
              timeOut: 5000
            });

            bond_datatable.ajax.reload(null, false);
          }
        }
      });
    })
  }
};

jQuery(document).ready(function () {
  Bond.init();
});
