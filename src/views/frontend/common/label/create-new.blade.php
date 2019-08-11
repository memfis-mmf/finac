<span
    class="m-badge
           {{ $color or '' }}
           m-badge--{{ $length or 'wide' }}
           m-badge--{{ $type or 'rounded' }}
            {{$class or ''}}"
    style="{{ $style or '' }}">

    <i class="{{ $icon or 'la la-file-o' }}"></i>

    <span>{{ $text or 'Create New' }}</span>
</span>

@push('header-scripts')
    <style>
        .m-badge {
            margin-right: 5px;
            font-size: 1rem;
        }
    </style>
@endpush
