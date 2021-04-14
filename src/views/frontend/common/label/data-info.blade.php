<{{ $element ?? 'div'}} id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
    style="background-color: {{ $background_color ?? 'beige' }};
    padding: {{ $padding ?? '15' }}px;"
    class="{{ $class ?? '' }}"
    value="{{ $value ?? '' }}">

    {!! $text ?? '' !!}

</{{ $element ?? 'div'}}>
