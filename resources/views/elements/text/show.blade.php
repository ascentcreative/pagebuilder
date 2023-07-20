@extends('pagebuilder::components.element.show')

@section('content')
    {{-- <div id="elm-{{ $unid }}"> --}}
        {!! $value->content !!}
    {{-- </div> --}}
@overwrite