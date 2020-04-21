let MasterAsset = {
  init: function () {

    let _url = window.location.origin;

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

    // let master_asset_datatable = $('.master_asset_datatable').mDatatable({
    //     data: {
    //         type: 'remote',
    //         source: {
    //             read: {
    //                 method: 'GET',
    //                 url: `${_url}/asset/datatables`,
    //                 map: function (raw) {
    //                     let dataSet = raw;

    //                     if (typeof raw.data !== 'undefined') {
    //                         dataSet = raw.data;
    //                     }

    //                     return dataSet;
    //                 }
    //             }
    //         },
    //         pageSize: 10,
    //         serverPaging: !1,
    //         serverFiltering: !0,
    //         serverSorting: !1
    //     },
    //     layout: {
    //         theme: 'default',
    //         class: '',
    //         scroll: false,
    //         footer: !1
    //     },
    //     sortable: !0,
    //     filterable: !1,
    //     pagination: !0,
    //     search: {
    //         input: $('#generalSearch')
    //     },
    //     toolbar: {
    //         items: {
    //             pagination: {
    //                 pageSizeSelect: [5, 10, 20, 30, 50, 100]
    //             }
    //         }
    //     },
    //     columns: [
    //         {
    //             field: 'code',
    //             title: 'Code Asset',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 60
    //         },
    //         {
    //             field: 'name',
    //             title: 'Asset Name',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150
    //         },
    //         {
    //             field: '',
    //             title: 'Ref. Doc',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 60,
    //         },
    //         {
    //             field: 'povalue',
    //             title: 'Asset Value',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150,
	// 							template: function(t, e, i) {
	// 								return 'Rp. ' + addCommas(parseInt(t.povalue));
	// 							}
    //         },
    //         {
    //             field: 'usefullife',
    //             title: 'Useful Life',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150,
	// 							template: function(t, e, i) {
	// 								return addCommas(parseInt(t.usefullife)) + ' month';
	// 							}
    //         },
    //         {
    //             field: 'coa_accumulate.name',
    //             title: 'COA Accumulate',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150,
    //         },
    //         {
    //             field: 'coa_expense.name',
    //             title: 'COA Expense',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150
    //         },
    //         {
    //             field: 'depreciationstart',
    //             title: 'Depreciation Start',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150
    //         },
    //         {
    //             field: 'depreciationend',
    //             title: 'Depreciation End',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150
    //         },
    //         {
    //             field: 'created_by.name',
    //             title: 'Created By',
    //             sortable: 'asc',
    //             filterable: !1,
    //             width: 150
    //         },
    //         {
    //             field: 'Actions',
    //             width: 110,
    //             title: 'Actions',
    //             sortable: !1,
    //             overflow: 'visible',
    //             template: function (t, e, i) {

	// 								let _html = '';

	// 								if (!t.approve) {
	// 									_html +=
    //                   '<a href="'+_url+'/asset/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
    //                   t.uuid +
    //                   '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
    //                   '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
    //                   t.uuid +
    //                   ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t' +
    //                   '<a href="javascript:;" data-uuid="'+t.uuid+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-uuid="' + t.uuid + '">' +
    //                   '<i class="la la-check"></i>' +
    //                   '</a>';
	// 								}

    //               return (_html);
    //             }
    //         }
    //     ]
    // });

        let master_asset_datatable = $('.master_asset_datatable').DataTable({
            dom: '<"top"f>rt<"bottom">pil',
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: `${_url}/asset/datatables`,
            order: [[0, 'desc']],
            columns: [
                {data: 'transaction_number', defaultContent: '-'},
                {data: 'name', defaultContent: '-'},
                {data: '', defaultContent: '-'} , //refdoc
                {data: 'povalue', defaultContent: '-', render: function (data, type, row) {
                    return addCommas(parseFloat(row.povalue));
                }},
                {data: 'usefullife', defaultContent: '-', render: function(data, type, row) {
                    return addCommas(parseFloat(row.usefullife))+' Month';
                }},
                {data: 'coa_accumulate.name', defaultContent: '-'},
                {data: 'coa_expense.name', defaultContent: '-'},
                {data: 'depreciationstart', defaultContent: '-'},
                {data: 'depreciationend', defaultContent: '-'},
                {data: 'created_by', defaultContent: '-'},
                {data: 'approved_by', defaultContent: '-'},
                {data: '', searchable: false, render: function (data, type, row) {
                    let t = row;

                    let _html = '';

                    if (!t.approve) {
                        _html +=
                        '<a href="'+_url+'/asset/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                        t.uuid +
                        '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                        t.uuid +
                        ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t' +
                        '<a href="javascript:;" data-uuid="'+t.uuid+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" title="Approve" data-uuid="' + t.uuid + '">' +
                        '<i class="la la-check"></i>' +
                        '</a>';
                    }

                    return (_html);
                }}
            ]
        });

        $(".dataTables_length select").addClass("form-control m-input");
        $(".dataTables_filter").addClass("pull-left");
        $(".paging_simple_numbers").addClass("pull-left");
        $(".dataTables_length").addClass("pull-right");
        $(".dataTables_info").addClass("pull-right");
        $(".dataTables_info").addClass("margin-info");
        $(".paging_simple_numbers").addClass("padding-datatable");

		let approve = $('body').on('click', 'a.approve', function() {
			let _uuid = $(this).data('uuid');
			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: '/asset/approve',
					data: {
							_token: $('input[name=_token]').val(),
							uuid: _uuid
					},
					success: function (data) {
							if (data.errors) {
									toastr.error(data.errors, 'Invalid', {
											timeOut: 3000
									});
							} else {
									toastr.success('Data berhasil disimpan.', 'Sukses', {
											timeOut: 3000
									});

									master_asset_datatable.ajax.reload();
							}
					}
			});
		})
  }
};

jQuery(document).ready(function () {
    MasterAsset.init();
});
