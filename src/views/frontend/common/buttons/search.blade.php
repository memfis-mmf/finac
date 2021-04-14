<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'submit' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'primary' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} search"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
>

    <span>
        <i class="fa {{ $icon ?? 'fa-search' }}"></i>

        <span>{{ $text ?? 'Search' }}</span>
    </span>
</button>
