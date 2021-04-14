<div class="custom-file">
    <input
        type="file"
        id="{{ $id ?? '' }}"
        name="{{ $name ?? '' }}"
        class="custom-file-input
               {{ $class ?? '' }}"
        style="{{$style ?? ''}}"
    >

    <label class="custom-file-label"
           for="{{ $for ?? '' }}"
           id="{{ $id ?? '' }}-label"
    >

        {{ $text ?? '' }}

    </label>
</div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
