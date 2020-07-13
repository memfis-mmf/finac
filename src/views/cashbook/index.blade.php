@extends('frontend.master')

@section('faCashbook', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook's
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
                            Cashbook
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

                            @include('label::datalist')

                            <h3 class="m-portlet__head-text">
                                Cashbook
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-8 order-2 order-xl-1">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-4">
                                            <div class="m-input-icon m-input-icon--left">
                                                <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <div class="dropdown">
                                        <button class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-{{ $color or 'primary' }} btn-{{ $size or 'md' }} {{ $class or '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span>
                                                <i class="la la-{{ $icon or 'plus-circle'}}"></i>
                                                <span>{{ $text or 'Add Cashbook' }}</span>
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('cashbook-bpj.create')}}">Bank Payment Journal</a>
                                            <a class="dropdown-item" href="{{route('cashbook-brj.create')}}">Bank Receipt Journal</a>
                                            <a class="dropdown-item" href="{{route('cashbook-cpj.create')}}">Cash Payment Journal</a>
                                            <a class="dropdown-item" href="{{route('cashbook-crj.create')}}">Cash Receipt Journal</a>
                                        </div>
                                    </div>

                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>

                        @include('cashbookview::modal')
                        @include('cashbookview::approvemodal')

                        <div class="cashbook_datatable" id="scrolling_both"></div>
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
                window.location.href=currentUrl+"#faCashbook";
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/type.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/type.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/cashbook.js')}}"></script>
<script>
$(document).on("click", ".open-AddUuidApproveDialog", function () {
     var uuid = $(this).data('uuid');
     //console.log(uuid);
     $(".modal-body #uuid-approve").val(uuid);
     // As pointed out in comments, 
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
</script>
@endpush