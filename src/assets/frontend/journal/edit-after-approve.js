let JournalEdit = {
    init: function () {

      let _voucher_no = $('input[name=voucher_no]').val();
      let number_format = new Intl.NumberFormat('de-DE');

      column_list = [];

      column_list.push(
          {data: 'coa.code'},
          {data: 'coa.name'},
          {data: 'project.code', defaultContent: '-'},
          {data: 'debit', render: (data, type, row) => {
            return row.journal.currency.symbol + ' ' + number_format.format(row.debit);
          }},
          {data: 'credit', render: (data, type, row) => {
            $("#total_debit").val(
              number_format.format(parseFloat(row.total_debit))
            );
            $("#total_credit").val(
              number_format.format(parseFloat(row.total_credit))
            );
            return row.journal.currency.symbol + ' ' + number_format.format(row.credit);
          }},
          {data: 'description_field', name: 'description_2'},
          {data: 'action'}
      );
      
      let account_code_table = $('.journala_datatable').DataTable({
        dom: '<"top"f>rt<"bottom">pil',
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: $('.journala_datatable').data('url'),
        columns: column_list
      });

			// $('<a class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air btn-primary btn-sm refresh" style="margin-left: 60%; color: white;"><span><i class="la la-refresh"></i><span>Reload</span></span> </button>').appendTo('div.dataTables_filter');
			$('.paging_simple_numbers').addClass('pull-left');
			$('.dataTables_length').addClass('pull-right');
			$('.dataTables_info').addClass('pull-left');
			$('.dataTables_info').addClass('margin-info');
			$('.paging_simple_numbers').addClass('padding-datatable');

    }
};

jQuery(document).ready(function () {
    JournalEdit.init();
});
