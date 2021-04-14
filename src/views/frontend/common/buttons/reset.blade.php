<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'reset' }}"
    name="{{ $name ?? 'reset' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'warning' }}
           btn-{{ $size ?? 'md' }}
           {{ $class ?? '' }} reset"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
>

    <span>
        <i class="fa {{ $icon ?? 'fa-undo' }}"></i>

        <span>{{ $text ?? 'Reset' }}</span>
    </span>
</button>
