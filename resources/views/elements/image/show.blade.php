@extends('pagebuilder::components.element.show')

@section('content')
    {{-- @dump($value) --}}
    @isset($value->link)
        <a href="{{ $value->link }}" @if($value->newwindow ?? false) target="_blank" @endif>
    @endisset
        <img src="/image/max/{{ $value->image->hashed_filename }}" class="image-element" style="xmax-width: 100%" id="elm-{{ $unid }}-inner" alt="{{ $value->alt ?? ''}}"/>
    @isset($value->link)</a>@endisset

@overwrite