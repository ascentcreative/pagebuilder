{{-- Dummy field which ensures e will be set on container elements when saved --}}
<input name="{{ $path }}[e]" value="" type="hidden">
@if(property_exists($value, 'e'))
    <div class="pb-columns">
    @php $i = 0; @endphp
    @foreach($value->e as $colunid=>$col)
    <div id="pb-column-{{ $colunid }}" class="pb-elementlist pb-column pb-elementlist-{{ $listtype ?? 'general' }}" data-unid="{{ $colunid }}" data-listtype="{{ $listtype ?? 'general' }}">
        <input name="{{ $path }}[e][{{ $colunid }}]" value="" type="hidden">
        @if(!is_null($col) && count((array) $col) != 0)
            @foreach($col as $unid=>$element)
                <x-pagebuilder-element path="{{ $path }}[e][{{ $colunid }}]" :unid="$unid" :value="$element"></x-pagebuilder-element>
            @endforeach 
        @endif</div>
        @php $i++; @endphp
    @endforeach
    </div>
{{-- @endisset --}}
@endif
