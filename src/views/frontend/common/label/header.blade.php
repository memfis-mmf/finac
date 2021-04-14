<{{ $element ?? 'div'}} id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
    style="background-color: {{ $background_color ?? 'beige' }};
    padding: {{ $padding ?? '15' }}px;
    text-align:{{ $align ?? 'center'}};"
    class="{{ $class ?? '' }}">

    <h1>{{ $text ?? '' }}</h1>

</{{ $element ?? 'div'}}>
