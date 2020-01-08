<div class="form-group m-form__group row ">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    GRN Number
                </label>

                @component('input::text')
                    @slot('id', 'grn_number')
                    @slot('text', 'GRN Number')
                    @slot('name', 'grn_number')
                    @slot('id_error', 'grn_number')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Quantity
                </label>

                @component('input::number')
                    @slot('id', 'qty')
                    @slot('text', 'Quantity')
                    @slot('name', 'qty')
                    @slot('id_error', 'qty')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Purchase Order Number
                </label>

                @component('input::text')
                    @slot('id', 'purchase_order_number')
                    @slot('text', 'Purchase Order Number')
                    @slot('name', 'purchase_order_number')
                    @slot('id_error', 'purchase_order_number')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Supplier Name
                </label>

                @component('input::text')
                    @slot('id', 'supplier_name')
                    @slot('text', 'supplier_name')
                    @slot('name', 'supplier_name')
                    @slot('id_error', 'supplier_name')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Asset Value
                </label>

                @component('input::text')
                    @slot('id', 'asset_value')
                    @slot('text', 'Asset Value')
                    @slot('name', 'asset_value')
                    @slot('id_error', 'asset_value')
                @endcomponent
            </div>
        </div>
    </div>
</div>
