<div>
        <span class="m-switch 
                    m-switch--outline 
                    m-switch--icon
                    m-switch--{{ $size ?? 'md' }}">
                <label>
                    <input type="checkbox" 
                            {{ $checked ?? ''}}
                            name="{{ $name ?? ''}}"
                            id="{{ $id ?? ''}}">
                    <span></span>
                </label>
        </span>

</div>
