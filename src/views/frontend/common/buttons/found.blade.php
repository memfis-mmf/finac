<button
    id="{{ $id or '' }}"
    type="{{ $type or 'submit' }}"
    name="{{ $name or 'submit' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'primary' }}
           btn-{{ $size or 'md' }}
               {{ $class or '' }} add"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
    href="{{ $href or '' }}"

>

    <span>
        <i class="fab {{ $icon or 'fa-get-pocket' }}"></i>

        <span>{{ $text or 'Found Discrepancy' }}</span>
    </span>
</button>
