<button
    id="{{ $id or '' }}"
    type="{{ $type or 'submit' }}"
    name="{{ $name or 'submit' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'success' }}
           btn-{{ $size or 'md' }}
               {{ $class or '' }} add"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
    href="{{ $href or '' }}"
>

    <span>
        <i class="fa {{ $icon or 'fa-caret-right' }}"></i>

        <span>{{ $text or 'Execute' }}</span>
    </span>
</button>
