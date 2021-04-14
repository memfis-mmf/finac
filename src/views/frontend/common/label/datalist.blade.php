<span
    class="m-badge
           {{ $color ?? '' }}
           {{ $length ?? 'm-badge--wide'}}
           m-badge--rounded"
    style="{{ $style ?? '' }}"
>

    <i class="la {{ $icon ?? 'la-th-list' }}"></i>
    <span>{{ $text ?? 'Datalist' }}</span>
</span>

@push('header-scripts')
    <style>
        .m-badge {
            margin-right: 5px;
            font-size: 1rem;
        }
    </style>
@endpush
