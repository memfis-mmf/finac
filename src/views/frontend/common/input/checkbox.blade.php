<div class="col-sm-{{ $size ?? '6' }}
            col-md-{{ $size ?? '6' }}
            col-lg-{{ $size ?? '6' }}"
    style="padding-left: {{ $padding_left ?? '0' }};{{ $style_div ?? '' }}"
>
    <label
        class="m-checkbox
               m-checkbox--{{ $color ?? 'primary' }}
               {{ $class ?? '' }}">

        <input
            type="checkbox"
            id="{{ $id ?? ''}}"
            name="{{ $name ?? '' }}"
            class="{{ $class ?? ''}}"
            style="{{ $style ?? ''}}"
            value="{{ $value ?? ''}}"
            onclick="{{ $onclik ?? ''}}"
            {{ $checked ?? ''}}
            {{ $disabled ?? ''}}
        >

        {{ $text ?? '' }}

        <span></span>
    </label>
</div>

<div class="col-sm-{{ $size ?? '6' }}
            col-md-{{ $size ?? '6' }}
            col-lg-{{ $size ?? '6' }} "
    style="padding-left: {{ $padding_left ?? '0' }}"
>
    <span class="m-form__help">
    <i class="fa {{$icon ?? ''}}"></i>
        {{ $help_text ?? '' }}
    </span>
</div>

