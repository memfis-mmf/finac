<div class="modal fade" id="modal_create_grn" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-supplier-invoice" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalSupplierInvoice">GRN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-5">
                    <div class="col-md-3">
                        {{-- <div class="m-input-icon m-input-icon--left">
                                <input type="text" class="form-control m-input" placeholder="Search..."
                                        id="generalSearch">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                </span>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable grn_modal_datatable">
                            <thead class="text-center">
                                <tr>
                                    <th>Transaction No</th>
                                    <th>SI Transaction No</th>
                                    <th>Due Date</th>
                                    <th>Exchange Rate</th>
                                    <th>Total Amount</th>
                                    <th>Total Amount (IDR)</th>
                                    <th>Paid Amount</th>
                                    <th>Account Code</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
