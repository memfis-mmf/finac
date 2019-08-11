<button
    class="btn m-btn--custom
            m-btn--icon
            m-btn--pill
            m-btn--airbtn-brand
            dropdown-toggle
            btn-{{ $color or 'primary' }}
            btn-{{ $size or 'md' }}"
    type={{ $type or 'button' }}
    id={{ $id or '' }}
    data-toggle={{ $dropdown or 'dropdown' }}
    aria-haspopup="true"
    aria-expanded="true">
    {{ $text or '' }}
</button>


{{-- <div class="dropdown show">
        <button class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
           Fontawesome
         </button>
   </div> --}}
