@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\ButtonSettings::class;
@endphp

@section('content')
    
    <div class="btn button-edit" id="elm-{{ $unid }}-inner" contenteditable="true" style="display: inline-block !important; margin:3px; white-space:pre">{{ $value->label ?? 'BUTTON TEXT' }}</div>
    <textarea name="{{$path}}[label]" class="button-label" style="display: none"> {{ $value->label ?? '' }}</textarea>

@overwrite
