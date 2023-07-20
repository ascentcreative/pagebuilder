@extends('pagebuilder::components.element.show')

@section('content')

    @isset($value->e)
        @include('pagebuilder::render.elements', ['elements'=>$value->e, 'unid'=>$unid])
    @endisset
    
@overwrite