<select
    id="{{ $id or '' }}"
    name="{{ $name or '' }}"
    class="form-control m-select2
           {{ $class or '' }}"
    style="{{ $style or 'width:100%' }}"
    {{ $multiple or '' }}
    {{ $disabled or ''}}
    value="{{ $value or ''}}"
    > 

    <option value="">
        &mdash; Select {{ $entity or '' }} &mdash;
    </option>
</select>

<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    @if (isset($help_text))
        <i class="fa fa-info-circle m--font-info"></i>
        {{ $help_text }}
    @endif
</span>
