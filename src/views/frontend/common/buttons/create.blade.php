<a
    href="{{ $href ?? '' }}"
    id={{ $id ?? '' }}
    name={{ $name ?? '' }}
    class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air
            btn-{{ $color ?? 'primary' }}
            btn-{{ $size ?? 'md' }}
            {{ $class ?? '' }}"
    style="{{ $style ?? '' }}">

    <span>
        <i class="la la-{{ $icon ?? 'plus-circle'}}"></i>
        <span>{{ $text ?? 'Add' }}</span>
    </span>
</a>
