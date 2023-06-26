@extends('pagebuilder::components.element.show')

@section('content')
    <div class="pb-column" id="elm-{{ $unid }}">
        @isset($value->e)
            @include('pagebuilder::render.elements', ['elements'=>$value->e])
        @endisset
    </div>
@overwrite