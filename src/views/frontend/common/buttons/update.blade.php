<button
    type="{{ $type ?? 'reset' }}"
    id="{{ $id ?? '' }}"
    name="{{ $name ?? 'submit' }}"
    class="btn
           btn-{{ $color ?? 'success' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} update"
    style="{{ $style ?? '' }}"
    value="{{ $value ?? '' }}"
    target="{{ $target ?? '' }}">

    <span>
        <i class="fa {{ $icon ?? 'fa-save' }}"></i>
        <span>{{ $text ?? ' Save Changes' }}</span>
    </span>
</button>
