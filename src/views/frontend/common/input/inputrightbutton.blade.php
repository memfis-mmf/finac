<div class="input-group">
    <input name="{{ $name ?? '' }}" id="{{ $id ?? $name }}" data-id="{{$dataid ?? ''}}" type="text" class="form-control m-input
           {{ $class ?? '' }}" value="{{$value ?? ''}}" readonly placeholder="{{ $placeholder ?? '' }}" {{ $disabled ?? '' }}>
    <div class="input-group-append">
        <button {{ $disabled ?? '' }} id="{{ $buttonid ?? '' }}" class="btn m-btn m-btn--custom m-btn--pill btn-primary flaticon-search-1 checkprofit" data-id="{{$dataid ?? ''}}" data-toggle="{{ $data_toggle ?? 'modal' }}" data-target="{{ $data_target ?? '#' }}" type="button"></button>
    </div>
</div>
<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
