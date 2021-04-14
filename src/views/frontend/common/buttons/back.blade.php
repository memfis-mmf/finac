<a
    id={{ $id ?? '' }}
    name={{ $name ?? '' }}
    class="btn
           btn-{{ $color ?? 'secondary' }}
           btn-{{ $size ?? 'md' }}
           {{ $class ?? '' }}"
    style="{{ $style ?? '' }}"
    onclick="goBack()">

    <span>
        <i class="la la-{{ $icon ?? 'undo' }}"></i>
    </span>

    {{ $text ?? 'Back' }}
</a>
