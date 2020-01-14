let ProfitLoss = {
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

			$('body').on('click', '.view-pl', function() {
				let href = $(this).data('href');
				let date = $('#daterange_profitloss').val();

				location.href=`${href}?daterange=${date}`;
			})

    }
};

jQuery(document).ready(function () {
    ProfitLoss.init();
});
