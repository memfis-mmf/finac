<div class="modal fade" id="modal_edit_invoice" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TitleModalSupplierInvoice">Supplier Invoice - Amount to Pay</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
          id="SupplierInvoiceForm">
          <input type="hidden" name="invoice_uuid" value="" disabled>
          <div class="m-portlet__body">
            <div class="form-group m-form__group row ">
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Date
                </label>

                <input type="text" class="form-control iv_date" disabled>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Transaction No.
                </label>

                <input type="text" class="form-control iv_transactionnumber" disabled>
              </div>
            </div>
            <div class="form-group m-form__group row ">
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Account Code
                </label>

                <input type="text" class="form-control iv_code" disabled>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group m-form__group row ">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Currency
                    </label>

                    <input type="text" class="form-control iv_currency" disabled>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Exchange Rate
                    </label>

                    <input type="text" class="form-control iv_exchangerate" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group m-form__group row ">
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Total Amount
                </label>

                <input type="text" class="form-control iv_total_amount" disabled>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Paid Amount
                </label>

                <input type="text" class="form-control iv_paid_amount" disabled>
              </div>
            </div>
            <div class="form-group m-form__group row ">
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Amount to Pay
                </label>

                <div class="input-group">

                  <div class="input-group-prepend">
                    <span class="input-group-text atp_symbol"></span>
                  </div>
                  <input type="number" id="amount_to_pay" name="credit" class="form-control m-input" style="" value=""
                    placeholder="" min="" max="">

                </div>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                  Exchange Rate Gap
                </label>

                <input type="text" class="form-control iv_exchangerate_gap" disabled>
              </div>
            </div>
            <div class="form-group m-form__group row ">
              <div class="col-md-12">
                <input type="checkbox" name="is_clearing">

                <label class="form-control-label">
                  Clearing
                </label>
              </div>
            </div>
            <div class="form-group m-form__group row ">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-control-label">
                  Description
                </label>

                @component('input::textarea')
                @slot('id', 'description')
                @slot('text', 'description')
                @slot('name', 'description')
                @slot('rows','5')
                @endcomponent
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="flex">
              <div class="action-buttons">
                <div class="flex">
                  <div class="action-buttons">
                    @component('buttons::submit')
                    @slot('id', 'update_invoice')
                    @slot('type', 'button')
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
</div>