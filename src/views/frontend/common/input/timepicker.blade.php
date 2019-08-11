<input
    type="text"
    id="{{ $id or 'm_timepicker_1' }}"
    name="{{ $name or '' }}"
    class="form-control {{$class or ''}}"
    style="{{$style or ''}}"
    placeholder="{{ $placeholder or 'Select time'}}"
    readonly
>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
