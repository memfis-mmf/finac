
<div class="form-group m-form__group row">
    <div class="col-sm-12 col-md-12 col-lg-12 text-right">
        @component('buttons::create-new')
            @slot('text', 'Item')
            @slot('data_target', '#item_modal')
        @endcomponent
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <table class="table table-striped table-bordered table-hover table-checkable item_list_datatable">
            <thead>
                <th>No</th>
                <th>Detail Information</th>
                <th>Status</th>
                <th>Evaluation Cost</th>
                <th>Full Package Cost</th>
                <th>Material Cost</th>
                <th>Discount</th>
                <th>Other Cost</th>
            </thead>
        </table>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <label class="form-control-label mt-3">
            Evaluation Cost Total
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'evaluation_cost_total')
            @slot('class', 'evaluation_cost_total')
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
            Full Package Cost Total
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'full_package_cost_total')
            @slot('class', 'full_package_cost_total')
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
            Discount Total
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'discount_total')
            @slot('class', 'discount_total')
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
            VAT 10% (Exclude)
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
            Other Cost Total
        </label>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        @component('input::number')
            @slot('id', 'other_cost_total')
            @slot('class', 'other_cost_total')
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

@include('invoice-workshop-servicedetailview::item')
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
    <script src="{{ asset('vendor/courier/frontend/invoice/invoice-workshop/index.js')}}"></script>
    <script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush