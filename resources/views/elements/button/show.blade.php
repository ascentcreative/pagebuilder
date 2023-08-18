@extends('pagebuilder::components.element.show')

@section('content')
    <a href="{{ $value->link ?? "#"}}" class="btn" id="elm-{{ $unid }}-inner">{{ $value->label ?? 'BUTTON TEXT' }}</a>
    {{-- <a href="#" class="btn">{{LABEL VALU}}E</a> --}}
@overwrite