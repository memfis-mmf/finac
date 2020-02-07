let MasterCoa = {
    init: function () {

        let _url = window.location.origin;

        let master_coa_datatable = $('.master_coa_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: ``,
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
                    field: 'asd',
                    title: 'Account No.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: '',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Account Group',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60,
                },
                {
                    field: '',
                    title: 'Sub Account',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: '',
                    title: 'Created By',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'Actions',
                    width: 110,
                    title: 'Active/Inactive',
                    sortable: !1,
                    overflow: 'visible',
                    template: function (t, e, i) {
                        '<div>'+
                            '<span class="m-switch m-switch--outline m-switch--icon m-switch--md">'+
                                    '<label> <input type="checkbox"><span></span></label>'+
                            '</span>'+
                        '</div>'
                    }
                }
            ]
        });
    }
};

jQuery(document).ready(function () {
    MasterCoa.init();
});
