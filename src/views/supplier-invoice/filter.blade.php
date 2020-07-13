<div class="advanceFilter">
    <div class="hidden" id="advanceFilter">
        <div class="form-group m-form__group row">
            <div class="col-sm-3 col-md-3 col-lg-3">
                <label class="form-control-label">
                    Date Period
                </label>
          
                @component('input::datepicker')
                    @slot('id', 'daterange_journal')
                    @slot('name', 'daterange_journal')
                    @slot('id_error', 'daterange_journal')
                @endcomponent
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
                window.location.href=currentUrl+"#faAP";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/journal.js')}}"></script>
@endpush
