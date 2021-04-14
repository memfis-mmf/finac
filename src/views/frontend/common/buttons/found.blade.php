<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'submit' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'primary' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    href="{{ $href ?? '' }}"

>

    <span>
        <i class="fab {{ $icon ?? 'fa-get-pocket' }}"></i>

        <span>{{ $text ?? 'Found Discrepancy' }}</span>
    </span>
</button>
