<select id="category" name="category"  class="form-control m-select2">
        <option value="">
            &mdash; Select Category &mdash;
        </option>
        @if($parameter1 or ''->isEmpty())
        {{-- @foreach("{{$parameter2 or ''}}" as $category)
            <option value="{{$category->id}}">
                {{$category->name}}
            </option>
        @endforeach  --}}
        {{-- @else
        @foreach("{{$parameter2 or ''}}" as $aKey => $aSport)
            @foreach("{{$parameter1 or ''}}" as $aItemKey => $aItemSport)
                <option value="{{$aSport->id}}" @if($aSport->id == $aItemSport->id)selected="selected"@endif>{{$aSport->name}}</option>
            @endforeach
        @endforeach --}}
        @endif
</select>

{{-- $category_items --}}