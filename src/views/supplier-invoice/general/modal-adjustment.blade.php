<div class="modal fade" id="modal_si_adj">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TitleModalJournal">Adjustment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ $action }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Account Code</label>
            <select name="coa_id" class="form-control" data-url="{{ route('trxpayment.adjustment.select2-coa') }}">
              <option value=""></option>
              @if (isset($data))
                <option value="{{ $data->coa->id }}">{{ "{$data->coa->name} ({$data->coa->code})" }}</option>
              @endif
            </select>
          </div>

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label for="">Debit</label>
                <input class="form-control" type="number" name="debit" value="{{ $data->debit ?? '' }}">
              </div>

            </div>

            <div class="col-md-6">
              
              <div class="form-group">
                <label for="">Credit</label>
                <input class="form-control" type="number" name="credit" value="{{ $data->credit ?? '' }}">
              </div>

            </div>
          </div>

          <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control">{{ $data->description ?? ''}}</textarea>
          </div>
        </div>
        <div class="modal-footer">

          <div class="flex">
            <div class="action-buttons">
              <div class="flex">
                <div class="action-buttons">
                  @component('buttons::submit')
                  @slot('id', 'submit_supplier_invoice_adj')
                  @endcomponent

                  @include('buttons::reset')

                  @include('buttons::close')
                </div>
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('select[name=coa_id]').select2({
    placeholder: '-- Select --',
    width: '100%',
    ajax: {
      url: $('select[name=coa_id]').data('url')
    }
  });
</script>