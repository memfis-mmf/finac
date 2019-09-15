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
    console.log(currencyCode);
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
            if (t.htcrrcount == null) {
              if (currency.id == 1) {
                temptotal = t.h1 + t.h2;
                subtotal += temptotal;
                discount += t.discount;
                console.log(t.discount);
                console.log(discount);
                $("#total_discount").attr("value", discount);
                return (
                  IDRformatter.format(t.h1) + "<br/>"
                  + IDRformatter.format(t.h2) + "<br/>"
                );
              } else {
                temptotal = t.h1 + t.h2;
                subtotal += temptotal;
                discount += t.discount;
                console.log(t.discount);
                console.log(discount);
                $("#total_discount").attr("value", discount);
                return (
                  ForeignFormatter.format(t.h1) + "<br/>"
                  + ForeignFormatter.format(t.h2) + "<br/>"
                );
              }
            } else {
              if (currency.id == 1) {
                subtotal += t.price;
                $("#grand_total_rupiah").attr("value", subtotal);
                $("#sub_total").attr("value", subtotal);
                $("#total_discount").attr("value", discount);
                return (
                  IDRformatter.format(t.price) + "<br/>"
                );
              } else {
                subtotal += t.price;
                $("#grand_total_rupiah").attr("value", subtotal);
                $("#sub_total").attr("value", subtotal);
                $("#total_discount").attr("value", discount);
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
    console.log(uuidquo);
    $("#hiddennext").removeAttr("hidden");
    DatatableAutoColumnHideDemo.init();
    //alert("The paragraph was clicked.");
  });
  //DatatableAutoColumnHideDemo.init();
});