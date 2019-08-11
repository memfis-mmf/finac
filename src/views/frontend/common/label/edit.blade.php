<span
    class="m-badge
           {{ $color or '' }}
           m-badge--{{ $length or 'wide' }}
           m-badge--{{ $type or 'rounded' }}"
    style="{{ $style or '' }}">

    <i class="{{ $icon or 'la la-pencil-square' }}"></i>

    <span>{{ $text or 'Edit' }}</span>
</span>

@push('header-scripts')
    <style>
        .m-badge {
            margin-right: 5px;
            font-size: 1rem;
        }
    </style>
@endpush
