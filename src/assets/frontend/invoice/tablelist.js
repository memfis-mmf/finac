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
    let IDRformatterTax = new Intl.NumberFormat(locale, { style: 'currency', currency: 'idr', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    let ForeignFormatterTax = new Intl.NumberFormat(locale, { style: 'currency', currency: _currency, minimumFractionDigits: 0, maximumFractionDigits: 0 });
    let numberFormat = new Intl.NumberFormat('id', { maximumSignificantDigits: 3, maximumFractionDigits: 2, minimumFractionDigits: 2 });

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
          width: '200px',
          template: function (t) {
            // if this is other, return null
            if (t.priceother != null) {
              return '';
            }

            return t.code;
          }
        }, 
        {
          field: 'description',
          title: 'Detail',
          width: '700px',

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
              if (t.basic != 0) {
                template += basic;
              }
              if (t.sip != 0) {
                template += sip;
              }
              if (t.cpcp != 0) {
                template += cpcp;
              }
              if (t.adsb != 0) {
                template += adsb;
              }
              if (t.cmrawl != 0) {
                template += cmrwl;
              }
              if (t.eo != 0) {
                template += eo;
              }
              if (t.ea != 0) {
                template += ea;
              }
              if (t.si != 0) {
                template += si;
              }
              return (
                "<b>" + t.description + "</b><br/>"
                + "Facility <br/>"
                + "Material Need " + t.materialitem + " item(s)<br/>"
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
          title: 'Total',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {
            // jika htcrr kosong dan priceother kosong
            if (t.htcrrcount == null && t.priceother == null) {

              if (_currency == 'idr') {
                temptotal = ((t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + t.mat_tool_price).toFixed(2);
                subtotal += temptotal;
                discount_amount = 0;

                let _subtotal = (
                  t.quotations[0].subtotal * t.quotations[0].exchange_rate
                ).toFixed(2);
                subtotal = _subtotal;

                if (t.discount_type == 'amount') {
                  discount_amount = t.quotations[0].pivot.discount_value * t.quotations[0].exchange_rate;
                } else {
                  if (t.discount_type == 'percentage') {
                    discount_amount = (
                      t.quotations[0].pivot.discount_value * _subtotal
                    ) / 100;
                  }
                }

                if (t.quotations[0].taxes[0].amount) {
                  tax_amount = t.quotations[0].taxes[0].amount;
                }

                if (t.quotations[0].taxes[0].percent) {
                  tax_amount = t.quotations[0].taxes[0].percent;
                }

                if (!t.quotations[0].taxes[0].percent && !t.quotations[0].taxes[0].amount) {
                  tax_amount = 0;
                }

                let grandtotal_amount = _subtotal - discount_amount + tax_amount

                discount_price = discount_amount;
                ppn_price = tax_amount;
                tax = tax_amount;

                $("#sub_total_val").val(_subtotal);
                $("#total_discount_val").val(discount_amount);
                $("#grand_total_val").val(grandtotal_amount);
                $("#grand_totalrp_val").val(grandtotal_amount);

                console.table([
                  1,
                  t.quotations[0].subtotal * t.quotations[0].exchange_rate,
                  (t.quotations[0].pivot.discount_value * t.quotations[0].subtotal) * t.quotations[0].exchange_rate,
                  (((t.quotations[0].subtotal * t.quotations[0].exchange_rate) * (10/100)) * t.quotations[0].exchange_rate)
                ]);

                $("#sub_total").val(IDRformatter.format(_subtotal));
                $("#total_discount").val(IDRformatter.format(discount_amount));
                $("#grand_total").val(IDRformatter.format(grandtotal_amount));
                $("#grand_totalrp").val(IDRformatter.format(grandtotal_amount));

                console.table([
                  2,
                  t.quotations[0].subtotal * t.quotations[0].exchange_rate,
                  (t.quotations[0].pivot.discount_value * t.quotations[0].subtotal) * t.quotations[0].exchange_rate,
                  (((t.quotations[0].subtotal * t.quotations[0].exchange_rate) * (10/100)) * t.quotations[0].exchange_rate)
                ]);

                $('.tax-symbol').html('Rp')
                $("#tax").val(addCommas(tax_amount));

                facility_price += t.facilities_price_amount * t.quotations[0].exchange_rate;
                material_price += t.mat_tool_price * t.quotations[0].exchange_rate;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * t.quotations[0].exchange_rate;

                return (
                  IDRformatter.format(t.facilities_price_amount * t.quotations[0].exchange_rate) + '<br>' +
                  IDRformatter.format(t.mat_tool_price * t.quotations[0].exchange_rate) + '<br>' +
                  IDRformatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * t.quotations[0].exchange_rate) + '<br>'
                );
              } else {
                temptotal = ((t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + t.mat_tool_price).toFixed(2);
                subtotal += temptotal;
                if(t.pivot.discount_type == 'amount'){
                  discount += t.pivot.discount_value;
                  }else {
                    if(t.pivot.discount_type == 'percentage') {
                    discount += temptotal * (t.pivot.discount_value/100);
                  }else{
                    discount += 0;
                  }
                }
                discount_amount = 0;

                let _subtotal = (t.quotations[0].subtotal).toFixed(2);
                subtotal = _subtotal;

                if (t.discount_type == 'amount') {
                  discount_amount = t.quotations[0].pivot.discount_value;
                } else {
                  if (t.discount_type == 'percentage') {
                    discount_amount = (
                      t.quotations[0].pivot.discount_value * _subtotal
                    ) / 100;
                  }
                }

                if (t.quotations[0].taxes[0].amount) {
                  tax_amount = t.quotations[0].taxes[0].amount;
                }

                if (t.quotations[0].taxes[0].percent) {
                  tax_amount = t.quotations[0].taxes[0].percent;
                }

                if (!t.quotations[0].taxes[0].percent && !t.quotations[0].taxes[0].amount) {
                  tax_amount = 0;
                }

                let grandtotal_amount = _subtotal - discount_amount + tax_amount

                discount_price = discount_amount;
                ppn_price = tax_amount;
                tax = tax_amount;

                let quotation_currency_value = t.quotations[0].exchange_rate;
                let multiple = 0;

                if (
                  t.quotations[0].currency.code == $('#currency').val()
                  && $('#currency').val() != 'idr'
                ) {
                  multiple = $('#exchange_rate1111').val();
                }else{
                  multiple = t.quotations[0].exchange_rate;
                }
                
                _exchange_rate = multiple;

                $("#sub_total_val").val(_subtotal);
                $("#total_discount_val").val(discount_amount);
                $("#grand_total_val").val(grandtotal_amount);
                $("#grand_totalrp_val").val(
                  grandtotal_amount * multiple
                );
                console.table([
                  3,
                  t.quotations[0].subtotal * t.quotations[0].exchange_rate,
                  (t.quotations[0].pivot.discount_value * t.quotations[0].subtotal) * t.quotations[0].exchange_rate,
                  (((t.quotations[0].subtotal * t.quotations[0].exchange_rate) * (10/100)) * t.quotations[0].exchange_rate)
                ]);

                $("#sub_total").val(ForeignFormatter.format(_subtotal));
                $("#total_discount").val(ForeignFormatter.format(discount_amount));
                $("#grand_total").val(ForeignFormatter.format(grandtotal_amount));
                $("#grand_totalrp").val(IDRformatter.format(
                  grandtotal_amount * t.quotations[0].exchange_rate
                ));
                console.table([
                  4,
                  t.quotations[0].subtotal * t.quotations[0].exchange_rate,
                  (t.quotations[0].pivot.discount_value * t.quotations[0].subtotal) * t.quotations[0].exchange_rate,
                  (((t.quotations[0].subtotal * t.quotations[0].exchange_rate) * (10/100)) * t.quotations[0].exchange_rate)
                ]);

                $('.tax-symbol').html('US$')
                $("#tax").val(addCommas(tax_amount));

                facility_price += t.facilities_price_amount;
                material_price += t.mat_tool_price;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount;

                return (
                  ForeignFormatter.format(t.facilities_price_amount) + '<br>' +
                  ForeignFormatter.format(t.mat_tool_price) + '<br>' +
                  ForeignFormatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + '<br>'
                );
              }
            } else if (t.htcrrcount != null) {
              tipetax = t.tax_type;
              if (tipetax == "include") {
                tax = (subtotal - discount) / 1.1 * 0.1;
              } else {
                tax = (subtotal - discount) * 0.1;
              }

              others_data = JSON.parse(t.other);
              $.each(others_data, function (k, v) {
                other_total += v.amount;
                $(".append-other").append("<div class=\"form-group m-form__group row\"><div class=\"col-sm-3 col-md-3 col-lg-3\"><div>" + v.type + "</div></div><div class=\"col-sm-6 col-md-6 col-lg-6\"><input type=\"text\" id=\"others\" value=\"" + v.amount + "\" name=\"\" class=\"form-control m-input others\" readonly><div class=\"form-control-feedback text-danger\" id=\"-error\"></div><span class=\"m-form__help\"></span></div></div>");
              });
              grand_total1 = subtotal - discount_amount + tax + other_total;

              let exchange_get = $("#exchange_rate1111").val();
              convertidr = grand_total1 * exchange_get;
              schedule_payment = JSON.parse(t.schedulepayment);
              dataSet = schedule_payment;

              _exchange_rate = exchange_get;

              $("#grand_totalrp").val(IDRformatter.format(convertidr));

              console.table({
                'subtotal' : subtotal,
                'discount_amount' : discount_amount,
                'tax' : tax,
                'grandtotal' : grand_total1,
                'other_total' : other_total,
                'exchange_get' : exchange_get
              });

              $("#sub_total_val").val(subtotal);
              $("#total_discount_val").val(discount_amount);
              $("#grand_total_val").val(grand_total1);
              $("#grand_totalrp_val").val(convertidr);
              $("#other_price_val").val(other_total);
              $("#htcrr_price_val").val(t.price);
              if (_currency == 'idr') {

                $("#sub_total").val(IDRformatter.format(subtotal));
                $("#total_discount").val(IDRformatter.format(discount_amount));
                $('.tax-symbol').html('Rp')
                $("#tax").val(addCommas(tax));
                $("#grand_total").val(IDRformatter.format(grand_total1));
                $("#grand_total_rupiah").val(IDRformatter.format(convertidr));
                $("#other_price").val(IDRformatter.format(other_total));

                let sp_show = "";
                $.each(schedule_payment, function (k, v) {
                  sp_show += "Work Progress " + v.work_progress + "% Invoice Payment " + IDRformatter.format(v.amount) + "\n";
                });
                $("#schedule_payment").html(sp_show);
                return (
                  IDRformatter.format(t.price) + "<br/>"
                );
              } else {
                $("#sub_total").val(ForeignFormatter.format(subtotal));
                $("#total_discount").val(ForeignFormatter.format(discount_amount));
                $('.tax-symbol').html('US$')
                $("#tax").val(addCommas(tax));
                $("#grand_total").val(ForeignFormatter.format(grand_total1));
                $("#grand_total_rupiah").val(ForeignFormatter.format(convertidr));

                let sp_show = "";
                $.each(schedule_payment, function (k, v) {
                  sp_show += "Work Progress " + v.work_progress + "% Invoice Payment " + ForeignFormatter.format(v.amount) + "\n";

                });
                $("#schedule_payment").html(sp_show);
                return (
                  ForeignFormatter.format(t.price) + "<br/>"
                );
              }

            } else if (t.priceother != null) {

              let _price_other = parseFloat(t.priceother) * _exchange_rate;
              subtotal = parseFloat(subtotal) + _price_other;

              let old_grandtotal = $("#grand_total_val").val();

              let new_grandtotal = parseFloat(old_grandtotal) + parseFloat(_price_other);
              let new_grandtotal_rp = new_grandtotal * _exchange_rate;

              $("#grand_total_val").val(new_grandtotal);
              $("#grand_totalrp_val").val(new_grandtotal_rp);
              $("#other_price_val").val(_price_other);

              // for display
              if (_currency != 'idr') { /* if currency not idr */
                $("#other_price").val(ForeignFormatter.format(_price_other));
                $("#grand_total").val(ForeignFormatter.format(new_grandtotal));
              }else{
                $("#other_price").val(IDRformatter.format(_price_other));
                $("#grand_total").val(IDRformatter.format(new_grandtotal));
              }

              $("#grand_totalrp").val(IDRformatter.format(new_grandtotal_rp));
              if (_currency == 'idr') {
                others_price = t.priceother;
                return (
                  "<br/>"
                );
              } else {
                others_price = t.priceother;
                return (
                  "<br/>"
                );
              }


            }

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
    data.append("pph", 10);
    data.append("pphvalue", tax);
    // data.append("scheduled_payment_amount", JSON.stringify(scheduled_payment_amount_array));
    // data.append("scheduled_payment_note", JSON.stringify(scheduled_payment_note_array));
    data.append("discount", $("#total_discount_val").val());
    data.append('attention', $("#attention option:selected").text());
    data.append('phone', $("#phone option:selected").text());
    data.append('fax', $("#fax option:selected").text());
    data.append('email', $("#email option:selected").text());
    data.append("subtotal", $("#sub_total_val").val());
    data.append("account", $('#coa').val());
    data.append("grand_total", $("#grand_total_val").val());
    data.append("grand_totalrp", $("#grand_totalrp_val").val());
    data.append("other_price", $("#other_price_val").val());
    data.append("htcrr_price", $("#htcrr_price_val").val());
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
    // data.append("ppnprice",ppn_price);
    // data.append(
    // 	"ppnprice",
    // 	$('#tax').val().split('.').join('')
    // );
    data.append("schedule_payment",$("#due_payment").val());
    data.append("otherprice",others_price);
    data.append("description", $('textarea#desc').val());

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