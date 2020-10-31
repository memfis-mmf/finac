
@include('cashbookview::coamodal')
{{-- coa modal Depreciation --}}
<div class="modal fade" id="coa_modal_depreciation" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalBasic">Chart Of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hiderow" value="">
                <table class="table table-striped table-bordered table-hover table-checkable" id="coa_datatables_depreciation">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <div class="flex">
                    <div class="action-buttons">
                        <div class="flex">
                            <div class="action-buttons">
                                @component('frontend.common.buttons.close')
                                @slot('text', 'Close')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end coa modal Depreciation --}}
<div class="form-group m-form__group row ">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Depreciation Method
                </label>

                @component('label::data-info')
                    @slot('text', 'STRAIGHT LINE')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Salvage Value
                </label>

                @component('input::number')
                    @slot('id', 'salvage_value')
                    @slot('name', 'salvagevalue')
                    @slot('value', (@$asset->salvagevalue)? @$asset->salvagevalue: 0)
                    @slot('text', 'Salvage Value')
                    @slot('input_append', 'IDR')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Useful Life @include('label::required')
                </label>

                @component('input::number')
                    @slot('id', 'lifetime')
                    @slot('name', 'usefullife')
                    @slot('value', @$asset->usefullife)
                    @slot('text', 'Lifetime')
                    @slot('input_append', 'Month')
                @endcomponent
            </div>
            {{-- <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Depreciation Date
                </label>

                @component('input::datepicker')
                    @slot('id', 'daterange_depreciation_date')
                    @slot('name', 'daterange_depreciation_date')
                    @slot('id_error', 'daterange_depreciation_date')
                @endcomponent
            </div> --}}
        </div>
        {{-- <h4><b>Accumulate Depreciation Account</b> @include('label::required')</h4> --}}
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Accumulate Depreciation Account @include('label::required')
                </label>
                  {{-- @component('input::select2')
                      @slot('class', '_accountcode')
                      @slot('text', 'Account Code')
                      @slot('name', 'coaacumulated')
                      @slot('value', @$asset->coa_accumulate->name.'('.@$asset->coaacumulated.')')
                      @slot('id_error', 'accountcode')
                  @endcomponent --}}
                  <select name="coaacumulated" class="form-control _accountcode">
                    @if (@$asset->coaacumulated)

                      <option selected="selected" value="{{@$asset->coaacumulated}}">
                        {{@$asset->coa_accumulate->name.' ('.@$asset->coaacumulated.')'}}
                      </option>

                    @endif
                  </select>
                {{-- @component('input::inputrightbutton')
                    @slot('id', 'coa')
                    @slot('text', 'coa')
                    @slot('name', 'coaacumulated')
                    @slot('value', @$asset->coaacumulated)
                    @slot('type', 'text')
                    @slot('style', 'width:100%')
                    @slot('data_target', '#coa_modal')
                @endcomponent --}}
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Depreciation Account @include('label::required')
                </label>
                  {{-- @component('input::select2')
                      @slot('class', '_accountcode')
                      @slot('text', 'Account Code')
                      @slot('name', 'coadepreciation')
                      @slot('value', @$asset->coa_depreciation->name.'('.@$asset->coadepreciation.')')
                      @slot('id_error', 'accountcode')
                  @endcomponent --}}
                  <select name="coadepreciation" class="form-control _accountcode">
                    @if (@$asset->coadepreciation)

                      <option selected="selected" value="{{@$asset->coadepreciation}}">
                        {{@$asset->coa_depreciation->name.' ('.@$asset->coadepreciation.')'}}
                      </option>

                    @endif
                  </select>
                {{-- @component('input::inputrightbutton')
                    @slot('id', 'coa_a')
                    @slot('text', 'coa')
                    @slot('name', 'coadepreciation')
                    @slot('value', @$asset->coadepreciation)
                    @slot('type', 'text')
                    @slot('style', 'width:100%')
                    @slot('data_target', '#coa_modal_depreciation')
                @endcomponent --}}
            </div>
        </div>
        {{-- <h4><b></b> @include('label::required')</h4> --}}
    </div>
</div>

<input hidden id="coaid">
@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faAsset";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
  <script src="{{ asset('vendor/courier/frontend/functions/daterange/master-asset-dep.js')}}"></script>

  {{-- <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script> --}}

  {{-- <script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script> --}}

  <script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

	<script type="text/javascript">
		$(document).ready(function() {
      let _url = window.location.origin;

      // select 2 aja for coa
			$('._accountcode').select2({
        placeholder: '--Select--',
			  ajax: {
			    url: _url+'/journal/get-account-code-select2',
          dataType: 'json',
			  },
        width: '100%',
				minimumInputLength: 3,
				// templateSelection: formatSelected
			});

      // coa datatable
      $("#coa_datatables").DataTable({
          "dom": '<"top"f>rt<"bottom">pl',
          responsive: !0,
          searchDelay: 500,
          processing: !0,
          serverSide: !0,
          lengthMenu: [5, 10, 25, 50],
          pageLength: 5,
          ajax: "/coa/datatables/modal",
          columns: [
              {
                  data: 'code'
              },
              {
                  data: "name"
              },
              {
                  data: "Actions"
              }
          ],
          columnDefs: [{
              targets: -1,
              orderable: !1,
              render: function (a, e, t, n) {
                  return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
              }
          },

          ]
      })

      $("#coa_datatables_depreciation").DataTable({
          "dom": '<"top"f>rt<"bottom">pl',
          responsive: !0,
          searchDelay: 500,
          processing: !0,
          serverSide: !0,
          lengthMenu: [5, 10, 25, 50],
          pageLength: 5,
          ajax: "/coa/datatables/modal",
          columns: [
              {
                  data: 'code'
              },
              {
                  data: "name"
              },
              {
                  data: "Actions"
              }
          ],
          columnDefs: [{
              targets: -1,
              orderable: !1,
              render: function (a, e, t, n) {
                  return '<a id="userow" class="btn btn-primary btn-sm m-btn--hover-brand select-coa" title="View" data-id="" data-uuid="' + t.uuid + '">\n<span><i class="la la-edit"></i><span>Use</span></span></a>'
              }
          },

          ]
      })

			// coa modal
      $('#coa_datatables').on('click', '.select-coa', function () {
          var code = $(this).data('uuid');
          var dataid = document.getElementById('hiderow').value;
          console.log(dataid);
          console.log(code);
          $.ajax({
              url: '/coa/data/' + code,
              type: 'GET',
              dataType: 'json',
              success: function (data) {

                  var idtest = "code"+dataid;
                  var nametest = "name"+dataid;
                  if(dataid == null || dataid == "" || dataid == undefined){
                      console.log(data);
                      document.getElementById('coa').value = data.code;
                      document.getElementById('coaid').value = data.id;
                      //console.log(document.getElementById('coaid').value);
                      document.getElementById('acd').value = data.name;
                      document.getElementById('hiderow').value = "";
                  } else {
                      console.log(dataid);
                      document.getElementById(idtest).value = data.code;
                      var coadynac = "id"+idtest;
                      document.getElementById(nametest).value = data.name;
                      document.getElementById(coadynac).value = data.id;
                      document.getElementById('hiderow').value = "";
                  }

                  $('#coa_modal').modal('hide');
              }
          });
      });

			// coa modal depreciation
      $('#coa_datatables_depreciation').on('click', '.select-coa', function () {
          var code = $(this).data('uuid');
          var dataid = document.getElementById('hiderow').value;
          console.log(dataid);
          console.log(code);
          $.ajax({
              url: '/coa/data/' + code,
              type: 'GET',
              dataType: 'json',
              success: function (data) {

                  var idtest = "code"+dataid;
                  var nametest = "name"+dataid;
                  if(dataid == null || dataid == "" || dataid == undefined){
                      console.log(data);
                      document.getElementById('coa_a').value = data.code;
                      //console.log(document.getElementById('coaid').value);
                      document.getElementById('acd_a').value = data.name;
                      document.getElementById('hiderow').value = "";
                  } else {
                      console.log(dataid);
                      document.getElementById(idtest).value = data.code;
                      var coadynac = "id"+idtest;
                      document.getElementById(nametest).value = data.name;
                      document.getElementById(coadynac).value = data.id;
                      document.getElementById('hiderow').value = "";
                  }

                  $('#coa_modal_depreciation').modal('hide');
              }
          });
      });

		})
	</script>
@endpush
