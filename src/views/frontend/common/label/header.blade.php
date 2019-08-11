<{{ $element or 'div'}} id="{{ $id or '' }}" name="{{ $name or '' }}"
    style="background-color: {{ $background_color or 'beige' }};
    padding: {{ $padding or '15' }}px;
    text-align:{{ $align or 'center'}};"
    class="{{ $class or '' }}">

    <h1>{{ $text or '' }}</h1>

</{{ $element or 'div'}}>
