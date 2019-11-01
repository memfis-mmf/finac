<div class="modal fade" id="modal_create_supplier_invoice" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-supplier-invoice" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalSupplierInvoice">Supplier Invoice - Supplier Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover table-checkable" id="supplier_invoice_modal_datatable">
                    <thead>
                        <tr>
                            <th>Transaction No.</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>SI Type</th>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                            <th>Total Amount IDR</th>
                            <th>Account Code</th>
                            <th>Description</th>
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
