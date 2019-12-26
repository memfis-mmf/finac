let scheduled_payments = {
    init: function () {

        $.fn.dataTable.ext.errMode = 'none';

        $('#table').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        } ) ;

        let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable( {
            data: dataSet,
            columns: [
                {
                  title: "Work Progress(%)",
                  data: "work_progress",
                  "render": function ( data, type, row, meta ) {
                    return data+"%";
                  }
                },
                {
                  title: "Amount",
                  data: "amount",
                  "render": function ( data, type, row, meta ) {
                    return data;
                  }
                },
                { title: "Amount(%)",
                data: "amount_percentage",
                  "render": function ( data, type, row, meta ) {
                    return data+"%";
                  }
                },
                {
                  title: "Description",
                  data: "description"
                }
            ],
            searching: false,
            paging: false,
            info: false,
            footer: true,
            "footerCallback": function(row, data, start, end, display) {

              var api = this.api();
                api.columns('0', {
                  page: 'current'
                }).every(function() {
                  var sum = this.data();
                  let arr_work_progress = sum.join();
                  let max = arr_work_progress.split(",");
                  Array.prototype.max = function() {
                    return Math.max.apply(null, this);
                  };
                  $( api.column( 0 ).footer() ).html("Work Progress : "+max.max()+"%");
                });
                api.columns('1', {
                  page: 'current'
                }).every(function() {
                  var sum = this
                    .data()
                    .reduce(function(a, b) {
                      var x = parseFloat(a) || 0;
                      var y = parseFloat(b) || 0;
                      return x + y;
                    }, 0);
                  $( api.column( 1 ).footer() ).html("Total Amount : "+sum);
                });

                  api.columns('2', {
                    page: 'current'
                  }).every(function() {
                    var sum = this
                      .data()
                      .reduce(function(a, b) {
                        var x = parseFloat(a) || 0;
                        var y = parseFloat(b) || 0;
                        return x + y;
                      }, 0);
                    $( api.column( 2 ).footer() ).html("Total Amount : "+sum+"%");
                  });

              }

        } );

        $('.add_scheduled_row').on('click', function () {
            $("#work_progress_scheduled-error").html('');
            $("#amount_scheduled-error").html('');
            $("#work_progress_scheduled").removeClass('is-invalid');
            $("#amount_scheduled").removeClass('is-invalid');
            let total = $('#grand_total').attr('value');
            let work_progress_scheduled = $("#work_progress_scheduled").val();
            let amount_scheduled = $("#amount_scheduled").val();
            let description_scheduled = $("#description_scheduled").val();
            let amount_scheduled_percentage = ( amount_scheduled / total) * 100;
            let sub_total = calculate_amount();
            let max = calculate_progress();
            let remaining = total - sub_total;
            if(work_progress_scheduled < max){
              $("#work_progress_scheduled-error").html('Work progess precentage cannot lower than '+max+'%');
              $("#work_progress_scheduled").addClass('is-invalid');
            }else if(work_progress_scheduled > 100){
              $("#work_progress_scheduled-error").html('Work progess precentage cannot exceed 100%');
              $("#work_progress_scheduled").addClass('is-invalid');
              return;
            }else if(parseInt(amount_scheduled) > parseInt(total)){
              $("#amount_scheduled-error").html('Amount inserted cannot exceed remaining '+ remaining +' of total');
              $("#amount_scheduled").addClass('is-invalid');
              return ;
            }else{
              let newRow = [];
              newRow["description"] = description_scheduled;
              newRow["work_progress"] = work_progress_scheduled;
              newRow["amount"] = amount_scheduled;
              newRow["amount_percentage"] = amount_scheduled_percentage;
              scheduled_payment_datatable
                  .row.add( newRow )
                  .draw();

              $("#work_progress_scheduled").val(0);
              $("#amount_scheduled").val(0);
              $("#description_scheduled").val("");
            }
        });

        $('#scheduled_payments_datatables tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
              scheduled_payment_datatable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('.delete_row').on('click', function () {
            scheduled_payment_datatable.row('.selected').remove().draw( false );
        });

        // calculate amount
        function calculate_amount() {
            let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
            let total = scheduled_payment_datatable.column(1).data().reduce( function (a,b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                return x + y;
            }, 0 );

            return total;
        }

        // calculate progress
        function calculate_progress() {
          let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
            let arrays = scheduled_payment_datatable.column(0).data();
            let max = Math.max(arrays.join());
            return max;
        }
    }
};

jQuery(document).ready(function () {
    scheduled_payments.init();
});
