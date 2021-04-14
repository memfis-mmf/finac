<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'submit' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'metal' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
>

    <span>
        <i class="fa {{ $icon ?? 'fa-print' }}"></i>

        <span>{{ $text ?? 'Print' }}</span>
    </span>
</button>
