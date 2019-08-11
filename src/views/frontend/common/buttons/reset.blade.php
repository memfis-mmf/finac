<button
    id="{{ $id or '' }}"
    type="{{ $type or 'reset' }}"
    name="{{ $name or 'reset' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'warning' }}
           btn-{{ $size or 'md' }}
           {{ $class or '' }} reset"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
>

    <span>
        <i class="fa {{ $icon or 'fa-undo' }}"></i>

        <span>{{ $text or 'Reset' }}</span>
    </span>
</button>
