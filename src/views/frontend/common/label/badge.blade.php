<span
    class="m-badge
           m-badge--{{ $color ?? 'warning' }}
           m-badge--{{ $length ?? 'wide' }}
           m-badge--{{ $type ?? 'rounded' }}"
    style="background-color: {{ $background_color ?? 'beige' }};
           padding: {{ $padding ?? '5px 10px' }};">

    {{ $text ?? '' }}
</span>
