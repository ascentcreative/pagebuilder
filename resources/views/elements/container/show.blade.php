@extends('pagebuilder::components.element.show')

@section('content')
    <div id="elm-{{ $unid }}-innerr" xstyle="display: flex; flex-direction: column;">
        @isset($value->e)
            @include('pagebuilder::render.elements', ['elements'=>$value->e, 'unid'=>$unid])
        @endisset
    </div>
    
@overwrite