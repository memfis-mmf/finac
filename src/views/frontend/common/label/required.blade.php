<{{ $html_tag ?? 'span' }}
    class="{{$class ?? ''}}"
    style="font-weight: {{ $font_weight ?? 'bold' }};
    color:{{ $color ?? 'red' }};">

    {{ $text ?? '*' }}

</{{ $html_tag ?? 'span' }}>
