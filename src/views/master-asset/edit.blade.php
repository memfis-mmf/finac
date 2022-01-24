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

                            @include('label::edit')

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
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Asset Category @include('label::required')
                                        </label>

																				<select id="asset_category_id" name="group" class="form-control m-select2" disabled>
																						@foreach ($type_asset as $x)
																								<option value="{{ $x->id }}" @if ($x->id == $asset->asset_category_id) selected @endif>
																										{{ $x->name }}
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
                                            @slot('value', $asset->name)
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
                                            @slot('value', $asset->description)
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link active" data-toggle="tab" id="m_tab_6_1" href="#m_tabs_6_1" role="tab">
                                                    <i class="la la-cog"></i> General Information
                                                </a>
                                            </li>
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_2" href="#m_tabs_6_2" role="tab">
                                                    <i class="la la-briefcase"></i> Purchase Information
                                                </a>
                                            </li>
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_3" href="#m_tabs_6_3" role="tab">
                                                    <i class="la la-briefcase"></i> Depreciation
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                                @include('masterassetview::general-information')
                                            </div>
                                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                                @include('masterassetview::purchase-information')
                                            </div>
                                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                                @include('masterassetview::depreciation')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (@$page != 'show')
                                  <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','master_asset_save')
                                                @slot('data_uuid', Request::segment(2))
                                            @endcomponent

                                            @include('buttons::reset')

                                            @include('buttons::back')
                                        </div>
                                    </div>
                                  </div>   
                                @endif
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
    } else {
      window.location.href=currentUrl;
    }

    if ('{{@$page}}' == 'show') {
      $('input, textarea, select').attr('disabled', 'disabled');
    }    
  });
</script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/asset-category.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/master-asset/edit.js')}}"></script>
@endpush
