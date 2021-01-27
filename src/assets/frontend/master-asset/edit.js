let MasterAssetEdit = {
  init: function () {

    let _url = window.location.origin;
    let _voucher_no = $('input[name=voucher_no]').val();

    let account_code_table = $('.accountcode_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: '/journala/datatables?voucher_no=' + _voucher_no,
            map: function (raw) {
              let dataSet = raw;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: !0,
        serverSorting: !0
      },
      layout: {
        theme: 'default',
        class: '',
        scroll: false,
        footer: !1
      },
      sortable: !0,
      filterable: !1,
      pagination: !0,
      search: {
        input: $('#generalSearch')
      },
      toolbar: {
        items: {
          pagination: {
            pageSizeSelect: [5, 10, 20, 30, 50, 100]
          }
        }
      },
      columns: [
        {
          field: '#',
          title: 'No',
          width: '40',
          sortable: 'asc',
          filterable: !1,
          textAlign: 'center',
          template: function (row, index, datatable) {
            return (index + 1) + (datatable.getCurrentPage() - 1) * datatable.getPageSize()
          }
        },
        {
          field: 'coa.code',
          title: 'Account Code',
          sortable: 'asc',
          filterable: !1,
        },
        {
          field: 'coa.name',
          title: 'Account Name',
          sortable: 'asc',
          filterable: !1,
        },
        {
          field: 'debit_currency',
          title: 'Debit',
          sortable: 'asc',
          filterable: !1,
        },
        {
          field: 'credit_currency',
          title: 'Credit',
          sortable: 'asc',
          filterable: !1,
        },
        {
          field: 'description',
          title: 'Remark',
          sortable: 'asc',
          filterable: !1,
        },
        {
          field: 'Actions',
          width: 110,
          title: 'Actions',
          sortable: !1,
          overflow: 'visible',
          template: function (t, e, i) {
            return (
              '<button id="show_modal_journala" type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-uuid=' + t.uuid + ' data-description=' + t.coa.description + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
              '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
              t.uuid +
              ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
            );
          }
        }

      ]
    });

    let dispay_modal = $('body').on('click', '#show_modal_journala', function () {
      let _uuid = $(this).data('uuid');
      let _description = $(this).data('description');
      let _modal = $('#modal_coa_edit');
      let form = _modal.find('form');
      let tr = $(this).parents('tr');
      let tr_index = tr.index();
      let data = account_code_table.row(tr).data().mDatatable.dataSet[tr_index];
      let amount = '';

      console.table(data);

      amount = parseInt(data.credit);

      form.find('input[value=kredit]').prop('checked', true);

      if (data.debit > 0) {
        amount = parseInt(data.debit);
        form.find('input[value=debet]').prop('checked', true);
      }

      form.find('input#account_code').val(data.coa.code);
      form.find('input#account_description').val(data.coa.name);
      form.find('input[name=amount]').val(amount);
      form.find('textarea[name=remark]').val(data.description);

      _modal.find('input[name=uuid]').val(_uuid);
      _modal.modal('show');

    })

    let ubah = $('body').on('click', '#master_asset_save', function () {

      let button = $(this);
      let form = button.parents('form');
      let _data = form.serialize();
      let uuid = button.data('uuid');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'put',
        url: `/asset/${uuid}`,
        data: _data,
        success: function (response) {
          if (response.status) {
            toastr.success('Data Saved', 'Success', {
              timeOut: 2000
            });

            setTimeout(() => {
              location.replace(_url + '/asset');
            }, 2000)
          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });
    });

    // $('<a class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air btn-primary btn-sm refresh" style="margin-left: 60%; color: white;"><span><i class="la la-refresh"></i><span>Reload</span></span> </button>').appendTo('div.dataTables_filter');
    $('.paging_simple_numbers').addClass('pull-left');
    $('.dataTables_length').addClass('pull-right');
    $('.dataTables_info').addClass('pull-left');
    $('.dataTables_info').addClass('margin-info');
    $('.paging_simple_numbers').addClass('padding-datatable');

    $('.dataTables_filter').on('click', '.refresh', function () {
      $('#coa_datatables').DataTable().ajax.reload(null, false);

    });

    $('#coa_datatables').on('click', '.select-coa', function () {
      let tr = $(this).parents('tr');

      let data = coa_table.row(tr).data();

      $.ajax({
        url: '/journala',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        dataType: 'json',
        data: {
          'account_code': data.code,
          'voucher_no': _voucher_no
        },
        success: function (data) {

          $('#coa_modal').modal('hide');

          account_code_table.reload();

          toastr.success('Data Saved Successfully', 'Success', {
            timeOut: 2000
          });

        }
      });

    });

    let remove = $('.accountcode_datatable').on('click', '.delete', function () {
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
            url: '/journala/' + triggerid + '',
            success: function (data) {
              toastr.success('data has been deleted.', 'Deleted', {
                timeOut: 2000
              }
              );

              account_code_table.reload();
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

    // account code modal select 2 handler

    function splitSelect2Value(val) {
      let data = [];
      let arr = val.split('(')
      data['name'] = arr[0];

      let arr2 = arr[1].split(')');
      data['code'] = arr2[0];

      return data;
    }

    function formatSelected(state) {
      let x = splitSelect2Value(state.text)['code'];

      $('#_account_description').val(splitSelect2Value(state.text)['name']);
      // $('#account_description').remove();
      return x;
    }

    $('#_accountcode').select2({
      ajax: {
        url: _url + '/journal/get-account-code-select2',
        dataType: 'json'
      },
      minimumInputLength: 3,
      // templateSelection: formatSelected
    });

  }
};

let errorHandler = (response) => {

  let message = '';

  if (!('errors' in response)) {
    message = response.message;
  } else {
    errors = response.errors;

    loop = 0;
    $.each(errors, function (index, value) {

      if (!loop) {
        message = value[0]
      }

      loop++;
    })
  }

  toastr.error(message, 'Invalid', {
    timeOut: 2000
  });
}

jQuery(document).ready(function () {
  MasterAssetEdit.init();
});
