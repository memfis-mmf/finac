<select
    id="{{ $id ?? '' }}"
    name="{{ $name ?? '' }}"
    class="form-control m-select2
           {{ $class ?? '' }}"
    style="{{ $style ?? 'width:100%' }}"
    {{ $multiple ?? '' }}
    {{ $disabled ?? ''}}
    value="{{ $value ?? ''}}"
    > 

    <option value="">
        &mdash; Select {{ $entity ?? '' }} &mdash;
    </option>
</select>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    @if (isset($help_text))
        <i class="fa fa-info-circle m--font-info"></i>
        {{ $help_text }}
    @endif
</span>
