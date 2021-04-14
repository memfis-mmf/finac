<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'submit' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'success' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    href="{{ $href ?? '' }}"
>

    <span>
        <i class="fa {{ $icon ?? 'fa-caret-right' }}"></i>

        <span>{{ $text ?? 'Execute' }}</span>
    </span>
</button>
