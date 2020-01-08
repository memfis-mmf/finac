
@include('cashbookview::coamodal')
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
                    Salvage Value @include('label::required')
                </label>

                @component('input::number')
                    @slot('id', 'salvage_value')
                    @slot('name', 'salvage_value')
                    @slot('text', 'Salvage Value')
                    @slot('input_append', 'IDR')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Lifetime @include('label::required')
                </label>

                @component('input::number')
                    @slot('id', 'lifetime')
                    @slot('name', 'lifetime')
                    @slot('text', 'Lifetime')
                    @slot('input_append', 'Month')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Depreciation Date
                </label>

                @component('input::datepicker')
                    @slot('id', 'daterange_depreciation_date')
                    @slot('name', 'daterange_depreciation_date')
                    @slot('id_error', 'daterange_depreciation_date')
                @endcomponent
            </div>
        </div>
        <h4><b>Accumulate Depreciation Account</b> @include('label::required')</h4>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Account Code 
                </label>

                @component('input::inputrightbutton')
                    @slot('id', 'coa')
                    @slot('text', 'coa')
                    @slot('name', 'coa')
                    @slot('type', 'text')
                    @slot('style', 'width:100%')
                    @slot('data_target', '#coa_modal')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Account Code Name
                </label>

                @component('input::inputreadonly')
                @slot('id', 'acd')
                @slot('text', 'acd')
                @slot('name', 'acd')
                @endcomponent
            </div>
        </div>
        <h4><b>Depreciation Account</b> @include('label::required')</h4>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Account Code
                </label>

                @component('input::inputrightbutton')
                    @slot('id', 'coa')
                    @slot('text', 'coa')
                    @slot('name', 'coa')
                    @slot('type', 'text')
                    @slot('style', 'width:100%')
                    @slot('data_target', '#coa_modal')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Account Code Name
                </label>

                @component('input::inputreadonly')
                @slot('id', 'acd')
                @slot('text', 'acd')
                @slot('name', 'acd')
                @endcomponent
            </div>
        </div>
    </div>
</div>

<input hidden id="coaid">
@push('footer-scripts')
    <script src="{{ asset('vendor/courier/frontend/functions/daterange/master-asset-dep.js')}}"></script>

    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>

    <script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>

    <script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
