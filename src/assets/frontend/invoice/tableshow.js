let total = 0;
let total1 = 0;
var discount = 0;
let quotation = $('#quotation_uuid').val();

let exchange_rate = parseInt($('#exchange_rate').attr('value'));
// untuk datatable dengan accordion pada row tersebut
var DatatableAutoColumnHideDemo = function () {
  //== Private functions

  // basic demo
  var demo = function () {
    // var dataJSONArrayLong = JSON.parse('[{ "OrderID" : "OrderID","ShipCountry" : "ShipCountry","ShipCity" : "ShipCity","Currency" : "Currency","ShipDate" : "ShipDate", "Latitude" : "Latitude","Longitude" : "Longitude","Notes" : "Notes","Department" : "Department","Website" : "Website", "TotalPayment" : "TotalPayment","Status" : 1,"Type" : 1},{ "OrderID" : "OrderID","ShipCountry" : "ShipCountry","ShipCity" : "ShipCity","Currency" : "Currency","ShipDate" : "ShipDate", "Latitude" : "Latitude","Longitude" : "Longitude","Notes" : "Notes","Department" : "Department","Website" : "Website", "TotalPayment" : "TotalPayment","Status" : 1,"Type" : 1}]');
    let locale = 'id';
    let IDRformatter = new Intl.NumberFormat(locale, { style: 'currency', currency: 'idr', minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let ForeignFormatter = new Intl.NumberFormat(locale, { style: 'currency', currency: currencyCode, minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let numberFormat = new Intl.NumberFormat('id', { maximumSignificantDigits: 3, maximumFractionDigits: 2, minimumFractionDigits: 2 });

    $('.summary_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: '/invoice/quotation/table/modal/' + quotation_uuid + '/detail',
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
          width: '100px',
        }, {
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
                + "Material Need " + t.materialitem + " item(s)<br/>"
                + "Total " + t.total_manhours_with_performance_factor + " Manhours<br/>"
                + template

              );
            } else if (t.htcrrcount != null) {
              return (
                "&nbsp;&nbsp;&nbsp;&nbsp;HardTime TaskCard " + t.htcrrcount + " item(s)"

              );

            } else if (t.priceother != null) {
              return (
                "&nbsp;&nbsp;&nbsp;&nbsp;Others "

              );
            }

          }
        },
        {
          field: 'total',
          title: 'Total',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {
            if (t.htcrrcount == null && t.priceother == null) {
              if (currency.id == 1) {
                //temptotal = t.h1 + t.h2;
                temptotal = (t.total_manhours_with_performance_factor * t.manhour_rate_amount) + t.mat_tool_price;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount;
                facility_price += t.facilities_price_amount;
                material_price += t.mat_tool_price;
                subtotal += temptotal;
                //discount += t.discount;
                /*
                if(t.pivot.discount_type == 'amount'){
                  discount += t.pivot.discount_value;
                  }else {
                    if(t.pivot.discount_type == 'percentage') {
                    discount += temptotal * (t.pivot.discount_value/100);
                  }else{
                    discount += 0;
                  }
                }
                */
                if (t.discount_type == 'amount') {
                  discount += t.discount_value;
                } else {
                  if (t.discount_type == 'percentage') {
                    discount += subtotal * (t.discount_value / 100);
                  } else {
                    discount += 0;
                  }
                }

                $("#total_discount").attr("value", discount);
                return (
                  /*IDRformatter.format(t.h1) + "<br/>"
                  + IDRformatter.format(t.h2) + "<br/>"
                  */
                  IDRformatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + '<br>' +
                  IDRformatter.format(t.mat_tool_price) + '<br>'
                );
              } else {
                //temptotal = t.h1 + t.h2;
                temptotal = (t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + t.mat_tool_price;
                subtotal += temptotal;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount;
                facility_price += t.facilities_price_amount;
                material_price += t.mat_tool_price;
                if(t.pivot.discount_type == 'amount'){
                  discount += t.pivot.discount_value;
                  }else {
                    if(t.pivot.discount_type == 'percentage') {
                    discount += temptotal * (t.pivot.discount_value/100);
                  }else{
                    discount += 0;
                  }
                }
                /*
                if (t.discount_type == 'amount') {
                  discount += t.pivot.discount_value;
                } else {
                  if (t.pivot.discount_type == 'percentage') {
                    discount += temptotal * (t.pivot.discount_value / 100);
                  } else {
                    discount += 0;
                  }
                }
                */
                return (
                  /*
                  ForeignFormatter.format(t.h1) + "<br/>"
                  + ForeignFormatter.format(t.h2) + "<br/>"
                  */
                  ForeignFormatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + '<br>' +
                  //ForeignFormatter.format(a.facilities_price_amount) + '<br>' +
                  ForeignFormatter.format(t.mat_tool_price) + '<br>'
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
              grand_total1 = subtotal - discount + tax + other_total;
              let exchange_get = $("#exchange_rate1111").val();
              convertidr = grand_total1 * exchange_get;
              schedule_payment = JSON.parse(t.schedulepayment);
              dataSet = schedule_payment;
              console.log(t);
              console.log(schedule_payment);


              $("#grand_totalrp").attr("value", IDRformatter.format(convertidr));
              if (currency.id == 1) {
                subtotal += t.price;
                $("#grand_total_rupiah").attr("value", IDRformatter.format(subtotal));
                $("#sub_total").attr("value", IDRformatter.format(subtotal));
                $("#tax").attr("value", IDRformatterTax.format(tax));
                $("#grand_total").attr("value", IDRformatter.format(grand_total1));
                $("#total_discount").attr("value", IDRformatter.format(discount));
                let sp_show = "";
                $.each(schedule_payment, function (k, v) {
                  sp_show += "Work Progress " + v.work_progress + "% Invoice Payment " + IDRformatter.format(v.amount) + "\n";
                  //$("textarea#ExampleMessage").html(result.exampleMessage)

                });
                /*
                if (t.data_htcrr.discount_type == 'amount') {
                  discount += t.data_htcrr.discount_value;
                } else {
                  if (t.data_htcrr.discount_type == 'percentage') {
                    discount += temptotal * (t.data_htcrr.discount_value / 100);
                  } else {
                    discount += 0;
                  }
                }
                */
                console.log(discount);
                $("#schedule_payment").html(sp_show);
                return (
                  IDRformatter.format(t.price) + "<br/>"
                );
              } else {
                subtotal += t.price;
                $("#grand_total_rupiah").attr("value", ForeignFormatter.format(subtotal));
                $("#grand_total").attr("value", ForeignFormatter.format(grand_total1));
                $("#sub_total").attr("value", ForeignFormatter.format(subtotal));
                $("#tax").attr("value", ForeignFormatter.format(tax));
                $("#total_discount").attr("value", ForeignFormatter.format(discount));
                let sp_show = "";
                $.each(schedule_payment, function (k, v) {
                  sp_show += "Work Progress " + v.work_progress + "% Invoice Payment " + ForeignFormatter.format(v.amount) + "\n";
                  //$("textarea#ExampleMessage").html(result.exampleMessage)

                });
                /*
                if (t.data_htcrr.discount_type == 'amount') {
                  discount += t.data_htcrr.discount_value;
                } else {
                  if (t.data_htcrr.discount_type == 'percentage') {
                    discount += temptotal * (t.data_htcrr.discount_value / 100);
                  } else {
                    discount += 0;
                  }
                }
                console.log(t);
                console.log(t.data_htcrr);
                console.log(discount);
                $("#total_discount").attr("value", discount);
                */
                $("#schedule_payment").html(sp_show);
                return (
                  ForeignFormatter.format(t.price) + "<br/>"
                );
              }

            } else if (t.priceother != null) {
              subtotal += t.priceother;
              others_price += t.priceother;
              if (currency.id == 1) {
                others_price += t.priceother;
                return (
                  IDRformatter.format(t.priceother) + "<br/>"
                );
              } else {
                return (
                  ForeignFormatter.format(t.priceother) + "<br/>"
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
  uuidquo = $("#refquono").data('uuid');
  $("#actheader").attr("hidden", true);
  $("#hiddennext").removeAttr("hidden");
  DatatableAutoColumnHideDemo.init();

  //alert("The paragraph was clicked.");
  $("#pph").change(function () {
    console.log(this.value)
    let pph = subtotal - discount * (this.value / 100);
    let fixed = pph.toFixed(2);
    console.log(fixed);
    $("#percent").attr("value", fixed);
  });
  $('.action-buttons').on('click', '.edit-invoice', function () {
    //alert("test");

    // let type = $('#scheduled_payment_type').children("option:selected").html();

    // $('#scheduled_payment ').each(function (i) {
    //     scheduled_payment_amount_array[i] = parseInt($(this).val());
    // });

    // $('#scheduled_payment_note ').each(function (i) {
    //     scheduled_payment_note_array[i] = $(this).val();
    // });
    // scheduled_payment_array.pop();
    let data = new FormData();
    data.append("date", $('[name=date]').val());
    data.append("quotation", $('#refquono').val());
    data.append("currency", $('#currency').val());
    data.append("exchange_rate", $('#exchange_rate1111').val());
    data.append("bank", $("#bankinfo").val());
    data.append("pph", 10);
    data.append("pphvalue", tax);
    // data.append("scheduled_payment_amount", JSON.stringify(scheduled_payment_amount_array));
    // data.append("scheduled_payment_note", JSON.stringify(scheduled_payment_note_array));
    data.append("discount", discount);
    data.append("schedule_payment",$("#due_payment").val());
    data.append("subtotal", subtotal);
    data.append("account", $('#coa').val());
    data.append("grand_total", grand_total1);
    data.append("grand_totalrp", convertidr);
    data.append("description", $('textarea#desc').val());


    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      type: 'post',
      url: '/invoice/' + invoice_uuid + "/edit",
      processData: false,
      contentType: false,
      data: data,
      success: function (data) {
        if (data.errors) {
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

          toastr.success('Invoice has been updated.', 'Success', {
            timeOut: 5000
          });

          //window.location.href = '/invoice/';

        }
      }
    });
  });
  //DatatableAutoColumnHideDemo.init();
});
