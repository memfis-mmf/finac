<div class="form-group m-form__group row ">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Manufacture Name
                </label>

                @component('input::text')
                    @slot('id', 'manufacture_name')
                    @slot('text', 'Manufacture Name')
                    @slot('name', 'manufacturername')
                    @slot('id_error', 'manufacture_name')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Production Date
                </label>

                @component('input::datepicker')
                    @slot('id', 'date')
                    @slot('name', 'productiondate')
                    @slot('text', 'Production Date')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Brand Name
                </label>

                @component('input::text')
                    @slot('id', 'brand_name')
                    @slot('text', 'Brand Name')
                    @slot('name', 'brandname')
                    @slot('id_error', 'brand_name')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Warranty
                </label>

								{{-- Warrantystart warranty end --}}
                @component('input::datepicker')
                    @slot('id', 'daterange_master_asset')
                    @slot('name', 'daterange_master_asset')
                    @slot('id_error', 'daterange_master_asset')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Model/Type
                </label>

                @component('input::text')
                    @slot('id', 'model_type')
                    @slot('text', 'Model Type')
                    @slot('name', 'modeltype')
                    @slot('id_error', 'model_type')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Location
                </label>

                @component('input::text')
                    @slot('id', 'location')
                    @slot('name', 'location')
                    @slot('text', 'Location')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Serial Number
                </label>

                @component('input::text')
                    @slot('id', 'serial_number')
                    @slot('text', 'Serial Number')
                    @slot('name', 'serialno')
                    @slot('id_error', 'serial_number')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Department
                </label>

                @component('input::select')
                    @slot('id', 'department')
                    @slot('name', 'company_department')
                    @slot('text', 'Department')
                @endcomponent
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/department.js')}}"></script>

    <script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/daterange/master-asset-gi.js')}}"></script>
@endpush
