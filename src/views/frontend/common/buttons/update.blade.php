<button
    type="{{ $type or 'reset' }}"
    id="{{ $id or '' }}"
    name="{{ $name or 'submit' }}"
    class="btn
           btn-{{ $color or 'success' }}
           btn-{{ $size or 'md' }}
               {{ $class or '' }} update"
    style="{{ $style or '' }}"
    value="{{ $value or '' }}"
    target="{{ $target or '' }}">

    <span>
        <i class="fa {{ $icon or 'fa-save' }}"></i>
        <span>{{ $text or ' Save Changes' }}</span>
    </span>
</button>
