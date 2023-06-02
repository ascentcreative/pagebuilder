
{{-- Dummy field which ensures e will be set on container elements when saved --}}
<input name="{{ $path}}[e]" value="" type="hidden">
@if(property_exists($value, 'e'))
    <div class="pb-element-list">
{{-- @isset($value->e)   --}}
        @if(is_null($value->e) || count((array) $value->e) == 0)
            No elements found 
        @else
            @foreach($value->e as $unid=>$element)
                <x-pagebuilder-element path="{{ $path }}[e]" :unid="$unid" :value="$element"></x-pagebuilder-element>
            @endforeach 
        @endif
    </div>
{{-- @endisset --}}
@endif
