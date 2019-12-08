let Payroll = {
    init: function () {
        $('#all_employee').on('click', function () {
            $('#employee').select2('val','All').end();
            $('#employee').prop('disabled', true);
        });
        $('#employee_choose').on('click', function () {
            $('#employee').removeAttr("disabled");
        });

        let payroll_table = $('.payroll_datatable').mDatatable({
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
                    template: (row, index, datatable) => {
                        return (index + 1) + (datatable.getCurrentPage() - 1) * datatable.getPageSize()
                    }
                },
                {
                    field: '',
                    title: 'NRP',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Employee Name',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Total Days in Period',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Total Salary',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: 'Actions',
                    width: 110,
                    sortable: !1,
                    overflow: 'visible',
                    template: function (t, e, i) {
                        return (
                            '<button type="button" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit-item" title="Edit" data-description='+t.description+' data-total='+t.total+' data-uuid=' + t.uuid + '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</button>\t\t\t\t\t\t' +
                            '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                            t.uuid +
                            ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
                            );
                    }
                }

            ]
        });

        let payroll__information_table = $('.payroll_information_datatable').mDatatable({
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
                    template: (row, index, datatable) => {
                        return (index + 1) + (datatable.getCurrentPage() - 1) * datatable.getPageSize()
                    }
                },
                {
                    field: '',
                    title: 'Benefits Component',
                    sortable: 'asc',
                    filterable: !1,
                },
                {
                    field: '',
                    title: 'Total',
                    sortable: 'asc',
                    filterable: !1,
                },

            ]
        });
    }
};

jQuery(document).ready(function () {
    Payroll.init();
});
