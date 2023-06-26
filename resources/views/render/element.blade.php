<div>
    {{ $unid }} :: {{ $element->t }}
    @isset($element->e) 
        @foreach($element->e as $col) {    
            @include('pagebuilder::render.elements', ['elements'=>$col])
        }
    @endisset
</div>