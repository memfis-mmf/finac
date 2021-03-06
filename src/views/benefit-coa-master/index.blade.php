@extends('frontend.master')

@section('faBenefitCoaMaster', 'm-menu__item--active')
@section('content')
<style>
  .dataTables_paginate a{
      padding: 0 10px;
  }
  .dataTables_info{
      margin-top:-10px;
      margin-left:10px;
  }
  .dataTables_length{
      margin-top:-30px;
      visibility: hidden;
  }
  .dataTables_length select{
      visibility: visible;
  }

  table td {
    white-space: nowrap !important;
  }

  table {
    min-width: 100%;
  }
</style>
    
  <div class="m-content">
      <div class="row">
          <div class="col-lg-12">
              <div class="m-portlet">
                  <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
                      <div class="m-portlet__head-caption">
                          <div class="m-portlet__head-title">
                              <span class="m-portlet__head-icon m--hide">
                                  <i class="la la-gear"></i>
                              </span>

                              @include('label::datalist')

                              <h3 class="m-portlet__head-text">
                                  Benefit COA Master
                              </h3>
                          </div>
                      </div>
                      @component('frontend.common.buttons.read-help')
                        @slot('href', '/benefit-coa-master.pdf/help')
                    @endcomponent
                  </div>
                  <div class="m-portlet m-portlet--mobile">
                      <div class="m-portlet__body pb-5">
                          <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                              <div class="row align-items-center">
                                  <div class="col-xl-8 order-2 order-xl-1">
                                  </div>
                                  <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                      {{-- @component('buttons::create-new')
                                          @slot('text', 'Add Benefit COA')
                                          @slot('data_target', '#modal_benefit_coa')
                                      @endcomponent --}}

                                      <div class="m-separator m-separator--dashed d-xl-none"></div>
                                  </div>
                              </div>
                          </div>

                          @include('benefit-coa-master::modal')

                          {{-- <div class="benefit_coa_datatable" id="scrolling_both"></div> --}}
                          
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-striped table-bordered table-hover table-checkable benefit_coa_datatable">
                                <thead>
                                  <tr>
                                    <th>Code</th>
                                    <th>Benefit Name</th>
                                    <th>Desciption</th>
                                    <th>COA</th>
                                    <th>Approved By</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@push('footer-scripts')
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script>

  let errorHandler = (response) => {

    let message = '';

    if (!('errors' in response)) {
      message = response.message;
    } else {
      errors = response.errors;

      loop = 0;
      $.each(errors, function (index, value) {

        if (!loop) {
          message = value[0]
        }

        loop++;
      })
    }

    toastr.error(message, 'Invalid', {
      timeOut: 2000
    });
  }

  $(document).ready(function () {

    // handle active menu
    let currentUrl = window.location.href;
    let _hash = currentUrl.split('#');
    if (_hash.length < 2) {
        window.location.href=currentUrl+"#faBenefitCoaMaster";
    } else {
        window.location.href=currentUrl;
    }
    // end handle active menu

    let benefit_coa_datatable = $('.benefit_coa_datatable').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: '{{ route("benefit-coa-master.datatables") }}',
      order: [[ 0, "desc" ]],
      columns: [
        {data: 'code_show', name: 'code', defaultContent: '-'},
        {data: 'name', defaultContent: '-'},
        {data: 'description_show', name: 'description', defaultContent: '-'},
        {data: 'coa', defaultContent: '-'},
        {data: 'approved_by', defaultContent: '-'},
        {data: 'action'}
      ],
      drawCallback: function(setting) {

        $('.select2').select2({
          placeholder: '--Select--',
          ajax: {
            url: '{{ route("benefit-coa-master.select2.coa") }}'
          }
        });

      }
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");

    $(document).on('click', '.update-coa-benefit', function () {
      let uuid = $(this).data('uuid');

      let tr = $(this).parents('tr');

      let id_coa = tr.find('select').val();

      let url = '{{ route("benefit-coa-master.update", ":uuid") }}'
      url = url.replace(':uuid', uuid);

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "put",
        url: url,
        data: {
          'id_coa': id_coa
        },
        dataType: "json",
        success: function (response) {
          if (response.status) {
            toastr.success(response.message, 'Success', {
              timeOut: 2000
            });

            benefit_coa_datatable.ajax.reload(null, false);

          } else {
            errorHandler(response);
          }
        },
        error: function(xhr) {
          errorHandler(xhr.responseJSON);
        }
      });

    });
  });
</script>
@endpush
