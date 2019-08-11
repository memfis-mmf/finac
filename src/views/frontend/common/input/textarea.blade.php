<textarea
    id="{{ $id or '' }}"
    name="{{ $name or '' }}"
    rows="{{ $rows or '' }}"
    class="form-control m-input m-input--air
           {{ $class or '' }}"
    style="{{$style or ''}}"
    placeholder="{{ $placeholder or '' }}"
    {{$editable or ''}} {{ $disabled or ''}} {{ $required or ''}}>{{$value or ''}}</textarea>

<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
