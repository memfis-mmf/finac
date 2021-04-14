<button
    type="{{ $type ?? 'button' }}"
    id="{{ $id ?? '' }}"
    name="{{ $name ?? 'close' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'secondary' }}
           btn-{{ $size ?? 'md' }}
           {{ $class ?? '' }}"
    style="{{ $style ?? '' }}">

    <span>
        <i class="fa {{ $icon ?? 'fa-times' }}"></i>
        <span>{{ $text ?? 'Close' }}</span>
    </span>
</button>
