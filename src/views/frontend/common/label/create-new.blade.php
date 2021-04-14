<span
    class="m-badge
           {{ $color ?? '' }}
           m-badge--{{ $length ?? 'wide' }}
           m-badge--{{ $type ?? 'rounded' }}
            {{$class ?? ''}}"
    style="{{ $style ?? '' }}">

    <i class="{{ $icon ?? 'la la-file-o' }}"></i>

    <span>{{ $text ?? 'Create New' }}</span>
</span>

@push('header-scripts')
    <style>
        .m-badge {
            margin-right: 5px;
            font-size: 1rem;
        }
    </style>
@endpush
