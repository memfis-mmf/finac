let GeneralLedger = {
    init: function () {
				let _url = window.location.origin;
				let _beginDate = $('[name=_beginDate]').val();
				let _endingDate = $('[name=_endingDate]').val();
				let _coa = $('[name=_coa]').val();

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

        $('.general_ledger_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: `${_url}/general-ledger/show/datatables?beginDate=${_beginDate}&endingDate=${_endingDate}&coa=${_coa}`,
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
                    field: 'TransactionDate',
                    title: 'Date',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: 'AccountCode',
                    title: 'Account Code',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: 'Name',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 60
                },
                {
                    field: 'VoucherNo',
                    title: 'Ref. No.',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'Description',
                    title: 'Description',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150
                },
                {
                    field: 'Debit',
                    title: 'Debit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
										template: function(t, e, i) {
											return addCommas(parseInt(t.Debit));
										}
                },
                {
                    field: 'Credit',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
										template: function(t, e, i) {
											return addCommas(parseInt(t.Credit));
										}
                },
                {
                    field: 'SaldoAkhir',
                    title: 'Balance',
                    sortable: 'asc',
                    filterable: !1,
                    width: 150,
										template: function(t, e, i) {
											return addCommas(parseInt(t.SaldoAkhir));
										}
                }
            ]
        });

    }
};

jQuery(document).ready(function () {
    GeneralLedger.init();
});
