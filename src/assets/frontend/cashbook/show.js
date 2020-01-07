let Coa = {
    init: function () {
        $('.coa_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/coa/datatables',
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
                    field: 'code',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 100
                },
                {
                    field: 'name',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Amount',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: 'description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                }
            ]
        });

        $('.adjustment1_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/coa/datatables',
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
                    field: 'code',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 100
                },
                {
                    field: 'name',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Currency',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: '',
                    title: 'Exchange Rate',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: '',
                    title: 'Debet',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: '',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: 'description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                }
            ]
        });

        $('.adjustment2_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/coa/datatables',
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
                    field: 'code',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 100
                },
                {
                    field: 'name',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Debet',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: '',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: 'description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                }
            ]
        });
    }
};

jQuery(document).ready(function () {
    Coa.init();
});
