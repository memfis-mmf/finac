<span
    class="m-badge
           {{ $color ?? '' }}
           m-badge--{{ $length ?? 'wide' }}
           m-badge--{{ $type ?? 'rounded' }}"
    style="{{ $style ?? '' }}">

    <i class="{{ $icon ?? 'la la-pencil-square' }}"></i>

    <span>{{ $text ?? 'Edit' }}</span>
</span>

@push('header-scripts')
    <style>
        .m-badge {
            margin-right: 5px;
            font-size: 1rem;
        }
    </style>
@endpush
