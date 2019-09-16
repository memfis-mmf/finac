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
          width: '100px',
        }, {
          field: 'description',
          title: 'Detail',
          width: '700px',

          template: function (t) {
            if (t.htcrrcount == null) {
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
            } else {
              return (
                "&nbsp;&nbsp;&nbsp;&nbsp;HardTime TaskCard " + t.htcrrcount + " item(s)"

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
            if (t.htcrrcount == null && t.other == null) {

              if (currency.id == 1) {
                temptotal = t.h1 + t.h2;
                subtotal += temptotal;
                discount += t.discount;
                $("#total_discount").attr("value", discount);
                return (
                  IDRformatter.format(t.h1) + "<br/>"
                  + IDRformatter.format(t.h2) + "<br/>"
                );
              } else {
                temptotal = t.h1 + t.h2;
                subtotal += temptotal;
                discount += t.discount;
                $("#total_discount").attr("value", discount);
                return (
                  ForeignFormatter.format(t.h1) + "<br/>"
                  + ForeignFormatter.format(t.h2) + "<br/>"
                );
              }
            } else {
              tipetax = t.tax_type;
              console.log(tipetax);
              if (tipetax == "include") {
                tax = (subtotal - discount) / 1.1;
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


              $("#grand_totalrp").attr("value", IDRformatter.format(convertidr));
              if (currency.id == 1) {
                subtotal += t.price;
                $("#grand_total_rupiah").attr("value", IDRformatter.format(subtotal));
                $("#sub_total").attr("value", IDRformatter.format(subtotal));
                $("#tax").attr("value", IDRformatter.format(tax));
                $("#grand_total").attr("value", IDRformatter.format(grand_total1));
                $("#total_discount").attr("value", IDRformatter.format(discount));
                let sp_show = "";
                $.each(schedule_payment, function (k, v) {
                  sp_show += "Work Progress " + v.work_progress + "% Invoice Payment " + IDRformatter.format(v.amount) + "\n";
                  //$("textarea#ExampleMessage").html(result.exampleMessage)

                });
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
                $("#schedule_payment").html(sp_show);
                return (
                  ForeignFormatter.format(t.price) + "<br/>"
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
    $("#actheader").attr("hidden",true);
    $("#hiddennext").removeAttr("hidden");
    DatatableAutoColumnHideDemo.init();

    //alert("The paragraph was clicked.");
  });
  $("#pph").change(function () {
    console.log(this.value)
    let pph = subtotal - discount * (this.value / 100);
    let fixed = pph.toFixed(2);
    console.log(fixed);
    $("#percent").attr("value", fixed);
  });
  $('.action-buttons').on('click', '.add-invoice', function () {
    alert("test");
    
    // let type = $('#scheduled_payment_type').children("option:selected").html();

    // $('#scheduled_payment ').each(function (i) {
    //     scheduled_payment_amount_array[i] = parseInt($(this).val());
    // });

    // $('#scheduled_payment_note ').each(function (i) {
    //     scheduled_payment_note_array[i] = $(this).val();
    // });
    // scheduled_payment_array.pop();
    let data = new FormData();
    data.append("quotation", $('#refquono').val());
    data.append("currency", $('#currency').val());
    data.append("exchange_rate", $('#exchange_rate1111').val());
    data.append("bank", $( "#bankinfo option:selected" ).text());
    data.append("pph", $('#pph').val());
    data.append("pphvalue", $('#percent').val());
    // data.append("scheduled_payment_amount", JSON.stringify(scheduled_payment_amount_array));
    // data.append("scheduled_payment_note", JSON.stringify(scheduled_payment_note_array));
    data.append("discount", discount);
    data.append("subtotal", subtotal);
    data.append("account", $('#coa').val());
    data.append("grand_total", grand_total1);
    data.append("grand_totalrp", convertidr);
    

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