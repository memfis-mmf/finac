<input
    type="text"
    id="{{ $id ?? $name }}"
    name="{{ $name ?? '' }}"
    class="form-control m-input
           {{ $class ?? '' }}"
    style="{{$style ?? ''}}"
    value="{{$value ?? ''}}"
    placeholder="{{ $placeholder ?? '' }}"
    {{$editable ?? ''}}
    {{$readonly ?? ''}}
    {{ (@$disabled)? 'disabled="disabled"': '' }}
>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>

{{-- refactor --}}
