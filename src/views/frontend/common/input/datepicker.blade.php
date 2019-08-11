<div class="input-group date">
    <input
        type="text"
        id="{{ $id or 'm_datepicker_1' }}"
        name="{{ $name or '' }}"
        class="form-control
            {{$class or ''}}"
        style="{{$style or ''}}"
        placeholder="{{ $placeholder or '' }}"
        {{ $disabled or ''}}
        value="{{ $value or ''}}"
        readonly
    >
    <div class="input-group-append">
        <span class="input-group-text">
        <i class="la la-calendar glyphicon-th"></i>
        </span>
    </div>
</div>

<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
