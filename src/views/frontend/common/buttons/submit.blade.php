<button
    id="{{ $id ?? '' }}"
    type="{{ $type ?? 'submit' }}"
    name="{{ $name ?? 'submit' }}"
    value="{{ $value ?? '' }}"
    class="btn
           btn-{{ $color ?? 'success' }}
           btn-{{ $size ?? 'md' }}
               {{ $class ?? '' }} add"
    style="{{ $style ?? '' }}"
    target="{{ $target ?? '' }}"
    data-uuid="{{ $data_uuid ?? '' }}"
    data-toggle="{{ $data_toggle ?? '' }}"
    data-target="{{ $data_target ?? '' }}"
>

    <span>
        <i class="{{ $iconlibrary ?? 'fa' }} {{ $icon ?? 'fa-save' }}"></i>

        <span>{{ $text ?? 'Save New' }}</span>
    </span>
</button>
