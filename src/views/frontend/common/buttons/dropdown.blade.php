<button
    class="btn m-btn--custom
            m-btn--icon
            m-btn--pill
            m-btn--airbtn-brand
            dropdown-toggle
            btn-{{ $color ?? 'primary' }}
            btn-{{ $size ?? 'md' }}"
    type={{ $type ?? 'button' }}
    id={{ $id ?? '' }}
    data-toggle={{ $dropdown ?? 'dropdown' }}
    aria-haspopup="true"
    aria-expanded="true">
    {{ $text ?? '' }}
</button>


{{-- <div class="dropdown show">
        <button class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
           Fontawesome
         </button>
   </div> --}}
