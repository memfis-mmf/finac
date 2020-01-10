let AssetCategory = {
    init: function () {

			let _url = window.location.origin;

      let asset_category_datatable = $('.asset_category_datatable').mDatatable({
          data: {
              type: 'remote',
              source: {
                  read: {
                      method: 'GET',
                      url: `${_url}/typeasset/datatables`,
                      map: function (raw) {
                          let dataSet = raw;

                          if (typeof raw.data !== 'undefined') {
                              dataSet = raw.data;
                          }

                          return dataSet;
                      }
                  }
              },
              pageSize: 10,
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
                  title: 'Category Code',
                  sortable: 'asc',
                  filterable: !1,
                  width: 60
              },
              {
                  field: 'name',
                  title: 'Category Name',
                  sortable: 'asc',
                  filterable: !1,
                  width: 150
              },
              {
                  field: 'usefullife',
                  title: 'Useful Life',
                  sortable: 'asc',
                  filterable: !1,
                  width: 60,
              },
              {
                  field: 'accountcode',
                  title: 'Coa Asset',
                  sortable: 'asc',
                  filterable: !1,
                  width: 150
              },
              {
                  field: 'created_by.name',
                  title: 'Created By',
                  sortable: 'asc',
                  filterable: !1,
                  width: 150
              },
              {
                  field: 'Actions',
                  width: 110,
                  title: 'Actions',
                  sortable: !1,
                  overflow: 'visible',
                  template: function (t, e, i) {

										let _html = '';

										if (!t.approve) {
											_html +=
                        '<a href="'+_url+'/typeasset/'+t.uuid+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" title="Edit" data-uuid=' +
                        t.uuid +
                        '>\t\t\t\t\t\t\t<i class="la la-pencil"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t' +
                        '\t\t\t\t\t\t\t<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" href="#" data-uuid=' +
                        t.uuid +
                        ' title="Delete"><i class="la la-trash"></i> </a>\t\t\t\t\t\t\t';
										}

                    return (_html);
                  }
              }
          ]
      });

      let remove = $('.asset_category_datatable').on('click', '.delete', function () {
          let triggerid = $(this).data('uuid');

          swal({
              title: 'Sure want to remove?',
              type: 'question',
              confirmButtonText: 'Yes, REMOVE',
              confirmButtonColor: '#d33',
              cancelButtonText: 'Cancel',
              showCancelButton: true,
          }).then(result => {
              if (result.value) {

                  $.ajax({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                              'content'
                          )
                      },
                      type: 'DELETE',
                      url: '/typeasset/' + triggerid + '',
                      success: function (data) {
                          toastr.success('AR has been deleted.', 'Deleted', {
                                  timeOut: 5000
                              }
                          );

                          asset_category_datatable.reload();
                      },
                      error: function (jqXhr, json, errorThrown) {
                          let errorsHtml = '';
                          let errors = jqXhr.responseJSON;

                          $.each(errors.errors, function (index, value) {
                              $('#delete-error').html(value);
                          });
                      }
                  });
              }
          });
      });
    }
};

jQuery(document).ready(function () {
    AssetCategory.init();
});
