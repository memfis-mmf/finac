<div
    class="m-typeahead">
        <input class="form-control m-input
                      {{ $class or '' }}"
               id="{{ $id or '' }}"
               name="{{ $name or '' }}"
               type="text">
</div>

<div class="form-control-feedback text-danger" id="{{ $id_error or '' }}-error"></div>

<span class="m-form__help">
    {{ $help_text or '' }}
</span>
