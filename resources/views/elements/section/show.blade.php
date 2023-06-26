@extends('pagebuilder::components.element.show')

@section('content')
    <section id="elm-{{ $unid }}" style="display: flex; flex-direction: column;">
        <div class="centralise">
        @isset($value->e)
            @include('pagebuilder::render.elements', ['elements'=>$value->e])
        @endisset
        </div>
    </section>
@overwrite