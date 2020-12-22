<button
    id="{{ $id or '' }}"
    type="{{ $type or 'submit' }}"
    name="{{ $name or 'submit' }}"
    value="{{ $value or '' }}"
    class="btn
           btn-{{ $color or 'success' }}
           btn-{{ $size or 'md' }}
               {{ $class or '' }} add"
    style="{{ $style or '' }}"
    target="{{ $target or '' }}"
    data-uuid="{{ $data_uuid or '' }}"
    data-toggle="{{ $data_toggle or '' }}"
    data-target="{{ $data_target or '' }}"
>

    <span>
        <i class="fa {{ $icon or 'fa-save' }}"></i>

        <span>{{ $text or 'Save New' }}</span>
    </span>
</button>
