<div class="input-group">
    <table style="width:{{ $width ?? '100%' }};" >
        <tr>
            @if (isset($input_prepend))
                <td style="width:5%;">
                    <div class="input-group-append">
                        <span class="input-group-text">
                                {{ $input_prepend ?? '' }}
                            </span>
                    </div>
                </td>
            @endif

            <td style="width: 90%;">
                <input type="number" id="{{ $id ?? $name }}" name="{{ $name ?? '' }}" class="form-control m-input
                           {{ $class ?? '' }}" style="{{ $style ?? ''}}" value="{{ $value ?? ''}}" placeholder="{{ $placeholder ?? '' }}"
                    readonly min="{{ $min ?? ''}}" max="{{ $max ?? ''}}">
            </td>

            @if (isset($input_append))
                <td style="width: 5%;">
                    <div class="input-group-append">
                        <span class="input-group-text">
                                {{ $input_append ?? '' }}
                            </span>
                    </div>
                </td>
            @endif
        </tr>
    </table>
</div>
<div class="form-control-feedback text-danger" id="{{ $id_error ?? '' }}-error"></div>
<div>
    <span class="m-form__help">
        {{ $help_text ?? '' }}
    </span>
</div>
