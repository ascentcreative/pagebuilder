@extends('pagebuilder::components.element.show')

@section('content')
{{-- @dump($value) --}}
    <img src="/image/max/{{ $value->image->hashed_filename }}" style="xmax-width: 100%" id="elm-{{ $unid }}"/>
@overwrite