<span
    class="m-badge
           m-badge--{{ $color or 'warning' }}
           m-badge--{{ $length or 'wide' }}
           m-badge--{{ $type or 'rounded' }}"
    style="background-color: {{ $background_color or 'beige' }};
           padding: {{ $padding or '5px 10px' }};">

    {{ $text or '' }}
</span>
