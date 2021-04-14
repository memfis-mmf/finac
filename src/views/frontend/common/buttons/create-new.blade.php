<button
    type="{{ $type ?? 'button' }}"
    id="{{ $id ?? '' }}"
    name="{{ $name ?? 'create' }}"
    value="{{ $value ?? '' }}"
    class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air
           btn-{{ $color ?? 'primary' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }}"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    data-toggle="{{ $data_toggle ?? 'modal' }}"
    data-target="{{ $data_target ?? '#' }}"
    {{ $attribute ?? '' }}
>

    <span>
        <i class="la la-{{ $icon ?? 'plus-circle'}}"></i>
        <span>{{ $text ?? 'Add' }}</span>
    </span>
</button>
