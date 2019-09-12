
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
            return (
              "<b>" + t.description + "</b><br/>"
              +"Material Need "+t.materialitem+" item(s)<br/>"
              +"Total "+t.total_manhours_with_performance_factor+" Manhours<br/>"
              +"&nbsp;&nbsp;&nbsp;&nbsp;1.Basic TaskCard "+t.basic+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;2.SIP TaskCard "+t.sip+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;3.CPCP TaskCard "+t.cpcp+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;4.AD/SB TaskCard "+t.adsb+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;5.CMR/AWL TaskCard "+t.cmrawl+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;6.EO TaskCard "+t.eo+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;7.EA TaskCard "+t.ea+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;8.SI TaskCard "+t.si+" item(s)<br/>&nbsp;&nbsp;&nbsp;&nbsp;9.HardTime TaskCard "+t.hardtime+" item(s)<br/>"

            );
          }
        },
        {
          field: 'total',
          title: 'Total',
          sortable: 'asc',
          filterable: !1,
          template: function (t, e, i) {
            total = 0;
            if (t.pivot.discount_value == null && t.pivot.discount_type == null) {
              total = t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount + t.facilities_price_amount + t.mat_tool_price;
              subtotal = subtotal + total;
            }
            else {
              if (t.pivot.discount_type == 'amount') {
                total = t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount + t.facilities_price_amount + t.mat_tool_price;
                subtotal = subtotal + total;

              }
              else if (t.pivot.discount_type == 'percentage') {
                total = t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount + t.facilities_price_amount + t.mat_tool_price;
                subtotal = subtotal + total;
              }
            }

            if (currency.id == 1) {
              $("#grand_total_rupiah").attr("value", subtotal);
              $("#sub_total").attr("value", subtotal);
              return (
                IDRformatter.format(total)
              );
            } else {

              return (
                ForeignFormatter.format(total)
              );
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