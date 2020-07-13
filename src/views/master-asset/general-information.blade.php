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
                    @slot('value', $asset->manufacturername)
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
                    @slot('value', $asset->productiondate)
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
                    @slot('value', $asset->brandname)
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
                    @slot('value', $asset->warrantystart.'-'.$asset->warrantyend)
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
                    @slot('value', $asset->modeltype)
                    @slot('id_error', 'model_type')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Location
                </label>

								<select class="form-control _select2" name="location" style="width:100%">
									<option value=""></option>
									<option value="sidoarjo" {{(strtolower($asset->location) == 'sidoarjo')? 'selected': ''}}>Sidoarjo</option>
									<option value="surabaya" {{(strtolower($asset->location) == 'surabaya')? 'selected': ''}}>Surabaya</option>
									<option value="jakarta" {{(strtolower($asset->location) == 'jakarta')? 'selected': ''}}>Jakarta</option>
									<option value="biak" {{(strtolower($asset->location) == 'biak')? 'selected': ''}}>Biak</option>
								</select>
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
                    @slot('value', $asset->serialno)
                    @slot('id_error', 'serial_number')
                @endcomponent
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-control-label">
                    Department
                </label>

								<select id="department" class="form-control" name="company_department" style="width:100%">
									<option value=""></option>
									@for ($a=0; $a < count($company); $a++)
										@php
											$x = $company[$a]
										@endphp
										<option value="{{$x->name}}" {{(@$asset->company_department == $x->name)? 'selected': ''}}>{{$x->name}}</option>
									@endfor
								</select>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faAsset";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
    <script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>
    {{-- <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/department.js')}}"></script> --}}

    <script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/daterange/master-asset-gi.js')}}"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('._select2').select2({
					placeholder : '-- Select --'
				});
			});
		</script>
@endpush
