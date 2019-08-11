<div class="custom-file">
    <input
        type="file"
        id="{{ $id or '' }}"
        name="{{ $name or '' }}"
        class="custom-file-input
               {{ $class or '' }}"
        style="{{$style or ''}}"
    >

    <label class="custom-file-label"
           for="{{ $for or '' }}"
           id="{{ $id or '' }}-label"
    >

        {{ $text or '' }}

    </label>
</div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
