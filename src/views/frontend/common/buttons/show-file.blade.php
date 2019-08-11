<div>
  <button
      type="{{ $type or 'button' }}"
      id="{{ $id or '' }}"
      name="{{ $name or 'create' }}"
      value="{{ $value or '' }}"
      class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air
            btn-{{ $color or 'accent' }}
            btn-{{ $size or 'sm' }}
                {{ $class or '' }}"
      style="{{ $style or '' }}"
      target="{{ $target or '' }}"
      data-toggle="{{ $data_toggle or 'modal' }}"
      data-target="{{ $data_target or '#' }}"
      {{ $attribute or '' }}
  >

      <span>
          <i class="la la-{{ $icon or 'file-text'}}"></i>
          <span>{{ $text or 'Add' }}</span>
      </span>
  </button>
</div>