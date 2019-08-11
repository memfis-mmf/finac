<button
    type="{{ $type or 'button' }}"
    id="{{ $id or '' }}"
    name="{{ $name or 'create' }}"
    value="{{ $value or '' }}"
    class="btn
    btn-{{ $color or 'warning' }}
    btn-{{ $size or 'md' }}
        {{ $class or '' }} add"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
    data-toggle="{{ $data_toggle or 'modal' }}"
    data-target="{{ $data_target or '#' }}"
    {{ $attribute or '' }}
>

    <span>
        <i class="fa {{ $icon or 'fa-pause' }}"></i>

        <span>{{ $text or 'Pause/Pending' }}</span>
    </span>
</button>
