<input
    type="text"
    id="{{ $id or $name }}"
    name="{{ $name or '' }}"
    class="form-control m-input
           {{ $class or '' }}"
    style="{{$style or ''}}"
    value="{{$value or ''}}"
    placeholder="{{ $placeholder or '' }}"
    {{$editable or ''}}
>

<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
