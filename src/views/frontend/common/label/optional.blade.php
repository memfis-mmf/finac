<{{ $html_tag or 'small' }}
    class="text-{{ $color or 'muted' }}"
    style="font-weight: {{ $font_weight or 'normal' }};
                        {{ $style or '' }};">

    (<em>{{ $text or 'optional' }}</em>)

</{{ $html_tag or 'small' }}>
