let MasterAsset = {
  init: function () {

		let _url = window.location.origin;

    $('.master_asset_datatable').mDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    method: 'GET',
                    url: `${_url}/asset/datatables`,
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
                title: 'Code Asset',
                sortable: 'asc',
                filterable: !1,
                width: 60
            },
            {
                field: 'name',
                title: 'Asset Name',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: '',
                title: 'Ref. Doc',
                sortable: 'asc',
                filterable: !1,
                width: 60,
            },
            {
                field: '',
                title: 'Asset Value',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: 'usefullife',
                title: 'Useful Life',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: '',
                title: 'COA Accumulate',
                sortable: 'asc',
                filterable: !1,
                width: 150,
            },
            {
                field: '',
                title: 'COA Expense',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: '',
                title: 'Depreciation Start',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: '',
                title: 'Depreciation End',
                sortable: 'asc',
                filterable: !1,
                width: 150
            },
            {
                field: 'created_by.name',
                title: 'Created By',
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

									let _html = '';

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
    MasterAsset.init();
});
