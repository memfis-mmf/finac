let Coa = {
    init: function () {
				let _url = window.location.origin;

        let coa_modal_datatable = $("#coa_datatables").DataTable({
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
                    data: "Actions"
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

        // let coa_datatable = $('.coa_datatable').mDatatable({
        //     data: {
        //         type: 'remote',
        //         source: {
        //             read: {
        //                 method: 'GET',
        //                 url: '',
        //                 map: function (raw) {
        //                     let dataSet = raw;
				//
        //                     if (typeof raw.data !== 'undefined') {
        //                         dataSet = raw.data;
        //                     }
				//
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
        //             field: '',
        //             title: 'Account Code',
        //             sortable: 'asc',
        //             filterable: !1,
        //             width: 60
        //         },
        //         {
        //             field: '',
        //             title: 'Account Name',
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
        //                 return (
        //                     '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
        //                     t.uuid +
        //                     ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t'
        //                 );
        //             }
        //         }
        //     ]
        // });

				let coa_datatable = $('.coa_datatable').DataTable({
					'paging':false,
					"ordering":false,
	        "info":false,
	        "searching":false,
				});

        $('#coa_datatables').on('click', '.select-coa', function () {
					let tr = $(this).parents('tr');
					let data = coa_modal_datatable.row( tr ).data();

					coa_datatable.row.add([
		        data.code,
		        data.name,
						'<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill delete" href="javascript:;" title="Delete"><i class="la la-trash"></i> </a>'
			    ]).draw();

					$('.modal').modal('hide');
        });

        $('.coa_datatable').on('click', '.delete', function () {
					let tr = $(this).parents('tr');

					console.log('wew')

					coa_datatable.row(tr).remove().draw();
				});

				$('body').on('click', '.view', function() {
					let data = coa_datatable.rows().data();
					let param = [];
					let date = $('[name=daterange_general_ledger]').val();

					for (var data_index = 0; data_index < data.length; data_index++) {
						param[data_index] = data[data_index][0];
					}

					location.href = _url+'/general-ledger/show/?data='+param+'&date='+date;
				});

    }
};

jQuery(document).ready(function () {
    Coa.init();
});
