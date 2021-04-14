<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'button' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'success' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
>

    <span>
        <i class="fa {{ $icon ?? 'fa-check-circle' }}"></i>

        <span>{{ $text ?? 'Release Task' }}</span>
    </span>
</button>
