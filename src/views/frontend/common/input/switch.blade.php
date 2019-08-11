<div>
        <span class="m-switch 
                    m-switch--outline 
                    m-switch--icon
                    m-switch--{{ $size or 'md' }}">
                <label>
                    <input type="checkbox" 
                            {{ $checked or ''}}
                            name="{{ $name or ''}}"
                            id="{{ $id or ''}}">
                    <span></span>
                </label>
        </span>

</div>
