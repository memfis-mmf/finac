let JournalEdit = {
    init: function () {
				let _url = window.location.origin;

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
                    width:'40',
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
                        return '<a href="/item/'+t.uuid+'">' + t.code + "</a>"
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
                    title: 'Debet',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Kredit',
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

        let ubah = $('body').on('click', '#journalsave', function () {

						let button = $(this);
            let form = button.parents('form');
            let _data = form.serialize();
						let uuid = button.data('uuid');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'put',
                url: `/journal/${uuid}`,
                data: _data,
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
                        toastr.success('Data berhasil disimpan.', 'Sukses', {
                            timeOut: 5000
                        });

												setTimeout(function(){ 
													location.href = `${_url}/journal`; 
												}, 2000);
                    }
                }
            });
        });

    }
};

jQuery(document).ready(function () {
    JournalEdit.init();
});
