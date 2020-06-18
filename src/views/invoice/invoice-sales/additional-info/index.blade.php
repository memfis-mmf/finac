<div class="form-group m-form__group row ">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <label class="form-control-label">
            Term & Condition
        </label>

        @component('input::textarea')
            @slot('id', 'term_condition')
            @slot('text', 'Term & Condition')
            @slot('name', 'term_condition')
            @slot('rows','9')
        @endcomponent
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group m-form__group row ">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Term & Payment
                </label>
        
                @component('input::number')
                    @slot('id', 'term_payment')
                    @slot('text', 'Term & Payment')
                    @slot('name', 'term_payment')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Due Date
                </label>
        
                @component('input::datepicker')
                    @slot('id', 'valid_until')
                    @slot('text', 'Due Date')
                    @slot('name', 'valid_until')
                    @slot('id_error', 'valid_until')
                @endcomponent
            </div>
        </div>
        <div class="form-group m-form__group row ">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-control-label">
                    Location
                </label>
            
                <select class="_select2 form-control" name="location" style="width:100%">
                    <option value=""></option>
                    <option value="sidoarjo">Sidoarjo</option>
                    <option value="surabaya">Surabaya</option>
                    <option value="jakarta">Jakarta</option>
                    <option value="biak">Biak</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="form-group m-form__group row ">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <label class="form-control-label">
            Remark
        </label>

        @component('input::textarea')
            @slot('id', 'remark')
            @slot('text', 'Remark')
            @slot('name', 'remark')
            @slot('rows','5')
        @endcomponent
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <label class="form-control-label">
            Delivery Address
        </label>

        @component('input::input')
            @slot('id', 'delivery_address')
            @slot('text', 'Delivery Address')
            @slot('name', 'delivery_address')
        @endcomponent
    </div>
</div>  
