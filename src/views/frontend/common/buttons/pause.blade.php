<button
    type="{{ $type ?? 'button' }}"
    id="{{ $id ?? '' }}"
    name="{{ $name ?? 'create' }}"
    value="{{ $value ?? '' }}"
    class="btn
    btn-{{ $color ?? 'warning' }}
    btn-{{ $size ?? 'md' }}
        {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    data-toggle="{{ $data_toggle ?? 'modal' }}"
    data-target="{{ $data_target ?? '#' }}"
    {{ $attribute ?? '' }}
>

    <span>
        <i class="fa {{ $icon ?? 'fa-pause' }}"></i>

        <span>{{ $text ?? 'Pause/Pending' }}</span>
    </span>
</button>
