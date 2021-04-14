<input
    type="text"
    id="{{ $id ?? 'm_timepicker_1' }}"
    name="{{ $name ?? '' }}"
    class="form-control {{$class ?? ''}}"
    style="{{$style ?? ''}}"
    placeholder="{{ $placeholder ?? 'Select time'}}"
    readonly
>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
