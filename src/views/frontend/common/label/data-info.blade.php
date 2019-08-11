<{{ $element or 'div'}} id="{{ $id or '' }}" name="{{ $name or '' }}"
    style="background-color: {{ $background_color or 'beige' }};
    padding: {{ $padding or '15' }}px;"
    class="{{ $class or '' }}"
    value="{{ $value or '' }}">

    {{ $text or '' }}

</{{ $element or 'div'}}>
