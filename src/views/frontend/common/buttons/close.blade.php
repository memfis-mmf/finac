<button
    type="{{ $type ?? 'button' }}"
    id="{{ $id ?? '' }}"
    name="{{ $name ?? 'close' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'secondary' }}
           btn-{{ $size ?? 'md' }}
           {{ $class ?? '' }} clse"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    data-toggle="{{ $data_toggle ?? 'modal' }}"
    data-target="{{ $data_target ?? '#' }}"
    {{ $attribute ?? '' }}
    data-dismiss="{{ $data_dismiss ?? 'modal' }}">
    <span>
        <i class="fa {{ $icon ?? 'fa-times' }}"></i>
        <span>{{ $text ?? 'Close' }}</span>
    </span>
</button>
