let GeneralLedger = {
    init: function () {
        $('.general_ledger_datatable').mDatatable({
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
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: '',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: '',
                    title: 'Ref. No.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Debit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Balance',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                }
            ]
        });

    }
};

jQuery(document).ready(function () {
    GeneralLedger.init();
});
