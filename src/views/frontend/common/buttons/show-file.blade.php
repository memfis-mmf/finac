<div>
  <button
      type="{{ $type ?? 'button' }}"
      id="{{ $id ?? '' }}"
      name="{{ $name ?? 'create' }}"
      value="{{ $value ?? '' }}"
      class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air
            btn-{{ $color ?? 'accent' }}
            btn-{{ $size ?? 'sm' }}
                {{ $class ?? '' }}"
      style="{{ $style ?? '' }}"
      target="{{ $target ?? '' }}"
      data-toggle="{{ $data_toggle ?? 'modal' }}"
      data-target="{{ $data_target ?? '#' }}"
      {{ $attribute ?? '' }}
  >

      <span>
          <i class="la la-{{ $icon ?? 'file-text'}}"></i>
          <span>{{ $text ?? 'Add' }}</span>
      </span>
  </button>
</div>