@extends('pagebuilder::components.element.show')

@section('content')
    <div class="pb-columns" id="elm-{{ $unid }}-inner" xstyle="display: grid; grid-template-columns: repeat(auto-fit, minmax(0,1fr)); xgap: 1rem">
    @isset($value->e)
        @include('pagebuilder::render.elements', ['elements'=>$value->e, 'unid'=>$unid])
    @endisset
    </div>
@overwrite