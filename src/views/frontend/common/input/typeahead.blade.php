<div
    class="m-typeahead">
        <input class="form-control m-input
                      {{ $class ?? '' }}"
               id="{{ $id ?? '' }}"
               name="{{ $name ?? '' }}"
               type="text">
</div>

<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text ?? '' }}
</span>
