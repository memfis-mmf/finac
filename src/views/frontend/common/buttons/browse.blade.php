<button
    type="{{ $type or 'button' }}"
    id="{{ $id or '' }}"
    name="{{ $name or 'close' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'secondary' }}
           btn-{{ $size or 'md' }}
           {{ $class or '' }}"
    style="{{ $style or '' }}">

    <span>
        <i class="fa {{ $icon or 'fa-times' }}"></i>
        <span>{{ $text or 'Close' }}</span>
    </span>
</button>
