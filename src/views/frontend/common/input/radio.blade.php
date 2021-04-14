<label
    class="m-radio m-radio--state-{{ $color ?? 'primary' }}
           {{ $label_class ?? '' }}"
    style="{{ $label_style ?? '' }}"
>

    <input
        type="radio"
        id="{{ $id ?? ''}}"
        name="{{ $name ?? '' }}"
        class="{{ $class ?? ''}}"
        style="{{ $style ?? ''}}"
        value="{{ $value ?? '' }}"
        onclick="{{ $onclick ?? '' }}"
        {{ $disabled ?? ''}}
        {{ $checked ?? ''}}
        {{ $required ?? ''}}
    >

    {{ $text ?? '' }}

    <span></span>
</label>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
