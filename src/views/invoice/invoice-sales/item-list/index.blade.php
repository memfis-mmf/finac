<div class="form-group m-form__group row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <table class="table table-striped table-bordered table-hover table-checkable item_list_datatable">
            <thead>
                <th>No</th>
                <th>Part Number</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Price List</th>
                <th>Unit Price</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Remark</th>
            </thead>
        </table>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Subtotal
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'subtotal')
            @slot('class', 'subtotal')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Total Discount
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'total_discount')
            @slot('class', 'total_discount')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            VAT 10%
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'vat')
            @slot('class', 'vat')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Other Cost
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'other_cost')
            @slot('class', 'other_cost')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Grand Total
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'grand_total')
            @slot('class', 'grand_total')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Grand Total IDR
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'grand_total_idr')
            @slot('class', 'grand_total_idr')
            @slot('text', '')
            @slot('value', '')
        @endcomponent
    </div>
</div>

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faAR";
            }
        });
    </script>
    <script src="{{ asset('vendor/courier/frontend/invoice/item-list.js')}}"></script>
@endpush