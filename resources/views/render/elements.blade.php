@foreach($elements as $unid=>$element)

    {{-- @dd(pagebuilderbladePaths($element->t, 'show')); --}}
    
    {{-- @includeFirst( array_merge( pagebuilderbladePaths($element->t, 'show'), ['pagebuilder::block.missing']), ['value'=>$element])

    @include('pagebuilder::render.element', ['unid'=>$unid, 'element'=>$element]) --}}

    <x-pagebuilder-element path="[e]" :unid="$unid" :value="$element" mode="show"></x-pagebuilder-element>
@endforeach