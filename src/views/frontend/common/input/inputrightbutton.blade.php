<div class="input-group">
    <input name="{{ $name or '' }}" id="{{ $id or $name }}" type="text" class="form-control m-input
           {{ $class or '' }}" value="{{$value or ''}}" readonly placeholder="{{ $placeholder or '' }}">
    <div class="input-group-append">
        <button class="btn m-btn m-btn--custom m-btn--pill btn-primary flaticon-search-1" data-toggle="{{ $data_toggle or 'modal' }}" data-target="{{ $data_target or '#' }}" type="button"></button>
    </div>
</div>
<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>