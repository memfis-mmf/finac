let total = 0;
let total1 = 0;
var discount = 0;
var tax = 0;
let quotation = $('#quotation_uuid').val();

let manhour_price = 0;
let material_price = 0;
let facility_price = 0;
let discount_price = 0;
let ppn_price = 0;
let others_price = 0;
let grand_total1 = 0;
let convertidr = 0;
let other_total = 0;
let schedule_payment = '';
let dataSet = '';
let discount_amount = 0;
let tax_amount = 0;

let exchange_rate = parseInt($('#exchange_rate').attr('value'));
let _exchange_rate = 1;

const formatter = new Intl.NumberFormat('de-DE', {
   minimumFractionDigits: 2,
   maximumFractionDigits: 2,
});

let number_format = new Intl.NumberFormat('de-DE', {
   minimumFractionDigits: 2,
   maximumFractionDigits: 2,
});

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
let _url = window.location.origin;
// untuk datatable dengan accordion pada row tersebut
var DatatableAutoColumnHideDemo = function () {
  //== Private functions

  // basic demo
  var demo = function () {
    let _currency = $('#currency').val();

    // var dataJSONArrayLong = JSON.parse('[{ "OrderID" : "OrderID","ShipCountry" : "ShipCountry","ShipCity" : "ShipCity","Currency" : "Currency","ShipDate" : "ShipDate", "Latitude" : "Latitude","Longitude" : "Longitude","Notes" : "Notes","Department" : "Department","Website" : "Website", "TotalPayment" : "TotalPayment","Status" : 1,"Type" : 1},{ "OrderID" : "OrderID","ShipCountry" : "ShipCountry","ShipCity" : "ShipCity","Currency" : "Currency","ShipDate" : "ShipDate", "Latitude" : "Latitude","Longitude" : "Longitude","Notes" : "Notes","Department" : "Department","Website" : "Website", "TotalPayment" : "TotalPayment","Status" : 1,"Type" : 1}]');
    let locale = 'id';
    let IDRformatter = new Intl.NumberFormat(locale, { style: 'currency', currency: 'idr', minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let ForeignFormatter = new Intl.NumberFormat(locale, { style: 'currency', currency: _currency, minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let no = 1;

    $.ajax({
      type: "get",
      url: _url+'/invoice/calculate-quo',
      data: {
        'invoice_currency': _currency,
        'uuid_quo': uuidquo,
      },
      dataType: "json",
      success: function (response) {
        symbol = [];
        symbol['idr'] = 'Rp'
        symbol['foreign'] = 'US$'

        /*****************************************
        *  set nilai perhitungan  *
        *****************************************/
        $("#other_price_val").val(response.price_other);
        $("#sub_total_val").val(response.subtotal);
        $("#total_discount_val").val(response.discount_amount);
        $("#total_val").val(response.total);
        $("#tax_total_val").val(response.tax_amount);
        $("#grand_total_val").val(response.grandtotal_amount);

        if (_currency == 'idr') {
          formater_val = 'idr';
          $("#grand_totalrp_val").val(response.grandtotal_amount);
          $("#grand_totalrp").val(IDRformatter.format(response.grandtotal_amount));
        }else{
          formater_val = 'foreign';
          $("#grand_totalrp_val").val(
            response.grandtotal_amount * $('#exchange_rate1111').val()
          );
          $("#grand_totalrp").val(IDRformatter.format(
            response.grandtotal_amount * $('#exchange_rate1111').val()
          ));
        }

        $("#sub_total").val(symbol[formater_val] + ' ' + number_format.format(response.subtotal));
        $("#total_discount").val(symbol[formater_val] + ' -' + number_format.format(Math.abs(response.discount_amount)));
        $("#total").val(symbol[formater_val] + ' ' + number_format.format(response.total));
        $("#other_price").val(symbol[formater_val] + ' ' + number_format.format(response.price_other));
        $("#grand_total").val(symbol[formater_val] + ' ' + number_format.format(response.grandtotal_amount));
        $("#tax").val(number_format.format(response.tax_amount));
        $('.tax-symbol').html(symbol[formater_val])
        $('#vat_type').html(response.vat_type)

        /***********************************************
        *  akhir set nilai perhitungan  *
        ************************************************/
      }
    });

    $('.summary_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: '/invoice/quotation/table/modal/' + uuidquo + '/detail',
            map: function (raw) {
              let dataSet = raw;
              let total = subtotal = 0;
              var discount = 0;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: !1,
        serverSorting: !1

      },
      responsive: true,

      sortable: true,

      pagination: true,

      toolbar: {

        items: {

          pagination: {

            pageSizeSelect: [10, 20, 30, 50, 100],
          },
        },
      },

      search: {
        input: $('#generalSearch'),
      },

      rows: {


      },
      columns: [
        {
          field: 'code',
          title: 'No',
          class:'text-center',
          width: '80px',
          template: function (t) {
            // if this is other, return null
            // if (t.priceother != null) {
            //   return '';
            // }

            // return t.code;
            return no++;
          }
        },
        {
          field: 'description',
          title: 'Detail',
          width: '500px',

          template: function (t) {
            if (t.htcrrcount == null && t.priceother == null) {
              var template = "";
              var basic = "&nbsp;&nbsp;&nbsp;&nbsp;Basic TaskCard " + t.basic + " item(s)<br/>";
              var sip = "&nbsp;&nbsp;&nbsp;&nbsp;SIP TaskCard " + t.sip + " item(s)<br/>";
              var cpcp = "&nbsp;&nbsp;&nbsp;&nbsp;CPCP TaskCard " + t.cpcp + " item(s)<br/>";
              var adsb = "&nbsp;&nbsp;&nbsp;&nbsp;AD/SB TaskCard " + t.adsb + " item(s)<br/>";
              var cmrwl = "&nbsp;&nbsp;&nbsp;&nbsp;CMR/AWL TaskCard " + t.cmrawl + " item(s)<br/>";
              var eo = "&nbsp;&nbsp;&nbsp;&nbsp;EO TaskCard " + t.eo + " item(s)<br/>";
              var ea = "&nbsp;&nbsp;&nbsp;&nbsp;EA TaskCard " + t.ea + " item(s)<br/>";
              var si = "&nbsp;&nbsp;&nbsp;&nbsp;SI TaskCard " + t.si + " item(s)";
              if (t.basic != 0 && 'basic' in t) {
                template += basic;
              }
              if (t.sip != 0 && 'sip' in t) {
                template += sip;
              }
              if (t.cpcp != 0 && 'cpcp' in t) {
                template += cpcp;
              }
              if (t.adsb != 0 && 'adsb' in t) {
                template += adsb;
              }
              if (t.cmrawl != 0 && 'cmrawl' in t) {
                template += cmrwl;
              }
              if (t.eo != 0 && 'eo' in t) {
                template += eo;
              }
              if (t.ea != 0 && 'ea' in t) {
                template += ea;
              }
              if (t.si != 0 && 'si' in t) {
                template += si;
              }

              materialitem = '';
              if ('materialitem' in t) {
                materialitem = t.materialitem;
              }

              return (
                "<b>" + t.description + "</b><br/>"
                + "Facility <br/>"
                + "Material Need " + materialitem + " item(s)<br/>"
                + "Total " + t.total_manhours_with_performance_factor + " Manhours<br/>"
                + template

              );
            } else if (t.htcrrcount != null) {
              return (
                "&nbsp;&nbsp;&nbsp;&nbsp;HardTime TaskCard " + t.htcrrcount + " item(s)"

              );

            } else if (t.priceother != null) {
              return '';
            }

          }
        },
        {
          field: 'total',
          title: 'Total Amount',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {

            // rate invoice selalu 1 jika currency invoice idr
            // jika invoice currency-nya idr maka convert to idr menggunkana rate QN
            // jika invoice currency-nya foreign maka convert to idr menggunakan rate invoice sendiri
            if (_currency == 'idr') {
              multiple = t.quotations[0].exchange_rate;
            }else{
              multiple = 1;
            }

            // jika htcrr kosong dan priceother kosong
            if (t.htcrrcount == null && t.priceother == null) {
              $('#term_and_condition').summernote('code', t.quotations[0].term_of_condition);

              if (_currency == 'idr') {
                facility_price += t.facilities_price_amount * multiple;
                material_price += t.mat_tool_price * multiple;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * multiple;

                _result =
                  '<br>' +
                  IDRformatter.format(t.facilities_price_amount * multiple) + '<br>' +
                  IDRformatter.format(t.mat_tool_price * multiple) + '<br>' +
                  IDRformatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * multiple) + '<br>'
                ;
              } else {

                facility_price += t.facilities_price_amount;
                material_price += t.mat_tool_price;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount;

                _result =
                  '<br>' +
                  ForeignFormatter.format(t.facilities_price_amount) + '<br>' +
                  ForeignFormatter.format(t.mat_tool_price) + '<br>' +
                  ForeignFormatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + '<br>'
              }

            } else if (t.htcrrcount != null) {
              $("#htcrr_price_val").val(t.price * multiple);

              if (_currency == 'idr') {
                _result = IDRformatter.format(t.price * multiple) + "<br/>"
              } else {
                _result = ForeignFormatter.format(t.price) + "<br/>"
              }
            } else if (t.priceother != null) {
              let _price_other = parseFloat(t.priceother) * multiple;

              _result = "<br/>";
            }

            // hide last line datalist
            count_data = $('.summary_datatable tbody tr').length;

            if (count_data > 1) {
              $('.summary_datatable tbody tr').eq(count_data - 1).find('span').css('color', 'transparent');
            }

            return _result;

          }
        },
      ],
    });

  };

  return {
    // public functions
    init: function () {
      demo();
    },
  };
}();

jQuery(document).ready(function () {
  $("#add-invocheck").click(function () {
    uuidquo = $("#refquono").data('uuid');
    $("#actheader").attr("hidden", true);
    $("#hiddennext").removeAttr("hidden");
    DatatableAutoColumnHideDemo.init();

    //alert("The paragraph was clicked.");
  });

  $("#pph").change(function () {
    let pph = subtotal - discount * (this.value / 100);
    let fixed = pph.toFixed(2);
    $("#percent").attr("value", fixed);
  });
  $('.action-buttons').on('click', '.add-invoice', function () {
    //alert("test");

    // let type = $('#scheduled_payment_type').children("option:selected").html();

    // $('#scheduled_payment ').each(function (i) {
    //     scheduled_payment_amount_array[i] = parseInt($(this).val());
    // });

    // $('#scheduled_payment_note ').each(function (i) {
    //     scheduled_payment_note_array[i] = $(this).val();
    // });
    // scheduled_payment_array.pop();

    let _form = $(this).parents('form');
    _form.find('[disabled=disabled]').removeAttr('disabled');

    let data = new FormData();
    data.append('date', $('[name=date]').val());
    data.append('presdir', $('[name=presdir]').val());
    data.append('location', $('[name=location]').val());
    data.append('company_department', $('[name=company_department]').val());

    data.append("quotation", $('#refquono').val());
    data.append("pdir", $('#pdir').val());
    data.append("currency", $('#currency').val());
    data.append("exchange_rate", $('#exchange_rate1111').val());
    // data.append("bank", $("#bankinfo option:selected").val());
    data.append("bank", $('[name=bankinfo]').val());
    data.append("bank2", $('[name=bankinfo2]').val());
    data.append("bank3", $('[name=bankinfo3]').val());
    data.append("pph", 10);
    data.append("pphvalue", tax);
    // data.append("scheduled_payment_amount", JSON.stringify(scheduled_payment_amount_array));
    // data.append("scheduled_payment_note", JSON.stringify(scheduled_payment_note_array));
    data.append('attention', $("#attention option:selected").text());
    data.append('phone', $("#phone option:selected").text());
    data.append('fax', $("#fax option:selected").text());
    data.append('email', $("#email option:selected").text());
    data.append("account", $('#coa').val());
    data.append("material",$(".material").val());
    data.append("manhours",$(".manhours").val());
    data.append("facility",$(".facility").val());
    data.append("discount",$(".discount").val());
    data.append("ppn",$(".ppn").val());
    data.append("other",$(".others").val());
    data.append("facilityprice",facility_price);
    data.append("materialprice",material_price);
    data.append("manhoursprice",manhour_price);
    data.append("discountprice",discount_price);

    data.append("subtotal_val", $("#sub_total_val").val());
    data.append("discount_val", $("#total_discount_val").val());
    data.append("total_val", $("#total_val").val());
    data.append("other_price_val", $("#other_price_val").val());
    data.append("htcrr_price_val", $("#htcrr_price_val").val());
    data.append("tax_total_val", $("#tax_total_val").val());
    data.append("grandtotal_val", $("#grand_total_val").val());
    data.append("grandtotalrp_val", $("#grand_totalrp_val").val());
    // data.append("ppnprice",ppn_price);
    // data.append(
    // 	"ppnprice",
    // 	$('#tax').val().split('.').join('')
    // );
    data.append("schedule_payment",$("#due_payment").val());
    data.append("otherprice",others_price);
    data.append("description", $('textarea#desc').val());
    data.append("term_and_condition", $('textarea#term_and_condition').val());

    let grandtotal = $("#grand_total").val();

    console.table({
      'data': data,
      'grand_total': grandtotal
    });


    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      type: 'post',
      url: '/invoice',
      processData: false,
      contentType: false,
      data: data,
      success: function (data) {

        if(data.error) {
          toastr.error(data.error, 'Invalid',  {
            timeOut: 2000
          });
        } else if (data.errors) {
          if (data.errors.currency_id) {
            $("#currency-error").html(data.errors.currency_id[0]);
          }
          if (data.errors.customer_id) {
            $("#customer_id-error").html(data.errors.customer_id[0]);
          }
          if (data.errors.description) {
            $("#description-error").html(data.errors.description[0]);
          }
          if (data.errors.exchange_rate) {
            $("#exchange-error").html(data.errors.exchange_rate[0]);
          }
          if (data.errors.project_id) {
            $("#work-order-error").html(data.errors.project_id[0]);
          }
          if (data.errors.requested_at) {
            $("#requested_at-error").html(data.errors.requested_at[0]);
          }
          if (data.errors.scheduled_payment_amount) {
            $("#scheduled_payment_amount-error").html(data.errors.scheduled_payment_amount[0]);
          }
          if (data.errors.scheduled_payment_type) {
            $("#scheduled_payment_type-error").html(data.errors.scheduled_payment_type[0]);
          }
          if (data.errors.valid_until) {
            $("#valid_until-error").html(data.errors.valid_until[0]);
          }
          if (data.errors.title) {
            $("#title-error").html(data.errors.title[0]);
          }

        } else {

          toastr.success('Invoice has been created.', 'Success', {
            timeOut: 5000
          });

          window.location.href = '/invoice/';

        }
      }
    });
  });
  //DatatableAutoColumnHideDemo.init();
});
