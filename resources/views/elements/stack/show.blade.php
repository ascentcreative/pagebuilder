@extends('pagebuilder::components.element.show')

@section('content')
    <div class="pb-stack" id="elm-{{ $unid }}">
    @isset($value->e)
        @include('pagebuilder::render.elements', ['elements'=>$value->e, 'unid'=>$unid])
    @endisset
    </div>
@overwrite