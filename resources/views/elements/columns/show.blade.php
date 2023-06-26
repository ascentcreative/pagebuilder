@extends('pagebuilder::components.element.show')

@section('content')
    <div class="pb-columns centralise" id="elm-{{ $unid }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(0,1fr)); gap: 1rem">
    @isset($value->e)
        @include('pagebuilder::render.elements', ['elements'=>$value->e])
    @endisset
    </div>
@overwrite