<select id="category" name="category"  class="form-control m-select2">
        <option value="">
            &mdash; Select Category &mdash;
        </option>
        @if($parameter1 ?? ''->isEmpty())
        {{-- @foreach("{{$parameter2 ?? ''}}" as $category)
            <option value="{{$category->id}}">
                {{$category->name}}
            </option>
        @endforeach  --}}
        {{-- @else
        @foreach("{{$parameter2 ?? ''}}" as $aKey => $aSport)
            @foreach("{{$parameter1 ?? ''}}" as $aItemKey => $aItemSport)
                <option value="{{$aSport->id}}" @if($aSport->id == $aItemSport->id)selected="selected"@endif>{{$aSport->name}}</option>
            @endforeach
        @endforeach --}}
        @endif
</select>

{{-- $category_items --}}