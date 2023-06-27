{{-- Dummy field which ensures e will be set on container elements when saved --}}
@php
    // if(is_array($value))
    $value = json_decode(json_encode($value));
@endphp
<input name="{{ $path }}[e]" value="" type="hidden">
{{-- @if(property_exists($value, 'e')) --}}
    <div class="pb-elementlist pb-elementlist-{{ $listtype ?? 'general' }}" data-listtype="{{ $listtype ?? 'general' }}">
        @foreach(($value->e ?? []) as $unid=>$element)
            <x-pagebuilder-element path="{{ $path }}[e]" :unid="$unid" :value="$element"></x-pagebuilder-element>
        @endforeach 
    </div>
{{-- @endisset --}}
{{-- @endif --}}
