let Payroll = {
    init: function () {
				let _url = window.location.origin;
        let payroll_datatable = $('.payroll_datatable').mDatatable({
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
                serverPaging: !1,
                serverFiltering: !0,
                serverSorting: !1
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
                    field: '',
                    title: 'Date',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: '',
                    title: 'Transaction No',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Period',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Total Payroll',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Status',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Create By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Approved By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'Actions',
                    width: 110,
                    title: 'Actions',
                    sortable: !1,
                    overflow: 'visible',
                    template: function (t, e, i) {
											if (!t.approve) {
												_html +=
                          '<a href="'+_url+'/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                          t.uuid +
                          '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
                          '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                          t.uuid +
                          ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t' +
                          '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-uuid="' + t.uuid + '">' +
                          '<i class="la la-check"></i>' +
                          '</a>';
											}

                      return (_html);
                    }
                }
            ]
        });
    }
};

jQuery(document).ready(function () {
    Payroll.init();
});
