@extends('pagebuilder::components.element.show')

@section('content')
    {{-- <section id="elm-{{ $unid }}-inner" style="display: flex; flex-direction: column;"> --}}
        {{-- <div class="centralise"> --}}
        @isset($value->e)
            @include('pagebuilder::render.elements', ['elements'=>$value->e, 'unid'=>$unid])
        @endisset
        {{-- </div> --}}
    {{-- </section> --}}
@overwrite