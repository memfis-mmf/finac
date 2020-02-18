let TrialBalance = {
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

			$('body').on('change', '#daterange_trial_balance', function() {

				$('.trial_balance_datatable').remove();
				$('.place-datatable').append(`<div class="trial_balance_datatable" id="scrolling_both"></div>`);

				let _val = $(this).val();

        $('.trial_balance_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: _url+'/trial-balance/datatables?daterange='+_val,
                        map: function (raw) {
                            let dataSet = raw;

                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }

                            return dataSet;
                        }
                    }
                },
                pageSize: 100,
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
                    width: 90,
                    template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + t.code + '</b>';
                        }
                        else
                            return t.code;

                    }
                },
                {
                    field: 'name',
                    title: 'Account Name',
                    sortable: 'asc',
                    filterable: !1,
                    width: 300,
                    template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + t.name + '</b>';
                        }
                        else
                            return t.name;

                    }
                },
                {
                    field: 'LastBalance',
                    title: 'Begining Balance',
                    sortable: 'asc',
                    filterable: !1,
                    width: 180,
                    template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + addCommas(parseInt(t.LastBalance)) + '</b>';
                        }
                        else
                            return addCommas(parseInt(t.LastBalance));

                    }
                },
                {
                    field: 'Debit',
                    title: 'Debit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 180,
                    template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + addCommas(parseInt(t.Debit)) + '</b>';
                        }
                        else
                            return addCommas(parseInt(t.Debit));

                    }
                },
                {
                    field: 'Credit',
                    title: 'Credit',
                    sortable: 'asc',
                    filterable: !1,
                    width: 180,
					template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + addCommas(parseInt(t.Credit)) + '</b>';
                        }
                        else
                            return addCommas(parseInt(t.Credit));

                    }
                },
                {
                    field: 'EndingBalance',
                    title: 'Ending Balance',
                    sortable: 'asc',
                    filterable: !1,
                    width: 180,
					template: function(t, e, i) {
                        if (t.code.slice(-2) == '00') {
                            return '<b>' + addCommas(parseInt(t.EndingBalance)) + '</b>';
                        }
                        else
                            return addCommas(parseInt(t.EndingBalance));

                    }
                },
            ]
        });
			});
    }
};

jQuery(document).ready(function () {
    TrialBalance.init();
});
