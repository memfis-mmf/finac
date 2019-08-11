<div class="col-sm-{{ $size or '6' }}
            col-md-{{ $size or '6' }}
            col-lg-{{ $size or '6' }}"
    style="padding-left: {{ $padding_left or '0' }};{{ $style_div or '' }}"
>
    <label
        class="m-checkbox
               m-checkbox--{{ $color or 'primary' }}
               {{ $class or '' }}">

        <input
            type="checkbox"
            id="{{ $id or ''}}"
            name="{{ $name or '' }}"
            class="{{ $class or ''}}"
            style="{{ $style or ''}}"
            value="{{ $value or ''}}"
            onclick="{{ $onclik or ''}}"
            {{ $checked or ''}}
            {{ $disabled or ''}}
        >

        {{ $text or '' }}

        <span></span>
    </label>
</div>

<div class="col-sm-{{ $size or '6' }}
            col-md-{{ $size or '6' }}
            col-lg-{{ $size or '6' }} "
    style="padding-left: {{ $padding_left or '0' }}"
>
    <span class="m-form__help">
    <i class="fa {{$icon or ''}}"></i>
        {{ $help_text or '' }}
    </span>
</div>

