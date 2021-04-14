<a
    href="{{ $href ?? '' }}"
    id={{ $id ?? '' }}
    name={{ $name ?? '' }}
    class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air
            btn-{{ $color ?? 'primary' }}
            btn-{{ $size ?? 'md' }}
                {{ $class ?? '' }}"
    style="{{ $style ?? '' }}">

    <span>
        <i class="la la-{{ $icon ?? 'refresh'}}"></i>
        {{ $text ?? 'refresh' }}
    </span>
</a>
