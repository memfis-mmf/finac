@extends('frontend.master')

@section('faAsset', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Master Asset
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="#" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Master Asset
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @include('label::create-new')

                            <h3 class="m-portlet__head-text">
                                Master Asset
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="MasterAssetForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    {{-- <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Master Asset Code @include('label::required')
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'code')
                                            @slot('text', 'Master Asset Code')
                                            @slot('name', 'code')
                                            @slot('id_error', 'code')
                                        @endcomponent
                                    </div> --}}
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Asset Category @include('label::required')
                                        </label>

	                                      <select id="asset_category_id" name="asset_category_id" class="form-control _select2" style="width:100%">
	                                          <option value=""></option>

	                                          @foreach ($asset_categories as $category)
                                              <option value="{{ $category->id }}">
	                                              {{ $category->name }}
                                              </option>
	                                          @endforeach
	                                      </select>

                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Master Asset Name @include('label::required')
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'name')
                                            @slot('text', 'Master Asset Name')
                                            @slot('name', 'name')
                                            @slot('id_error', 'name')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Description
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'description')
                                            @slot('text', 'Description')
                                            @slot('name', 'description')
                                            @slot('rows','5')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','master_asset_save')
                                            @endcomponent

                                            @include('buttons::reset')

                                            @include('buttons::back')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faAsset";
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/master-asset/create.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('._select2').select2({
			'placeholder' : '-- Select --'
		});
	});
</script>
@endpush
