<select
        id="{{ $id ?? '' }}"
        name="{{ $name ?? '' }}"
        class="form-control m-input
               {{ $class ?? '' }}"
        style="{{ $style ?? '' }}"
        {{ $multiple ?? '' }}
        {{ $required ?? '' }}
>

    <option value="">
        &mdash; Select {{ $entity ?? '' }} &mdash;
    </option>

    {!! $option ?? null !!}

</select>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
