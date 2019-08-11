<button
    id="{{ $id or '' }}"
    type="{{ $type or 'submit' }}"
    name="{{ $name or 'submit' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'primary' }}
           btn-{{ $size or 'md' }}
               {{ $class or '' }} search"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
>

    <span>
        <i class="fa {{ $icon or 'fa-search' }}"></i>

        <span>{{ $text or 'Search' }}</span>
    </span>
</button>
