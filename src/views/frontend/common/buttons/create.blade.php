<a
    href="{{ $href or '' }}"
    id={{ $id or '' }}
    name={{ $name or '' }}
    class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air
            btn-{{ $color or 'primary' }}
            btn-{{ $size or 'md' }}
            {{ $class or '' }}"
    style="{{ $style or '' }}">

    <span>
        <i class="la la-{{ $icon or 'plus-circle'}}"></i>
        <span>{{ $text or 'Add' }}</span>
    </span>
</a>
