<div class="input-group date">
    <input
        type="text"
        id="{{ $id ?? 'm_datepicker_1' }}"
        name="{{ $name ?? '' }}"
        class="form-control
            {{$class ?? ''}}"
        style="{{$style ?? ''}}"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $disabled ?? ''}}
        value="{{ $value ?? ''}}"
        readonly
    >
    <div class="input-group-append">
        <span class="input-group-text">
        <i class="la la-calendar glyphicon-th"></i>
        </span>
    </div>
</div>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
