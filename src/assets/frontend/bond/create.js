let BondCreate = {
    init: function () {

        let _url = window.location.origin;

        let coa_datatables = $("#coa_datatables").DataTable({
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
                    data: "Actions",
                    searchable: false,
                    orderable: false
                }
            ],
            columnDefs: [{
                targets: -1,
                orderable: !1,
                render: function (a, e, t, n) {
                    return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
                }
            },

            ]
        })

        $('body').on('click', '#coa_button_1', function () {
            let _modal = $('#coa_modal');

            _modal.find('.modal-body input[name=_type]').remove();
            _modal.find('.modal-body').prepend(
                `<input type hidden name="_type" value="coa">`
            );
            _modal.modal('show');

        });

        $('body').on('click', '#coa_button_2', function () {
            let _modal = $('#coa_modal');

            _modal.find('.modal-body input[name=_type]').remove();
            _modal.find('.modal-body').prepend(
                `<input type hidden name="_type" value="coa_bond">`
            );
            _modal.modal('show');

        });

        $('body').on('click', '.select-coa', function () {
            let tr = $(this).parents('tr');
            let data = coa_datatables.row(tr).data();
            let _type = tr.parents('.modal-body').find('input[name=_type]').val();

            if (_type == "coa") {
                $('input[id=coa]').val(data.code);
                $('input[id=account_name_1]').val(data.name);
            } else {
                $('input[id=coa_bond]').val(data.code);
                $('input[id=account_name_2]').val(data.name);
            }

            $('.modal').modal('hide');
        });

        $('.accountcode_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '',
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
                    field: '',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    template: function (t) {
                        return '<a href="/item/' + t.uuid + '">' + t.code + "</a>"
                    }
                },
                {
                    field: '',
                    title: 'Accoount Name',
                    sortable: 'asc',
                    filterable: !1,
                    template: function (t) {
                        return t.pivot.serial_number
                    }
                },
                {
                    field: '',
                    title: 'Debit',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
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
                            '<button data-toggle="modal" data-target="#modal_coa_edit" type="button" href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-item=' +
                            t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                            '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                            t.uuid +
                            ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                        );
                    }
                }

            ]
        });

        let simpan = $('body').on('click', '#bond_save', function () {

            let form = $(this).parents('form');
            let _data = form.serialize();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/bond',
                data: _data,
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        toastr.success('Data Saved', 'Success', {
                            timeOut: 2000
                        });

                        setTimeout(() => {
                            location.replace(response.redirect);
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

    }
};

let errorHandler = (response) => {

    console.log(response);

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
    BondCreate.init();
});
