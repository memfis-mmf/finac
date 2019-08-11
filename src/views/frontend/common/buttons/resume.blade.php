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
>

    <span>
        <i class="fa {{ $icon or 'fa-caret-right' }}"></i>

        <span>{{ $text or 'Resume' }}</span>
    </span>
</button>
