<{{ $html_tag ?? 'small' }}
    class="text-{{ $color ?? 'muted' }}"
    style="font-weight: {{ $font_weight ?? 'normal' }};
                        {{ $style ?? '' }};">

    (<em>{{ $text ?? 'optional' }}</em>)

</{{ $html_tag ?? 'small' }}>
