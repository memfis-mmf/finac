<div class="form-group m-form__group row ">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="form-group m-form__group row ">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            GRN Number
          </label>

          <select name="grnno" class="form-control">
            <option value=""></option>
            @if (@$asset->grnno)

            <option selected="selected" value="{{@$asset->grnno}}">
              {{@$asset->grn->number}}
            </option>

            @endif
          </select>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            Purchase Order Number
          </label>

          @component('input::text')
          @slot('id', 'purchase_order_number')
          @slot('text', 'Purchase Order Number')
          @slot('name', 'pono')
          @slot('value', $asset->pono)
          @slot('id_error', 'purchase_order_number')
          @endcomponent
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            Supplier Name
          </label>

          @component('input::text')
          @slot('id', 'supplier_name')
          @slot('text', 'supplier_name')
          @slot('name', 'supplier')
          @slot('value', $asset->supplier)
          @slot('id_error', 'supplier_name')
          @endcomponent
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            Asset Value @include('label::required')
          </label>

          @component('input::text')
          @slot('id', 'asset_value')
          @slot('text', 'Asset Value')
          @slot('name', 'povalue')
          @slot('value', $asset->povalue)
          @slot('id_error', 'asset_value')
          @endcomponent
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            Asset Account
          </label>

          @component('input::text')
          @slot('text', 'Asset Value')
          @slot('id', 'asset-account')
          @slot('value', $asset->type->coa->name . ' (' . $asset->type->coa->code . ')')
          @slot('disabled', 'disabled')
          @endcomponent
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="form-control-label">
            Expense Account @include('label::required')
          </label>
          <select name="coaexpense" class="form-control _accountcode">
            @if (@$asset->coaexpense)

            <option selected="selected" value="{{@$asset->coaexpense}}">
              {{@$asset->coa_expense->name.' ('.@$asset->coaexpense.')'}}
            </option>

            @endif
          </select>
        </div>
      </div>
    </div>
  </div>
</div>

@push('footer-scripts')
  <script>
    $(document).ready(function () {
      $('[name=grnno]').select2({
        placeholder: 'GRN Number',
        tags: 'true',
        width: '100%',
        ajax: {
          url: '{{ route("asset.select.grn") }}'
        }
      });

      $(document).on('change', '[name=grnno]', function () {
        let val = $(this).val();

        $.ajax({
          type: "get",
          url: "{{ route('asset.grn.info') }}/?grnno=" + val,
          dataType: "json",
          success: function (response) {
            if (response.status) {
              $('[name=pono]').val(response.purchase_order.number)
              $('[name=pono]').attr('readonly', 'readonly')

              $('[name=supplier]').val(response.purchase_order.vendor.full_name)
              $('[name=supplier]').attr('readonly', 'readonly')
            }
          }
        });
      });
    });
  </script>
@endpush