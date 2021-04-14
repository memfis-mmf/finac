<textarea
    id="{{ $id ?? '' }}"
    name="{{ $name ?? '' }}"
    rows="{{ $rows ?? '' }}"
    class="form-control m-input m-input--air
           {{ $class ?? '' }}"
    style="{{$style ?? ''}}"
    placeholder="{{ $placeholder ?? '' }}"
    {{$editable ?? ''}} {{ $disabled ?? ''}} {{ $required ?? ''}}>{{$value ?? ''}}</textarea>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
